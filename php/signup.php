<?php
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "users";

$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($name !== '' && $email !== '' && $password !== '') {
    $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo "✅ Signup successful. Welcome, " . htmlspecialchars($name) . "! Please <a href='../signin.html'>login</a> to continue.";
        } else {
            echo "❌ Signup failed. Please try again.";
        }

        $stmt->close();
    } else {
        echo "❌ Signup failed. Please try again.";
    }
} else {
    echo "⚠ Please fill the form correctly.";
}

mysqli_close($conn);
?>