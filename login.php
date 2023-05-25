<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validate input data
  if (empty($username) || empty($password)) {
    echo 'Please fill all fields';
  } else {
    // Connect to the MySQL database
    require 'db_connect.php';

    // Prepare SQL statement with case-sensitive comparison
    $stmt = $conn->prepare('SELECT * FROM users WHERE BINARY username = ? AND BINARY password = ?');
    $stmt->bind_param('ss', $username, $password);

    // Execute SQL statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
      // Login successful, store the username in the session
      $_SESSION['username'] = $username;
      echo 'Login successful';
    } else {
      echo 'Invalid username or password';
    }

    $stmt->close();
    $conn->close();
  }
}
?>
