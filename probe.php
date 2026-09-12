<?php
$conn = new mysqli("localhost", "root", "", "users");
if ($conn->connect_errno) { echo "CONNECTION_ERROR: " . $conn->connect_error; exit(1); }
echo "CONNECTED: " . $conn->host_info;
$conn->close();
?>
