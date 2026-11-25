<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');
require __DIR__ . '/../config/db.php';

// Покупка возможна только из формы (POST), а не по ссылке
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: catalog.php');
    exit;
}

// user_id берём из СЕССИИ, а не из формы: иначе можно было бы "купить" за другого
$userId   = (int)$_SESSION['user_id'];
$courseId = (int)($_POST['course_id'] ?? 0);

// Цену тоже берём из БАЗЫ, а не из формы: иначе её можно было бы подменить
$stmt = $pdo->prepare('SELECT id, price FROM courses WHERE id = ? AND is_published = 1');
$stmt->execute([$courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    header('Location: catalog.php');
    exit;
}

// Если курс уже куплен, повторно не покупаем
$stmt = $pdo->prepare('SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?');
$stmt->execute([$userId, $courseId]);
if ($stmt->fetch()) {
    header('Location: my_courses.php');
    exit;
}

// Транзакция: заказ и запись на курс создаются ВМЕСТЕ или не создаются вообще
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        "INSERT INTO orders (user_id, course_id, amount, status) VALUES (?, ?, ?, 'paid')"
    );
    $stmt->execute([$userId, $courseId, $course['price']]);

    $stmt = $pdo->prepare('INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)');
    $stmt->execute([$userId, $courseId]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    throw $e;
}

header('Location: my_courses.php?bought=1');
exit;