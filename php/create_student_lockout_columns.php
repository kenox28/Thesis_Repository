<?php
include_once "Database.php";

// Add failed_attempts column if it doesn't exist
$check_failed_attempts = "SHOW COLUMNS FROM student LIKE 'failed_attempts'";
$result = mysqli_query($connect, $check_failed_attempts);

if (mysqli_num_rows($result) == 0) {
    $add_failed_attempts = "ALTER TABLE student ADD COLUMN failed_attempts INT DEFAULT 0";
    if (mysqli_query($connect, $add_failed_attempts)) {
        echo "Added failed_attempts column successfully\n";
    } else {
        echo "Error adding failed_attempts column: " . mysqli_error($connect) . "\n";
    }
}

// Add lockout_time column if it doesn't exist
$check_lockout_time = "SHOW COLUMNS FROM student LIKE 'lockout_time'";
$result = mysqli_query($connect, $check_lockout_time);

if (mysqli_num_rows($result) == 0) {
    $add_lockout_time = "ALTER TABLE student ADD COLUMN lockout_time DATETIME DEFAULT NULL";
    if (mysqli_query($connect, $add_lockout_time)) {
        echo "Added lockout_time column successfully\n";
    } else {
        echo "Error adding lockout_time column: " . mysqli_error($connect) . "\n";
    }
}

echo "Student table update completed";
?> 