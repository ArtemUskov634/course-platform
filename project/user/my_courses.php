<?php
require __DIR__ . '/../includes/auth.php';
requireRole('user');
require __DIR__ . '/../config/db.php';

// JOIN соединяет две таблицы: из enrollments берём дату записи,
// из courses название, связывая их по course_id
$stmt = $pdo->prepare(
    'SELECT c.id, c.title, e.enrolled_at
     FROM enrollments e
     JOIN courses c ON c.id = e.course_id
     WHERE e.user_id = ?
     ORDER BY e.enrolled_at DESC'
);
$stmt->execute([$_SESSION['user_id']]);
$myCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'Moje kursy';
require __DIR__ . '/../includes/user_header.php';
?>
<h1>Moje kursy</h1>

<?php if (isset($_GET['bought'])): ?>
  <p class="success">Kurs został dodany do Twojego konta.</p>
<?php endif; ?>

<?php if (count($myCourses) === 0): ?>
  <p>Nie masz jeszcze żadnych kursów. <a href="catalog.php">Przejdź do katalogu</a>.</p>
<?php else: ?>
  <table>
    <tr>
      <th>Kurs</th>
      <th>Data zapisu</th>
      <th>Akcje</th>
    </tr>
    <?php foreach ($myCourses as $c): ?>
      <tr>
        <td><?= htmlspecialchars($c['title']) ?></td>
        <td><?= date('d.m.Y', strtotime($c['enrolled_at'])) ?></td>
        <td><a href="course_view.php?id=<?= $c['id'] ?>">Otwórz kurs</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
<?php require __DIR__ . '/../includes/user_footer.php'; ?>