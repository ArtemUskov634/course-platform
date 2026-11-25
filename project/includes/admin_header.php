<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle ?? 'Panel administratora') ?></title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav class="nav">
  <a href="index.php">Panel</a>
  <a href="courses.php">Kursy</a>
  <span class="spacer"></span>
  <span><?= htmlspecialchars($_SESSION['name']) ?></span>
  <a href="../public/logout.php">Wyloguj się</a>
</nav>
<main class="container">