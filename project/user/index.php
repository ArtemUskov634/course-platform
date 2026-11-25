<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');

$pageTitle = 'Panel użytkownika';
require __DIR__ . '/../includes/user_header.php';
?>
<h1>Panel użytkownika</h1>
<p>Witaj, <?= htmlspecialchars($_SESSION['name']) ?></p>
<p>
  <a class="btn" href="catalog.php">Katalog kursów</a>
  <a class="btn" href="my_courses.php">Moje kursy</a>
</p>
<?php require __DIR__ . '/../includes/user_footer.php'; ?>