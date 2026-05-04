<?php
SESSION_START();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // DB connection (change dbname, user, pass as per your setup)
    $conn = new mysqli("localhost", "root", "", "users");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(!isset($_SESSION['username'])){
        echo 'Please login to submit feedback.';
    }else{
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Thank you for your feedback!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}    }

    
?>
