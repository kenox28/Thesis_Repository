<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database = "thesisRep_db";

// Connect to database
$connect = mysqli_connect($localhost, $username, $password, $database);


// Sample first and last names to randomize
$firstNames = ['John', 'Jane', 'Alex', 'Emily', 'Chris', 'Katie', 'Mike', 'Laura', 'Daniel', 'Sarah'];
$lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilson'];

for ($i = 1; $i <= 100; $i++) {
    $reviewer_id = rand(100000000, 999999999);
    $fname = $firstNames[array_rand($firstNames)];
    $lname = $lastNames[array_rand($lastNames)];
    $email = strtolower($fname . $lname . $i . "@example.com");
    $pass = md5("password123"); // hash the same password for demo
    $timestamp = date('Y-m-d H:i:s');

    $sql = "INSERT INTO reviewer (reviewer_id, fname, lname, email, pass, created_at )
            VALUES ('$reviewer_id', '$fname', '$lname', '$email', '$pass', '$timestamp')";

    if (!$connect->query($sql)) {
        echo "Error on record $i: " . $connect->error . "<br>";
    }
}

echo "100 dummy reviewers inserted!";
?>
