<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');
require __DIR__ . '/../config/db.php';

$userId   = (int)$_SESSION['user_id'];
$courseId = (int)($_GET['course_id'] ?? 0);

// Тест доступен только тому, кто записан на курс
$stmt = $pdo->prepare(
    'SELECT c.id, c.title
     FROM enrollments e
     JOIN courses c ON c.id = e.course_id
     WHERE e.user_id = ? AND e.course_id = ?'
);
$stmt->execute([$userId, $courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    header('Location: my_courses.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, title, pass_percent FROM tests WHERE course_id = ?');
$stmt->execute([$courseId]);
$test = $stmt->fetch(PDO::FETCH_ASSOC);

$questions = [];
if ($test) {
    $stmt = $pdo->prepare('SELECT id, question_text FROM questions WHERE test_id = ? ORDER BY id');
    $stmt->execute([$test['id']]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ---------- Проверка ответов ----------
if ($test && count($questions) > 0 && $_SERVER['REQUEST_METHOD'] === 'POST') {

    // Правильные ответы берём из БАЗЫ. В браузер мы их не отправляли,
    // поэтому подсмотреть их в коде страницы нельзя.
    // FETCH_KEY_PAIR превращает результат в массив [id_вопроса => id_правильного_ответа]
    $stmt = $pdo->prepare(
        'SELECT q.id, a.id
         FROM questions q
         JOIN answers a ON a.question_id = q.id
         WHERE q.test_id = ? AND a.is_correct = 1'
    );
    $stmt->execute([$test['id']]);
    $correctMap = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Из формы приходит массив q[id_вопроса] = id_выбранного_ответа
    $given = $_POST['q'] ?? [];
    if (!is_array($given)) {
        $given = [];
    }

    $correct = 0;
    foreach ($questions as $q) {
        // Если на вопрос не ответили, получится 0, и он засчитается как неверный
        $chosen = (int)($given[$q['id']] ?? 0);
        if (isset($correctMap[$q['id']]) && $chosen === (int)$correctMap[$q['id']]) {
            $correct++;
        }
    }

    $total   = count($questions);
    $percent = (int)round($correct / $total * 100);
    $passed  = $percent >= (int)$test['pass_percent'] ? 1 : 0;

    $stmt = $pdo->prepare(
        'INSERT INTO test_attempts (user_id, test_id, score_percent, passed) VALUES (?, ?, ?, ?)'
    );
    $stmt->execute([$userId, $test['id'], $percent, $passed]);
    $attemptId = $pdo->lastInsertId();

    // Перенаправляем на страницу результата, чтобы F5 не отправил тест повторно
    header('Location: test_result.php?id=' . $attemptId);
    exit;
}

$pageTitle = 'Test';
require __DIR__ . '/../includes/user_header.php';
?>
<p><a href="course_view.php?id=<?= $course['id'] ?>">&larr; Wróć do kursu</a></p>
<h1>Test: <?= htmlspecialchars($course['title']) ?></h1>

<?php if (!$test || count($questions) === 0): ?>
  <p>Ten kurs nie ma jeszcze testu.</p>

<?php else: ?>
  <p class="muted">
    <?= htmlspecialchars($test['title']) ?> &middot;
    Liczba pytań: <?= count($questions) ?> &middot;
    Próg zaliczenia: <?= (int)$test['pass_percent'] ?>%
  </p>

  <!-- В форме нет action, поэтому она отправляется на этот же адрес вместе с ?course_id=... -->
  <form method="post">
    <?php
      $stmtA = $pdo->prepare('SELECT id, answer_text FROM answers WHERE question_id = ? ORDER BY id');
    ?>
    <?php foreach ($questions as $n => $q): ?>
      <div class="question-box">
        <strong><?= $n + 1 ?>. <?= htmlspecialchars($q['question_text']) ?></strong>
        <?php
          $stmtA->execute([$q['id']]);
          $answers = $stmtA->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($answers as $a): ?>
          <!-- name="q[5]" PHP превращает в массив: $_POST['q'][5] = выбранный ответ -->
          <label class="answer-option">
            <input type="radio" name="q[<?= $q['id'] ?>]" value="<?= $a['id'] ?>" required>
            <?= htmlspecialchars($a['answer_text']) ?>
          </label>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>

    <p><button class="btn">Zakończ test</button></p>
  </form>
<?php endif; ?>
<?php require __DIR__ . '/../includes/user_footer.php'; ?>