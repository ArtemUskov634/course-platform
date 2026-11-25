<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');
require __DIR__ . '/../config/db.php';

$userId = (int)$_SESSION['user_id'];   // из сессии, подделать нельзя
$id     = (int)($_GET['id'] ?? 0);     // из адреса, пользователь может подставить любой

// ГЛАВНАЯ ПРОВЕРКА: курс откроется только если в enrollments есть строка
// "этот пользователь + этот курс". Подставить чужой id в адрес не получится.
$stmt = $pdo->prepare(
    'SELECT c.id, c.title
     FROM enrollments e
     JOIN courses c ON c.id = e.course_id
     WHERE e.user_id = ? AND e.course_id = ?'
);
$stmt->execute([$userId, $id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    header('Location: my_courses.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT id, title, type, content FROM materials
     WHERE course_id = ? ORDER BY position, id'
);
$stmt->execute([$id]);
$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Тест этого курса и количество вопросов в нём (подзапрос в скобках считает вопросы)
$stmt = $pdo->prepare(
    'SELECT t.id, t.title, t.pass_percent,
            (SELECT COUNT(*) FROM questions WHERE test_id = t.id) AS q_count
     FROM tests t
     WHERE t.course_id = ?'
);
$stmt->execute([$id]);
$test = $stmt->fetch(PDO::FETCH_ASSOC);

// Лучший результат пользователя (если уже пытался)
$best = null;
if ($test && $test['q_count'] > 0) {
    $stmt = $pdo->prepare(
        'SELECT MAX(score_percent) AS best, MAX(passed) AS passed
         FROM test_attempts WHERE user_id = ? AND test_id = ?'
    );
    $stmt->execute([$userId, $test['id']]);
    $best = $stmt->fetch(PDO::FETCH_ASSOC);   // если попыток нет, best будет NULL
}

$pageTitle = $course['title'];
require __DIR__ . '/../includes/user_header.php';
?>
<p><a href="my_courses.php">&larr; Moje kursy</a></p>
<h1><?= htmlspecialchars($course['title']) ?></h1>

<?php if (count($materials) === 0): ?>
  <p>Ten kurs nie ma jeszcze materiałów.</p>
<?php endif; ?>

<?php foreach ($materials as $n => $m): ?>
  <div class="material">
    <h3><?= $n + 1 ?>. <?= htmlspecialchars($m['title']) ?></h3>

    <?php if ($m['type'] === 'text'): ?>
      <!-- nl2br сохраняет переносы строк, htmlspecialchars защищает от вредного кода -->
      <p><?= nl2br(htmlspecialchars($m['content'])) ?></p>

    <?php elseif ($m['type'] === 'video'): ?>
      <video controls preload="metadata"
             src="../uploads/<?= htmlspecialchars($m['content']) ?>"></video>

    <?php else: ?>
      <?php
        // PDF браузер умеет показывать сам, ppt/pptx только скачиваются
        $isPdf = strtolower(pathinfo($m['content'], PATHINFO_EXTENSION)) === 'pdf';
      ?>
      <?php if ($isPdf): ?>
        <iframe class="pdf-frame"
                src="../uploads/<?= htmlspecialchars($m['content']) ?>"></iframe>
      <?php endif; ?>
      <p>
        <a class="btn" href="../uploads/<?= htmlspecialchars($m['content']) ?>" target="_blank">
          Otwórz / pobierz prezentację
        </a>
      </p>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

<?php if ($test && $test['q_count'] > 0): ?>
  <div class="material">
    <h3>Test: <?= htmlspecialchars($test['title']) ?></h3>
    <p class="muted">
      Liczba pytań: <?= (int)$test['q_count'] ?> &middot;
      Próg zaliczenia: <?= (int)$test['pass_percent'] ?>%
    </p>

    <?php if ($best && $best['best'] !== null): ?>
      <p>
        Najlepszy wynik: <strong><?= (int)$best['best'] ?>%</strong> &mdash;
        <?php if ($best['passed']): ?>
          <span class="success">zaliczony</span>
        <?php else: ?>
          <span class="fail">niezaliczony</span>
        <?php endif; ?>
      </p>
    <?php endif; ?>

    <a class="btn" href="test.php?course_id=<?= $course['id'] ?>">
      <?= ($best && $best['best'] !== null) ? 'Spróbuj ponownie' : 'Rozpocznij test' ?>
    </a>

    <?php if ($best && $best['passed']): ?>
      <a class="btn" href="certificate.php?course_id=<?= $course['id'] ?>">Pobierz certyfikat</a>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../includes/user_footer.php'; ?>