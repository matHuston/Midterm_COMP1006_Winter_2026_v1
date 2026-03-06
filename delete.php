<?php
require 'includes/connect.php'; 

// require ID in URL, ex. update.php?id=1
if (!isset($_GET['id'])) {
  die("No Registration ID provided.");
}
// grab primary key ID from URL
$regId = $_GET['id']; 

// If form is submitted, DELETE the row
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // create the query 
    $sql = "DELETE from registrations WHERE id = :id"; 

    // prepare 
    $stmt = $pdo->prepare($sql); 
    // bind 
    $stmt->bindParam(':id', $regId);
    $stmt->execute(); 

     // redirect back to registration list
    header("Location: admin.php"); 
    exit; 
}

/* Load existing registration */
$sql = "SELECT * FROM registrations WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $regId);
$stmt->execute();

// fetch registration data with die if not found
$registration = $stmt->fetch();
if (!$registration) {
  die("Chosen Registration not found.");
}
?>

<main>
  <h2>Delete Registration #<?= htmlspecialchars($registration['id']); ?> ?</h2>
  <hr>
  
  <?php if (!empty($error)): ?>
    <p><?= htmlspecialchars($error); ?></p>

  <?php endif; ?>
    
    <form method="post">
        <p>This action will delete
        <strong>
            <?= htmlspecialchars($registration['first_name'] . " " . $registration['last_name']); ?>
        </strong> 
        from the registration list.
        </p>
        <p>This action cannot be undone.</p>
        <p>Continue?</p>
        <br>
        <!-- button sends delete POST -->
         <button>Delete Registration</button>
            <a href="admin.php">Cancel</a>
    </form>

</main>
