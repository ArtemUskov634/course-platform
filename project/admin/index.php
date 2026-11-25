<?php
require __DIR__ . '/../includes/auth.php';
requireRole('admin');

$pageTitle = 'Panel administratora';
require __DIR__ . '/../includes/admin_header.php';
?>
<h1>Panel administratora</h1>
<p>Witaj, <?= htmlspecialchars($_SESSION['name']) ?></p>
<p><a class="btn" href="courses.php">Zarządzaj kursami</a></p>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>