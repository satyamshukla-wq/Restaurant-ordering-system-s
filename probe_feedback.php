<?php
$conn = new mysqli("localhost", "root", "", "users");
if (!$conn) { echo "CONNECTION_ERROR: " . mysqli_connect_error(); }
echo "HOST: " . $conn->host_info . "\n";
echo "ERROR: " . $conn->connect_error . "\n";
$stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
if (!$stmt) { echo "PREPARE_FAILED: " . $conn->error; }
else {
    $name = "Test User";
    $email = "test@example.com";
    $message = "A test feedback message";
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) { echo "INSERT_OK\n"; }
    else { echo "EXECUTE_FAILED: " . $stmt->error; }
    $stmt->close();
}
$conn->close();
?>
