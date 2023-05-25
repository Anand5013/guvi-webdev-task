<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $phone = $_POST['phone'];
  $dob = $_POST['dob'];
  $age = $_POST['age'];
  $address = $_POST['address'];

  // Retrieve the username from the session
  $username = $_SESSION['username'];

  // Validate input data
  if (empty($phone) || empty($dob) || empty($age) || empty($address)) {
    echo 'Please fill all fields';
  } else {
    // Store user data in JSON file
    $file = 'users.json';
    $data = file_get_contents($file);
    $data = json_decode($data, true);

    // Find the user in the data array by matching the username
    $userIndex = -1;
    foreach ($data as $index => $user) {
      if ($user['username'] === $username) {
        $userIndex = $index;
        break;
      }
    }

    if ($userIndex !== -1) {
      // Update the user data
      $data[$userIndex]['phone'] = $phone;
      $data[$userIndex]['dob'] = $dob;
      $data[$userIndex]['age'] = $age;
      $data[$userIndex]['address'] = $address;

      $updatedData = json_encode($data);
      file_put_contents($file, $updatedData);

      // Connect to MySQL database (optional)
      require 'db_connect.php';
      
      // Prepare SQL statement (optional)
      $stmt = $conn->prepare('UPDATE users SET phone = ?, dob = ?, age = ?, address = ? WHERE username = ?');
      $stmt->bind_param('ssiss', $phone, $dob, $age, $address, $username);

      // Execute SQL statement (optional)
      if ($stmt->execute()) {
        echo 'Update successful';
      } else {
        echo 'Update failed';
      }

      $stmt->close();
      $conn->close();
    } else {
      echo 'User not found';
    }
  }
}
?>
