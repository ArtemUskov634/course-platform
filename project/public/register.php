<?php
session_start();
require __DIR__ . '/../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    if ($name === '' || $email === '' || strlen($pass) < 6) {
        $error = 'Wypełnij wszystkie pola. Hasło musi mieć co najmniej 6 znaków.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Ten adres e-mail jest już zarejestrowany.';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(
                'INSERT INTO users (email, password_hash, full_name) VALUES (?, ?, ?)'
            );
            $stmt->execute([$email, $hash, $name]);

            session_regenerate_id(true);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['role']    = 'user';
            $_SESSION['name']    = $name;

            header('Location: ../user/index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rejestracja</title>
</head>
<body>
  <h1>Rejestracja</h1>
  <?php if ($error !== ''): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post">
    <input name="full_name" placeholder="Imię i nazwisko" required><br>
    <input type="email" name="email" placeholder="Adres e-mail" required><br>
    <input type="password" name="password" placeholder="Hasło" required><br>
    <button>Zarejestruj się</button>
  </form>
  <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
</body>
</html>