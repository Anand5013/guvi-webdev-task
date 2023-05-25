<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    // validate input data
    if (empty($username) || empty($password) || empty($email)) {
        echo 'Please fill all fields';
    } else {
        // include database connection
        require 'db_connect.php';
        
        // prepare SQL statement
        $stmt = $conn->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $username, $password, $email);
        
        // execute SQL statement
        if ($stmt->execute()) {
            echo 'Signup successful';
            
            // store user data in JSON file
            $user_data = array('username' => $username, 'email' => $email);
            $file = 'users.json';
            
            if (file_exists($file)) {
                $data = file_get_contents($file);
                $data = json_decode($data, true);
                $data[] = $user_data;
            } else {
                $data = array($user_data);
            }
            
            $data = json_encode($data);
            file_put_contents($file, $data);
        } else {
            echo 'Signup failed';
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
