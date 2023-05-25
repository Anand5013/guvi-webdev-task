<?php
$servername = 'sql101.epizy.com';
$dbname = 'epiz_34276686_mydb';
$dbUsername = 'epiz_34276686';
$dbPassword = '3Jwo0tQZVwpnf';

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>