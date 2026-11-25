<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');
require __DIR__ . '/../config/db.php';

$id = (int)($_GET['id'] ?? 0);

// AND is_published = 1: скрытый курс нельзя открыть, даже подставив его id в адрес
$stmt = $pdo->prepare('SELECT * FROM courses WHERE id = ? AND is_published = 1');
$stmt->execute([$id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    header('Location: catalog.php');
    exit;
}

// Куплен ли курс этим пользователем
$stmt = $pdo->prepare('SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?');
$stmt->execute([$_SESSION['user_id'], $id]);
$isOwned = (bool)$stmt->fetch();

// Сколько в курсе материалов (показываем число, но не сами материалы)
$stmt = $pdo->prepare('SELECT COUNT(*) FROM materials WHERE course_id = ?');
$stmt->execute([$id]);
$materialsCount = (int)$stmt->fetchColumn();

$isFree = (float)$course['price'] == 0;

$pageTitle = $course['title'];
require __DIR__ . '/../includes/user_header.php';
?>
<p><a href="catalog.php">&larr; Wróć do katalogu</a></p>
<h1><?= htmlspecialchars($course['title']) ?></h1>

<!-- nl2br сохраняет переносы строк из описания, htmlspecialchars защищает от вредного кода -->
<p><?= nl2br(htmlspecialchars($course['description'] ?? '')) ?></p>
<p class="muted">Liczba materiałów: <?= $materialsCount ?></p>
<p><strong>Cena: <?= $isFree ? 'bezpłatny' : number_format($course['price'], 2, ',', ' ') . ' zł' ?></strong></p>

<?php if ($isOwned): ?>
  <p class="success">Masz ten kurs.</p>
  <a class="btn" href="course_view.php?id=<?= $course['id'] ?>">Przejdź do kursu</a>
<?php else: ?>
  <form method="post" action="buy.php">
    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
    <button class="btn"><?= $isFree ? 'Zapisz się' : 'Kup kurs' ?></button>
  </form>
<?php endif; ?>
<?php require __DIR__ . '/../includes/user_footer.php'; ?>