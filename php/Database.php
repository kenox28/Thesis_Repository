<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database = "ThesisRep_db";

// Connect to database
$connect = mysqli_connect($localhost, $username, $password, $database);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$student = "CREATE TABLE IF NOT EXISTS Student (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(255),
    fname VARCHAR(50),
    lname VARCHAR(50),
    email VARCHAR(50),
    passw VARCHAR(50),
    profileImg VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$instructor = "CREATE TABLE IF NOT EXISTS instructor (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    inst_id VARCHAR(255),
    fname VARCHAR(50),
    lname VARCHAR(50),
    email VARCHAR(50),
    pass VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
$repo = "CREATE TABLE IF NOT EXISTS table_repo(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    fname VARCHAR(50),
    lname VARCHAR(50),
    title VARCHAR(255),
    abstract VARCHAR(50),
    ThesisFile VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
)";
mysqli_query($connect, $student);
mysqli_query($connect, $instructor);
mysqli_query($connect, $repo);


?>
