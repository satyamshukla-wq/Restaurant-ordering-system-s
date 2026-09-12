<?php
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "users";
session_start();

$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email !== '' && $password !== '') {
    $stmt = $conn->prepare("SELECT name, email FROM user WHERE email = ? AND password = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['name'];
            header("Location: ../index.php");
            exit;
        }

        echo "❌ Invalid email or password.";
        $stmt->close();
    } else {
        echo "❌ Login failed. Please try again.";
    }
} else {
    echo "⚠ Please fill the form correctly.";
}

mysqli_close($conn);
?>