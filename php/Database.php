<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database = "thesisRep_db";

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
    gender VARCHAR(255),
    bdate VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$reviewer = "CREATE TABLE IF NOT EXISTS reviewer (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    reviewer_id VARCHAR(255),
    fname VARCHAR(50),
    lname VARCHAR(50),
    email VARCHAR(50),
    pass VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";



$thesisrepo = "CREATE TABLE IF NOT EXISTS repoTable(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    fname VARCHAR(50),
    lname VARCHAR(50),
    title VARCHAR(255),
    abstract VARCHAR(50),
    ThesisFile VARCHAR(50),
    reviewer_id VARCHAR(255),
    status VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$publicRepo = "CREATE TABLE IF NOT EXISTS publicRepo(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    fname VARCHAR(50),
    lname VARCHAR(50),
    title VARCHAR(255),
    abstract VARCHAR(50),
    ThesisFile VARCHAR(50),
    reviewer_id VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP


)";
mysqli_query($connect, $reviewer);
mysqli_query($connect, $student);
mysqli_query($connect, $publicRepo);


if(mysqli_query($connect, $thesisrepo)){
    // echo "success";
};
?>


