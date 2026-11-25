<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');
require __DIR__ . '/../config/db.php';

$userId   = (int)$_SESSION['user_id'];
$courseId = (int)($_GET['course_id'] ?? 0);

// 1) Пользователь должен быть записан на курс
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

// 2) У пользователя должна быть СДАННАЯ попытка теста этого курса.
// Без этой проверки сертификат можно было бы получить, просто открыв адрес.
$stmt = $pdo->prepare(
    'SELECT MAX(ta.score_percent) AS best
     FROM test_attempts ta
     JOIN tests t ON t.id = ta.test_id
     WHERE ta.user_id = ? AND t.course_id = ? AND ta.passed = 1'
);
$stmt->execute([$userId, $courseId]);
$best = $stmt->fetchColumn();   // MAX без подходящих строк даёт NULL

if ($best === null) {
    header('Location: course_view.php?id=' . $courseId);
    exit;
}

// 3) Сертификат выдаётся один раз. Номер создаём при первом открытии
// и дальше показываем тот же самый.
$code = 'CERT-' . strtoupper(bin2hex(random_bytes(4)));   // например CERT-A1B2C3D4

// INSERT IGNORE: если запись уже есть (UNIQUE user_course), вставка тихо пропускается,
// и ошибки не будет, даже если нажать кнопку дважды подряд
$stmt = $pdo->prepare(
    'INSERT IGNORE INTO certificates (user_id, course_id, code) VALUES (?, ?, ?)'
);
$stmt->execute([$userId, $courseId, $code]);

// Читаем сертификат из базы (новый или уже существующий)
$stmt = $pdo->prepare('SELECT code, issued_at FROM certificates WHERE user_id = ? AND course_id = ?');
$stmt->execute([$userId, $courseId]);
$cert = $stmt->fetch(PDO::FETCH_ASSOC);

$pageTitle = 'Certyfikat';
require __DIR__ . '/../includes/user_header.php';
?>
<p class="no-print">
  <a href="course_view.php?id=<?= $course['id'] ?>">&larr; Wróć do kursu</a>
</p>

<div class="certificate">
  <h1>CERTYFIKAT</h1>
  <p>Niniejszym potwierdza się, że</p>
  <div class="name"><?= htmlspecialchars($_SESSION['name']) ?></div>
  <p>ukończył(a) kurs</p>
  <div class="course"><?= htmlspecialchars($course['title']) ?></div>
  <p>z wynikiem testu: <strong><?= (int)$best ?>%</strong></p>

  <div class="meta">
    <span>Data wystawienia: <?= date('d.m.Y', strtotime($cert['issued_at'])) ?></span>
    <span>Numer certyfikatu: <?= htmlspecialchars($cert['code']) ?></span>
  </div>
</div>

<p class="no-print">
  <button class="btn" onclick="window.print()">Drukuj / Zapisz jako PDF</button>
</p>
<p class="no-print muted">
  W oknie drukowania wybierz drukarkę „Zapisz jako PDF”.
</p>
<?php require __DIR__ . '/../includes/user_footer.php'; ?>