<?php
$host = "localhost";
$dbuser = "shukla";
$dbpass = "shukla123";
$dbname = "users"; // database name without space

// Connection
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Form data safely lena
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Agar email aur password diye gaye hain tabhi query chale
if ($email && $password && $name) {
    try{
        // SECURITY IMPROVEMENT: Use prepared statements to prevent SQL Injection
        $stmt = $conn->prepare("insert into user values(?, ?, ?)");
        $stmt->bind_param("sss",$name, $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "✅ Signup successful. Welcome, " . htmlspecialchars($name) . "!". " Please <a href='/CoffeeBliss/signin.html'>login</a> to continue.";

        
    }
    catch(Exception $e){
        echo $e->getMessage();
        echo "❌ Invalid email or password.";
    }
    $stmt->close();
} else {
    echo "⚠ Please fill the form correctly.";
}

mysqli_close($conn);
?>