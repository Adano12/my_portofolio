<?php
$servername = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = ""; // Change if needed
$database = "portfolio_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // SQL query to insert data
    $sql = "INSERT INTO contacts (first_name, email, phone, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $first_name, $email, $phone, $message);

    if ($stmt->execute()) {
        $success = "Your message has been sent successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Me - Portfolio</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>

<header>
    <h1>Contact Me</h1>
</header>

<div class="container">
    <section class="contact-info">
        <h2>Get in Touch</h2>
        <p>If you have any questions, projects, or inquiries, feel free to contact me.</p>
    </section>

    <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form action="contact.php" method="POST" class="form-container">
        <label for="fname">First Name:</label>
        <input type="text" name="fname" required>

        <label for="email">Email Address:</label>
        <input type="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" name="phone" required>

        <label for="message">Message:</label>
        <textarea name="message" required></textarea>

        <button type="submit" class="submit-btn">Submit</button>
    </form>
</div>

</body>
</html>
