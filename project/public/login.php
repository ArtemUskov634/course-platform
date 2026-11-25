<?php
session_start();
require __DIR__ . '/../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['name']    = $user['full_name'];

        if ($user['role'] === 'admin') {
            header('Location: ../admin/index.php');
        } else {
            header('Location: ../user/index.php');
        }
        exit;
    }

    $error = 'Nieprawidłowy adres e-mail lub hasło.';
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logowanie</title>
</head>
<body>
  <h1>Logowanie</h1>
  <?php if ($error !== ''): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post">
    <input type="email" name="email" placeholder="Adres e-mail" required><br>
    <input type="password" name="password" placeholder="Hasło" required><br>
    <button>Zaloguj się</button>
  </form>
  <p>Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
</body>
</html>