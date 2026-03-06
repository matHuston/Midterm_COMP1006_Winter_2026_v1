<?php
require "includes/connect.php";

// check that request method is POST so that we only process form submissions
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

// sanitize and trim form user input
$firstName = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS));
$lastName = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS));
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
// validate input data and collect errors into an array
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
    $errors[] = "Hawkmail is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Hawkmail must be a valid email address.";
}

// required field: phone with regex
if ($phone === null || $phone === '' || empty($phone)) {
    $errors[] = "Telephone number is required.";
} elseif (
    !filter_var($phone, FILTER_VALIDATE_REGEXP, [
        'options' => ['regexp' => '/^[0-9\-\+\(\)\s]{7,25}$/']
        // this regex allows digits, spaces, parentheses, plus and hyphens
    ])
) {
    $errors[] = "Telephone number format is invalid.";
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

// SQL query with placeholders to insert data into table
$sql = "INSERT INTO registrations (first_name, last_name, email, phone) 
            VALUES (:first_name, :last_name, :email, :phone)"; // placeholders for prepared statement

// prepare the query
$stmt = $pdo->prepare($sql);

// match placeholders with actual values
$stmt->bindParam(":first_name", $firstName);
$stmt->bindParam(":last_name", $lastName);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":phone", $phone);

// execute query
$stmt->execute();
// closing the connection
$pdo = null;

?>

<div style="border: 1px solid green; padding: 20px; margin: 20px;">
    <h1>User <?= htmlspecialchars($firstName) ?> <?= htmlspecialchars($lastName) ?> registered successfully!</h1>
    <p>Contact information for <?= htmlspecialchars($firstName) ?>:
        <strong>
            <?= htmlspecialchars($email) ?>, or <?= htmlspecialchars($phone) ?>
        </strong>.
    </p>
</div>