<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "student_db"; 


$connection = mysqli_connect($servername, $username, $password, $dbname);


if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}

