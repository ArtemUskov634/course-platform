<?php
require __DIR__ . '/../includes/auth.php';
requireRole('admin');
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../includes/labels.php';

// id курса берём из адреса: course_edit.php?id=5
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM courses WHERE id = ?');
$stmt->execute([$id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    header('Location: courses.php');
    exit;
}

$error       = '';
// Сначала подставляем в форму текущие значения из базы
$title       = $course['title'];
$description = $course['description'] ?? '';
$price       = $course['price'];
$published   = $course['is_published'];
$topic       = $course['topic'];
$spec        = $course['specialization'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // После отправки формы заменяем их тем, что ввёл админ
    $title       = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price       = str_replace(',', '.', trim($_POST['price']));
    $published   = isset($_POST['is_published']) ? 1 : 0;
    $topic       = $_POST['topic'] ?? '';
    $spec        = $_POST['specialization'] ?? '';

    if ($title === '') {
        $error = 'Podaj tytuł kursu.';
    } elseif (!isset($topicLabels[$topic])) {
        $error = 'Wybierz temat kursu.';
    } elseif (!isset($specLabels[$spec])) {
        $error = 'Wybierz specjalizację.';
    } elseif (!is_numeric($price) || $price < 0) {
        $error = 'Cena musi być liczbą nie mniejszą niż 0.';
    } else {
        // WHERE id = ? ОБЯЗАТЕЛЕН: без него обновились бы ВСЕ курсы сразу
        $stmt = $pdo->prepare(
            'UPDATE courses
             SET title = ?, description = ?, topic = ?, specialization = ?, price = ?, is_published = ?
             WHERE id = ?'
        );
        $stmt->execute([$title, $description, $topic, $spec, $price, $published, $id]);
        header('Location: courses.php');
        exit;
    }
}

$pageTitle = 'Edytuj kurs';
require __DIR__ . '/../includes/admin_header.php';
?>
<h1>Edytuj kurs</h1>

<?php if ($error !== ''): ?>
  <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
  <label>Tytuł</label>
  <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>

  <label>Temat szkolenia</label>
  <select name="topic">
    <?php foreach ($topicLabels as $key => $label): ?>
      <option value="<?= $key ?>" <?= $topic === $key ? 'selected' : '' ?>>
        <?= htmlspecialchars($label) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Specjalizacja</label>
  <select name="specialization">
    <?php foreach ($specLabels as $key => $label): ?>
      <option value="<?= $key ?>" <?= $spec === $key ? 'selected' : '' ?>>
        <?= htmlspecialchars($label) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Opis</label>
  <textarea name="description" rows="5"><?= htmlspecialchars($description) ?></textarea>

  <label>Cena (zł)</label>
  <input type="text" name="price" value="<?= htmlspecialchars($price) ?>">

  <label>
    <input type="checkbox" name="is_published" <?= $published ? 'checked' : '' ?>>
    Opublikuj kurs (widoczny dla użytkowników)
  </label>

  <p><button class="btn">Zapisz zmiany</button> <a href="courses.php">Anuluj</a></p>
</form>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>