<?php

// Connect to the database
$db = new mysqli("localhost", "root", "", "ssip_db");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Delete all rows in the login table where login_id is 0
$sql = "DELETE FROM login WHERE login_id = 0";

if ($db->query($sql) === TRUE) {
    echo "Records deleted successfully";
} else {
    echo "Error deleting records: " . $db->error;
}

session_start();

session_unset();

// Destroy the session
session_destroy();

// Redirect to the landing page
header("location: landing.php");

// Close the database connection
$db->close();

?>