<?php
require __DIR__ . '/../includes/auth.php';
requireRole('admin');
require __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    $stmt = $pdo->prepare('SELECT course_id, type, content FROM materials WHERE id = ?');
    $stmt->execute([$id]);
    $m = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($m) {
        // Если это файл, удаляем его и с диска, иначе он останется мусором в uploads/
        if ($m['type'] !== 'text' && $m['content'] !== '') {
            // basename оставляет только имя файла и отбрасывает любые "../"
            $path = __DIR__ . '/../uploads/' . basename($m['content']);
            if (is_file($path)) {
                unlink($path);
            }
        }

        $stmt = $pdo->prepare('DELETE FROM materials WHERE id = ?');
        $stmt->execute([$id]);

        // course_id берём из базы, а не из формы, чтобы вернуться в правильный курс
        header('Location: course_materials.php?course_id=' . $m['course_id']);
        exit;
    }
}

header('Location: courses.php');
exit;