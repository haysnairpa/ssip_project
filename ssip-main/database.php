<?php

$hostname = "localhost";
$username = "root";
$dbname = "ssip_db";
$password = "";

$db = mysqli_connect($hostname, $username, $password, $dbname);

if ($db->connect_error) {
    die("error");
}