<?php
require __DIR__ . '/../includes/auth.php';
requireRole('admin');
require __DIR__ . '/../config/db.php';

// Удаляем только если запрос пришёл методом POST (из формы с кнопкой)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    // Сначала удаляем с диска файлы материалов этого курса (видео и презентации),
    // иначе после удаления курса они останутся мусором в папке uploads/
    $stmt = $pdo->prepare(
        "SELECT content FROM materials WHERE course_id = ? AND type <> 'text'"
    );
    $stmt->execute([$id]);
    foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $fileName) {
        // basename оставляет только имя файла и отбрасывает любые "../"
        $path = __DIR__ . '/../uploads/' . basename($fileName);
        if (is_file($path)) {
            unlink($path);
        }
    }

    // Сам курс. Строки в materials удалятся автоматически (ON DELETE CASCADE)
    $stmt = $pdo->prepare('DELETE FROM courses WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: courses.php');
exit;