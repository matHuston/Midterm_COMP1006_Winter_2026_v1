<?php
require "includes/connect.php";

// require ID in URL
if (!isset($_GET['id'])) {
  die("No Registration ID provided.");
}

// grab primary key ID from URL
$regId = $_GET['id'];

// If form is submitted, update row
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitize and trim input data
    $firstName = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS));
    $lastName = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS));
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));

    // collect errors into an array
    $errors = [];

    // required fields: first and last name
    if ($firstName === null || $firstName === '' || empty($firstName)) {
        $errors[] = "First Name is required.";
    }

    if ($lastName === null || $lastName === '' || empty($lastName)) {
        $errors[] = "Last Name is required.";
    }
    // required field: email with format check
    if ($email === null || $email === '' || empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }

    // required field: phone with regex
    if ($phone === null || $phone === '' || empty($phone)) {
        $errors[] = "Phone number is required.";
    } elseif (
        !filter_var($phone, FILTER_VALIDATE_REGEXP, [
            'options' => ['regexp' => '/^[0-9\-\+\(\)\s]{7,25}$/']
            // this regex allows digits, spaces, parentheses, plus and hyphens
        ])
    ) {
        $errors[] = "Phone number format is invalid.";
    }

    // error handling
    if (!empty($errors)) { // if errors array is not empty
        echo "<div style='color: red;'>";
        echo "<h2>Please fix the following:</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo "</div>";

        exit; // stop script execution if any errors
    }

    // sql query with placeholders
    $sql = "UPDATE registrations 
            SET first_name = :first_name, 
            last_name = :last_name, 
            email = :email, 
            phone = :phone 
            WHERE id = :id"; 

    $stmt = $pdo->prepare($sql);

    // match placeholders with actual values
    $stmt->bindParam(":first_name", $firstName);
    $stmt->bindParam(":last_name", $lastName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":id", $regId);

    // execute query
    $stmt->execute();
    // closing the connection
    $pdo = null;

    // redirect back to reg list
    header("Location: admin.php");
    exit;
}

/* Load existing data to be echoed in the form */
$sql = "SELECT * FROM registrations WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $regId);
$stmt->execute();

$registration = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$registration) {
    die("Registration not found.");
}
// end php
?> 

<main>
  <h2>Update Registration #<?= htmlspecialchars($registration['id']); ?></h2>

  <?php if (!empty($error)): ?>
    <p><?= htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <!--
    This form is pre-filled using the registration data pulled from the database.
    The admin can edit the values and submit to update the row.
  -->

  <form method="post">
    <h4>Registration Info</h4>
    <br>
    <!-- first name -->
    <label class="form-label">First Name</label>
    <input
    type="text"
    name="first_name"
    class="form-control mb-3"
    value="<?= htmlspecialchars($registration['first_name']); ?>"
    required
    >
    <br>
    <!-- last name -->
    <label class="form-label">Last Name</label>
    <input
    type="text"
    name="last_name"
    class="form-control mb-3"
    value="<?= htmlspecialchars($registration['last_name']); ?>"
    required
    >
    <br>
    <!-- phone number -->
    <label class="form-label">Phone Number</label>
    <input
    type="text"
    name="phone"
    class="form-control mb-3"
    value="<?= htmlspecialchars($registration['phone']); ?>"
    >
    <br>
    <!-- email address -->
    <label class="form-label">Email</label>
    <input
    type="email"
    name="email"
    class="form-control mb-4"
    value="<?= htmlspecialchars($registration['email']); ?>"
    required
    >
    <!-- button starts POST process -->
    <button>Save Changes</button>
    <a href="admin.php">Cancel</a>
  </form>
</main>