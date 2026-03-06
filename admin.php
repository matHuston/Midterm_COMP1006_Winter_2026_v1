<?php
require "includes/connect.php";

// query to get all registerations
$sql = "SELECT * FROM registrations ORDER BY last_name ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$registrations = []; // placeholder
// fetch all results as an array
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
  <h1>Registrations</h1>
  <h4><a href="update.php">>Update a Registration<</a></h4>
  <h4><a href="delete.php">>Delete a Registration<</a></h4>

  <?php if (count($registrations) === 0): ?>
    <p>No registrations yet.</p>
    <!-- view table -->
  <?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
      <thead>
        <tr>
        <th>ID</th>
          <th>Last Name</th>
          <th>First Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Register Time</th>
        </tr>
      </thead>
      <tbody>
        <!-- loop through $registrations, output rows in the table -->
        <?php foreach ($registrations as $registration): ?>
          <tr>
            <td><?= htmlspecialchars($registration['id']) ?></td>
            <td><?= htmlspecialchars($registration['last_name']) ?></td>
            <td><?= htmlspecialchars($registration['first_name']) ?></td>
            <td><?= htmlspecialchars($registration['email']) ?></td>
            <td><?= htmlspecialchars($registration['phone']) ?></td>
            <td><?= htmlspecialchars($registration['created_at']) ?></td>
          </tr>
          <!-- end loop -->
        <?php endforeach; ?>
      </tbody>
    </table>
    <!-- end if -->
  <?php endif; ?>

  <p>
    <a href="index.php">Back to Registration Form</a>
  </p>
</main>