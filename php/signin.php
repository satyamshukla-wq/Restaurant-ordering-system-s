<?php
$host = "localhost";
$dbuser = "shukla";
$dbpass = "shukla123";
$dbname = "users"; // database name without space
session_start();

// Connection
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Form data safely get
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// If email and password are provided, execute the query
if ($email && $password) {
    // SECURITY IMPROVEMENT: Use prepared statements to prevent SQL Injection
    // Select both email and password for a full check
    $stmt = $conn->prepare("SELECT name,email FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // You can fetch the user's name here if your 'user' table has a 'name' column.
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['name'];
        header("Location: index.php");
        // echo "✅ Login successful. Welcome ". htmlspecialchars($name) . "!";
    } else {
        echo "❌ Invalid email or password.";
    }
    $stmt->close();
} else {
    echo "⚠ Please fill the form correctly.";
}

mysqli_close($conn);
?>