<?php
require __DIR__ . '/../includes/auth.php';
requireRole('admin');
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../includes/labels.php';

$courses = $pdo->query(
    'SELECT id, title, topic, specialization, price, is_published FROM courses ORDER BY id DESC'
)->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'Kursy';
require __DIR__ . '/../includes/admin_header.php';
?>
<h1>Kursy</h1>
<p><a class="btn" href="course_add.php">+ Dodaj kurs</a></p>

<?php if (count($courses) === 0): ?>
  <p>Nie ma jeszcze żadnych kursów.</p>
<?php else: ?>
  <table>
    <tr>
      <th>ID</th>
      <th>Tytuł</th>
      <th>Temat</th>
      <th>Specjalizacja</th>
      <th>Cena</th>
      <th>Status</th>
      <th>Akcje</th>
    </tr>
    <?php foreach ($courses as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['title']) ?></td>
        <td><?= htmlspecialchars($topicLabels[$c['topic']]) ?></td>
        <td><?= htmlspecialchars($specLabels[$c['specialization']]) ?></td>
        <td><?= number_format($c['price'], 2, ',', ' ') ?> zł</td>
        <td><?= $c['is_published'] ? 'Opublikowany' : 'Ukryty' ?></td>
        <td>
          <a href="course_materials.php?course_id=<?= $c['id'] ?>">Materiały</a> |
          <a href="course_test.php?course_id=<?= $c['id'] ?>">Test</a> |
          <a href="course_edit.php?id=<?= $c['id'] ?>">Edytuj</a>

          <form method="post" action="course_delete.php" class="inline-form"
                onsubmit="return confirm('Na pewno usunąć ten kurs? Zostaną usunięte także jego materiały i test.');">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <button class="btn-danger">Usuń</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>