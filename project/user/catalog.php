<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');
require __DIR__ . '/../config/db.php';

// Пользователь видит только опубликованные курсы
$courses = $pdo->query(
    'SELECT id, title, description, price FROM courses WHERE is_published = 1 ORDER BY id DESC'
)->fetchAll(PDO::FETCH_ASSOC);

// id курсов, на которые этот пользователь уже записан
$stmt = $pdo->prepare('SELECT course_id FROM enrollments WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$owned = $stmt->fetchAll(PDO::FETCH_COLUMN);

$pageTitle = 'Katalog kursów';
require __DIR__ . '/../includes/user_header.php';
?>
<h1>Katalog kursów</h1>

<?php if (count($courses) === 0): ?>
  <p>Brak dostępnych kursów.</p>
<?php else: ?>
  <div class="cards">
    <?php foreach ($courses as $c): ?>
      <div class="card">
        <h3><?= htmlspecialchars($c['title']) ?></h3>
        <p class="muted">
          <?= htmlspecialchars(mb_strimwidth($c['description'] ?? '', 0, 120, '...')) ?>
        </p>
        <p><strong><?= number_format($c['price'], 2, ',', ' ') ?> zł</strong></p>
        <?php if (in_array($c['id'], $owned)): ?>
          <p class="success">Masz ten kurs</p>
        <?php endif; ?>
        <a class="btn" href="course.php?id=<?= $c['id'] ?>">Zobacz kurs</a>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php require __DIR__ . '/../includes/user_footer.php'; ?>