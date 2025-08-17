<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'travel_planner';

$conn = new mysqli('localhost', 'root', '', 'travel_planner');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>