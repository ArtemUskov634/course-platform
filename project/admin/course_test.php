<?php
require __DIR__ . '/../includes/auth.php';
requireRole('admin');
require __DIR__ . '/../config/db.php';

$courseId = (int)($_GET['course_id'] ?? 0);

$stmt = $pdo->prepare('SELECT id, title FROM courses WHERE id = ?');
$stmt->execute([$courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    header('Location: courses.php');
    exit;
}

// Тест этого курса (false, если ещё не создан)
$stmt = $pdo->prepare('SELECT * FROM tests WHERE course_id = ?');
$stmt->execute([$courseId]);
$test = $stmt->fetch(PDO::FETCH_ASSOC);

$testError     = '';
$questionError = '';

// Значения для формы вопроса (чтобы при ошибке ничего не терялось)
$qText       = '';
$formAnswers = ['', '', '', ''];
$formCorrect = -1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // На странице несколько форм, различаем их по скрытому полю action
    $action = $_POST['action'] ?? '';

    // ---------- 1) Создание или изменение теста ----------
    if ($action === 'save_test') {
        $testTitle = trim($_POST['test_title'] ?? '');
        $pass      = (int)($_POST['pass_percent'] ?? 0);

        if ($testTitle === '') {
            $testError = 'Podaj nazwę testu.';
        } elseif ($pass < 1 || $pass > 100) {
            $testError = 'Próg zaliczenia musi być liczbą od 1 do 100.';
        } else {
            if ($test) {
                $stmt = $pdo->prepare('UPDATE tests SET title = ?, pass_percent = ? WHERE id = ?');
                $stmt->execute([$testTitle, $pass, $test['id']]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO tests (course_id, title, pass_percent) VALUES (?, ?, ?)');
                $stmt->execute([$courseId, $testTitle, $pass]);
            }
            header('Location: course_test.php?course_id=' . $courseId);
            exit;
        }
    }

    // ---------- 2) Добавление вопроса ----------
    if ($action === 'add_question' && $test) {
        $qText   = trim($_POST['question_text'] ?? '');
        $posted  = $_POST['answers'] ?? [];
        $correct = (int)($_POST['correct'] ?? -1);

        if (is_array($posted)) {
            $formAnswers = array_pad(array_map('trim', $posted), 4, '');
        }
        $formCorrect = $correct;

        // Оставляем только непустые ответы и помечаем, какой из них правильный.
        // $i - номер поля (0..3), он совпадает со значением выбранной радиокнопки.
        $clean = [];
        foreach ($formAnswers as $i => $a) {
            if ($a !== '') {
                $clean[] = ['text' => $a, 'correct' => ($i === $correct) ? 1 : 0];
            }
        }
        $hasCorrect = false;
        foreach ($clean as $c) {
            if ($c['correct'] === 1) {
                $hasCorrect = true;
            }
        }

        if ($qText === '') {
            $questionError = 'Wpisz treść pytania.';
        } elseif (count($clean) < 2) {
            $questionError = 'Podaj co najmniej dwie odpowiedzi.';
        } elseif (!$hasCorrect) {
            $questionError = 'Zaznacz poprawną odpowiedź (musi być wypełniona).';
        } else {
            // Транзакция: вопрос и ответы сохраняются ВМЕСТЕ или не сохраняются вообще.
            // Иначе при сбое мог бы остаться вопрос без ответов.
            try {
                $pdo->beginTransaction();

                $stmt = $pdo->prepare('INSERT INTO questions (test_id, question_text) VALUES (?, ?)');
                $stmt->execute([$test['id'], $qText]);
                $questionId = $pdo->lastInsertId();   // id только что созданного вопроса

                $stmt = $pdo->prepare(
                    'INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)'
                );
                foreach ($clean as $c) {
                    $stmt->execute([$questionId, $c['text'], $c['correct']]);
                }

                $pdo->commit();   // подтверждаем всё сразу
            } catch (Exception $e) {
                $pdo->rollBack(); // при ошибке отменяем всё
                throw $e;
            }

            header('Location: course_test.php?course_id=' . $courseId);
            exit;
        }
    }

    // ---------- 3) Удаление вопроса ----------
    if ($action === 'delete_question' && $test) {
        $qid = (int)($_POST['question_id'] ?? 0);
        // AND test_id = ? гарантирует, что удаляется вопрос именно этого теста
        $stmt = $pdo->prepare('DELETE FROM questions WHERE id = ? AND test_id = ?');
        $stmt->execute([$qid, $test['id']]);
        header('Location: course_test.php?course_id=' . $courseId);
        exit;
    }
}

// Список вопросов с ответами
$questions = [];
if ($test) {
    $stmt = $pdo->prepare('SELECT id, question_text FROM questions WHERE test_id = ? ORDER BY id');
    $stmt->execute([$test['id']]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtA = $pdo->prepare('SELECT answer_text, is_correct FROM answers WHERE question_id = ? ORDER BY id');
    foreach ($questions as $k => $q) {
        $stmtA->execute([$q['id']]);
        $questions[$k]['answers'] = $stmtA->fetchAll(PDO::FETCH_ASSOC);
    }
}

$pageTitle = 'Test kursu';
require __DIR__ . '/../includes/admin_header.php';
?>
<h1>Test: <?= htmlspecialchars($course['title']) ?></h1>
<p><a href="courses.php">&larr; Wróć do kursów</a></p>

<h2>Ustawienia testu</h2>

<?php if ($testError !== ''): ?>
  <p class="error"><?= htmlspecialchars($testError) ?></p>
<?php endif; ?>

<form method="post">
  <input type="hidden" name="action" value="save_test">

  <label>Nazwa testu</label>
  <input type="text" name="test_title" required
         value="<?= htmlspecialchars($test['title'] ?? 'Test końcowy') ?>">

  <label>Próg zaliczenia (%)</label>
  <input type="number" name="pass_percent" min="1" max="100" required
         value="<?= (int)($test['pass_percent'] ?? 60) ?>">

  <p><button class="btn"><?= $test ? 'Zapisz ustawienia' : 'Utwórz test' ?></button></p>
</form>

<?php if ($test): ?>

  <h2>Pytania (<?= count($questions) ?>)</h2>

  <?php if (count($questions) === 0): ?>
    <p>Ten test nie ma jeszcze pytań.</p>
  <?php endif; ?>

  <?php foreach ($questions as $n => $q): ?>
    <div class="question-box">
      <strong><?= $n + 1 ?>. <?= htmlspecialchars($q['question_text']) ?></strong>
      <ul>
        <?php foreach ($q['answers'] as $a): ?>
          <li class="<?= $a['is_correct'] ? 'correct' : '' ?>">
            <?= htmlspecialchars($a['answer_text']) ?>
            <?= $a['is_correct'] ? ' ✓' : '' ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <form method="post" onsubmit="return confirm('Na pewno usunąć to pytanie?');">
        <input type="hidden" name="action" value="delete_question">
        <input type="hidden" name="question_id" value="<?= $q['id'] ?>">
        <button class="btn-danger">Usuń pytanie</button>
      </form>
    </div>
  <?php endforeach; ?>

  <h2>Dodaj pytanie</h2>

  <?php if ($questionError !== ''): ?>
    <p class="error"><?= htmlspecialchars($questionError) ?></p>
  <?php endif; ?>

  <form method="post">
    <input type="hidden" name="action" value="add_question">

    <label>Treść pytania</label>
    <textarea name="question_text" rows="3" required><?= htmlspecialchars($qText) ?></textarea>

    <label>Odpowiedzi (zaznacz kółkiem poprawną; puste pola są pomijane)</label>
    <?php for ($i = 0; $i < 4; $i++): ?>
      <p class="answer-row">
        <input type="radio" name="correct" value="<?= $i ?>" <?= $formCorrect === $i ? 'checked' : '' ?>>
        <input type="text" name="answers[]" placeholder="Odpowiedź <?= $i + 1 ?>"
               value="<?= htmlspecialchars($formAnswers[$i]) ?>">
      </p>
    <?php endfor; ?>

    <p><button class="btn">Dodaj pytanie</button></p>
  </form>

<?php else: ?>
  <p>Najpierw utwórz test, potem będzie można dodawać pytania.</p>
<?php endif; ?>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>