<?php
require __DIR__ . '/../includes/auth.php';
requireRole('admin');
require __DIR__ . '/../config/db.php';

// Курс берём из адреса: course_materials.php?course_id=5
$courseId = (int)($_GET['course_id'] ?? 0);

$stmt = $pdo->prepare('SELECT id, title FROM courses WHERE id = ?');
$stmt->execute([$courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    header('Location: courses.php');
    exit;
}

// Белый список: какие расширения разрешены для каждого типа.
// Всё, чего нет в списке, отклоняется.
$allowedExt = [
    'video'        => ['mp4', 'webm'],
    'presentation' => ['pdf', 'ppt', 'pptx'],
];
$maxSize = 200 * 1024 * 1024; // наш лимит: 200 МБ

$error = '';
$title = '';
$type  = 'text';
$text  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Если файл больше post_max_size из php.ini, PHP молча очищает
    // $_POST и $_FILES целиком. Распознаём это по пустым данным
    // при ненулевой длине запроса.
    if (empty($_POST) && empty($_FILES) && ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        $error = 'Plik jest za duży (limit serwera).';
    } else {
        $title = trim($_POST['title'] ?? '');
        $type  = $_POST['type'] ?? 'text';
        $text  = trim($_POST['text'] ?? '');
        $content = '';

        if ($title === '') {
            $error = 'Podaj tytuł materiału.';
        } elseif (!in_array($type, ['text', 'video', 'presentation'], true)) {
            $error = 'Nieprawidłowy typ materiału.';
        } elseif ($type === 'text') {
            if ($text === '') {
                $error = 'Wpisz treść materiału.';
            } else {
                $content = $text;   // текст храним прямо в базе
            }
        } else {
            // Видео или презентация: работаем с загруженным файлом
            $file = $_FILES['file'] ?? null;

            if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
                $error = 'Wybierz plik.';
            } elseif ($file['error'] !== UPLOAD_ERR_OK) {
                $error = 'Błąd wgrywania pliku (kod ' . $file['error'] . ').';
            } elseif ($file['size'] > $maxSize) {
                $error = 'Plik jest za duży (maksymalnie 200 MB).';
            } else {
                // Расширение берём из ИМЕНИ файла и приводим к нижнему регистру
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                if (!in_array($ext, $allowedExt[$type], true)) {
                    $error = 'Niedozwolony format pliku. Dozwolone: '
                           . implode(', ', $allowedExt[$type]) . '.';
                } else {
                    // Своё случайное имя: исходное имя от пользователя НЕ используем
                    // (там могут быть пробелы, польские буквы, чужие файлы с тем же именем)
                    $newName = bin2hex(random_bytes(8)) . '.' . $ext;
                    $dir = __DIR__ . '/../uploads/';

                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }

                    // move_uploaded_file переносит файл из временной папки PHP в uploads/
                    if (move_uploaded_file($file['tmp_name'], $dir . $newName)) {
                        $content = $newName;   // в базе храним только имя файла
                    } else {
                        $error = 'Nie udało się zapisać pliku.';
                    }
                }
            }
        }

        if ($error === '') {
            // Позиция нового материала = максимальная в этом курсе + 1
            $stmt = $pdo->prepare(
                'SELECT COALESCE(MAX(position), 0) + 1 FROM materials WHERE course_id = ?'
            );
            $stmt->execute([$courseId]);
            $position = (int)$stmt->fetchColumn();

            $stmt = $pdo->prepare(
                'INSERT INTO materials (course_id, title, type, content, position) VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->execute([$courseId, $title, $type, $content, $position]);

            // Перенаправляем на эту же страницу (GET), чтобы при обновлении (F5)
            // форма не отправилась второй раз и не создала дубль
            header('Location: course_materials.php?course_id=' . $courseId);
            exit;
        }
    }
}

// Список материалов этого курса
$stmt = $pdo->prepare(
    'SELECT id, title, type, content, position FROM materials
     WHERE course_id = ? ORDER BY position, id'
);
$stmt->execute([$courseId]);
$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);

$typeLabels = ['text' => 'Tekst', 'video' => 'Wideo', 'presentation' => 'Prezentacja'];

$pageTitle = 'Materiały kursu';
require __DIR__ . '/../includes/admin_header.php';
?>
<h1>Materiały: <?= htmlspecialchars($course['title']) ?></h1>
<p><a href="courses.php">&larr; Wróć do kursów</a></p>

<?php if (count($materials) === 0): ?>
  <p>Ten kurs nie ma jeszcze materiałów.</p>
<?php else: ?>
  <table>
    <tr>
      <th>#</th>
      <th>Tytuł</th>
      <th>Typ</th>
      <th>Zawartość</th>
      <th>Akcje</th>
    </tr>
    <?php foreach ($materials as $m): ?>
      <tr>
        <td><?= $m['position'] ?></td>
        <td><?= htmlspecialchars($m['title']) ?></td>
        <td><?= $typeLabels[$m['type']] ?></td>
        <td>
          <?php if ($m['type'] === 'text'): ?>
            <?= htmlspecialchars(mb_strimwidth($m['content'], 0, 60, '...')) ?>
          <?php else: ?>
            <a href="../uploads/<?= htmlspecialchars($m['content']) ?>" target="_blank">Otwórz plik</a>
          <?php endif; ?>
        </td>
        <td>
          <form method="post" action="material_delete.php" class="inline-form"
                onsubmit="return confirm('Na pewno usunąć ten materiał?');">
            <input type="hidden" name="id" value="<?= $m['id'] ?>">
            <button class="btn-danger">Usuń</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<h2>Dodaj materiał</h2>

<?php if ($error !== ''): ?>
  <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<!-- enctype="multipart/form-data" ОБЯЗАТЕЛЕН для загрузки файлов.
     Без него файл не дойдёт, и $_FILES будет пустым. -->
<form method="post" enctype="multipart/form-data">
  <label>Tytuł</label>
  <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>

  <label>Typ</label>
  <select name="type" id="type">
    <option value="text"         <?= $type === 'text' ? 'selected' : '' ?>>Tekst</option>
    <option value="video"        <?= $type === 'video' ? 'selected' : '' ?>>Wideo (mp4, webm)</option>
    <option value="presentation" <?= $type === 'presentation' ? 'selected' : '' ?>>Prezentacja (pdf, ppt, pptx)</option>
  </select>

  <div id="textBox">
    <label>Treść</label>
    <textarea name="text" rows="6"><?= htmlspecialchars($text) ?></textarea>
  </div>

  <div id="fileBox">
    <label>Plik</label>
    <input type="file" name="file">
  </div>

  <p><button class="btn">Dodaj materiał</button></p>
</form>

<script>
// Показываем либо поле текста, либо выбор файла, в зависимости от типа
const typeSelect = document.getElementById('type');
function toggleFields() {
  const isText = typeSelect.value === 'text';
  document.getElementById('textBox').hidden = !isText;
  document.getElementById('fileBox').hidden = isText;
}
typeSelect.addEventListener('change', toggleFields);
toggleFields();   // вызываем сразу при загрузке страницы
</script>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>