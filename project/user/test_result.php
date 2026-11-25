<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');
require __DIR__ . '/../config/db.php';

$attemptId = (int)($_GET['id'] ?? 0);

// AND ta.user_id = ? : пользователь видит только СВОИ попытки.
// Подставив чужой номер попытки, он ничего не получит.
$stmt = $pdo->prepare(
    'SELECT ta.score_percent, ta.passed, t.pass_percent, c.id AS course_id, c.title AS course_title
     FROM test_attempts ta
     JOIN tests t   ON t.id = ta.test_id
     JOIN courses c ON c.id = t.course_id
     WHERE ta.id = ? AND ta.user_id = ?'
);
$stmt->execute([$attemptId, $_SESSION['user_id']]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$r) {
    header('Location: my_courses.php');
    exit;
}

$pageTitle = 'Wynik testu';
require __DIR__ . '/../includes/user_header.php';
?>
<h1>Wynik testu</h1>
<p class="muted"><?= htmlspecialchars($r['course_title']) ?></p>

<div class="result-box">
  <div class="percent"><?= (int)$r['score_percent'] ?>%</div>
  <?php if ($r['passed']): ?>
    <p class="success">Gratulacje! Test zaliczony.</p>
  <?php else: ?>
    <p class="fail">Test niezaliczony.</p>
  <?php endif; ?>
  <p class="muted">Próg zaliczenia: <?= (int)$r['pass_percent'] ?>%</p>

  <p>
    <?php if ($r['passed']): ?>
      <a class="btn" href="certificate.php?course_id=<?= $r['course_id'] ?>">Pobierz certyfikat</a>
    <?php else: ?>
      <a class="btn" href="test.php?course_id=<?= $r['course_id'] ?>">Spróbuj ponownie</a>
    <?php endif; ?>
    <a class="btn" href="course_view.php?id=<?= $r['course_id'] ?>">Wróć do kursu</a>
  </p>
</div>
<?php require __DIR__ . '/../includes/user_footer.php'; ?>