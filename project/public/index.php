<?php
// auth.php запускает сессию. Здесь requireRole НЕ вызываем:
// главная доступна всем, нам нужно лишь узнать, вошёл ли человек
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../includes/labels.php';

$role = $_SESSION['role'] ?? null;

// Фильтры из адреса: index.php?topic=rodo&spec=szkoly
$topic = $_GET['topic'] ?? '';
$spec  = $_GET['spec'] ?? '';

// Белый список: принимаем только значения, которые есть в наших списках.
// Любое другое значение (в том числе чужой SQL) превращается в "" и игнорируется.
if (!isset($topicLabels[$topic])) { $topic = ''; }
if (!isset($specLabels[$spec]))   { $spec = ''; }

// Собираем запрос по частям: условие добавляется только если фильтр выбран.
// Значения всё равно передаются через ?, как везде в проекте.
$sql    = 'SELECT id, title, description, topic, specialization, price
           FROM courses WHERE is_published = 1';
$params = [];

if ($topic !== '') {
    $sql .= ' AND topic = ?';
    $params[] = $topic;
}
if ($spec !== '') {
    $sql .= ' AND specialization = ?';
    $params[] = $spec;
}
$sql .= ' ORDER BY topic, specialization, title';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Адрес ссылки-фильтра. array_filter убирает пустые значения,
// http_build_query собирает из массива строку вида topic=rodo&spec=szkoly
function filterUrl($topic, $spec) {
    $q = array_filter(['topic' => $topic, 'spec' => $spec], fn($v) => $v !== '');
    return 'index.php' . ($q ? '?' . http_build_query($q) : '');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Platforma szkoleniowa</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav class="nav">
  <a href="index.php"><strong>Platforma szkoleniowa</strong></a>
  <span class="spacer"></span>
  <?php if ($role === null): ?>
    <a href="login.php">Zaloguj się</a>
    <a href="register.php">Zarejestruj się</a>
  <?php else: ?>
    <a href="<?= $role === 'admin' ? '../admin/index.php' : '../user/index.php' ?>">Mój panel</a>
    <a href="logout.php">Wyloguj się</a>
  <?php endif; ?>
</nav>

<section class="hero">
  <h1>Szkolenia online</h1>
  <p>BHP, RODO, sygnaliści i ochrona małoletnich. Ucz się w swoim tempie i zdobądź certyfikat.</p>
</section>

<main class="container">
  <h2>Nasze kursy</h2>

  <p class="filter-label">Temat</p>
  <div class="chips">
    <a class="chip <?= $topic === '' ? 'active' : '' ?>" href="<?= filterUrl('', $spec) ?>">Wszystkie</a>
    <?php foreach ($topicLabels as $key => $label): ?>
      <a class="chip <?= $topic === $key ? 'active' : '' ?>" href="<?= filterUrl($key, $spec) ?>">
        <?= htmlspecialchars($label) ?>
      </a>
    <?php endforeach; ?>
  </div>

  <p class="filter-label">Specjalizacja</p>
  <div class="chips">
    <a class="chip <?= $spec === '' ? 'active' : '' ?>" href="<?= filterUrl($topic, '') ?>">Wszystkie</a>
    <?php foreach ($specLabels as $key => $label): ?>
      <a class="chip <?= $spec === $key ? 'active' : '' ?>" href="<?= filterUrl($topic, $key) ?>">
        <?= htmlspecialchars($label) ?>
      </a>
    <?php endforeach; ?>
  </div>

  <br>

  <?php if (count($courses) === 0): ?>
    <p>Brak kursów dla wybranych filtrów.</p>
  <?php else: ?>
    <div class="cards">
      <?php foreach ($courses as $c): ?>
        <div class="card">
          <p>
            <span class="badge"><?= htmlspecialchars($topicLabels[$c['topic']]) ?></span>
            <span class="badge badge-spec"><?= htmlspecialchars($specLabels[$c['specialization']]) ?></span>
          </p>
          <h3><?= htmlspecialchars($c['title']) ?></h3>
          <p class="muted">
            <?= htmlspecialchars(mb_strimwidth($c['description'] ?? '', 0, 120, '...')) ?>
          </p>
          <p><strong><?= number_format($c['price'], 2, ',', ' ') ?> zł</strong></p>

          <?php if ($role === 'user'): ?>
            <a class="btn" href="../user/course.php?id=<?= $c['id'] ?>">Zobacz kurs</a>
          <?php elseif ($role === null): ?>
            <a class="btn" href="login.php">Zaloguj się, aby kupić</a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>
</body>
</html>