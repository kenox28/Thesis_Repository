<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database = "thesisRep_db";

// Connect to database
// Disable error reporting for the client
error_reporting(0);
ini_set('display_errors', 0);

// Set error handler to throw exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connect = mysqli_connect($localhost, $username, $password, $database);
} catch (mysqli_sql_exception $e) {
    // Return JSON error response
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $e->getMessage()
    ]);
    exit;
}

$student = "CREATE TABLE IF NOT EXISTS student (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(255),
    fname VARCHAR(50),
    lname VARCHAR(50),
    email VARCHAR(50),
    passw VARCHAR(50),
    profileImg VARCHAR(255),
    failed_attempts INT DEFAULT 0,
    lockout_time DATETIME DEFAULT NULL,
    gender VARCHAR(255),
    bdate VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    role VARCHAR(255) DEFAULT 'student'
)";

$result_bdate = mysqli_query($connect, "SHOW COLUMNS FROM student LIKE 'bdate'");
$bdate_exists = ($result_bdate && mysqli_num_rows($result_bdate) > 0);

// Check if 'gender' exists
$result_gender = mysqli_query($connect, "SHOW COLUMNS FROM student LIKE 'gender'");
$gender_exists = ($result_gender && mysqli_num_rows($result_gender) > 0);

if ($bdate_exists || $gender_exists) {
    $drop = [];
    if ($bdate_exists) $drop[] = "DROP COLUMN bdate";
    if ($gender_exists) $drop[] = "DROP COLUMN gender";
    $remove_column = "ALTER TABLE student " . implode(", ", $drop);
    mysqli_query($connect, $remove_column);
}

$result = mysqli_query($connect, "SHOW COLUMNS FROM student LIKE 'role'");
if ($result && mysqli_num_rows($result) == 0) {
    $alter_student = "ALTER TABLE student ADD COLUMN role VARCHAR(255) DEFAULT 'student'";
    mysqli_query($connect, $alter_student);
}

$reviewer = "CREATE TABLE IF NOT EXISTS reviewer (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    reviewer_id VARCHAR(255),
    fname VARCHAR(50),
    lname VARCHAR(50),
    email VARCHAR(50),
    pass VARCHAR(50),
    profileImg VARCHAR(255),
    gender VARCHAR(255),
    bdate VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$result = mysqli_query($connect, "SHOW COLUMNS FROM reviewer LIKE 'permissions'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE reviewer ADD COLUMN permissions VARCHAR(255) DEFAULT 'view'";
    mysqli_query($connect, $add_column);
}


$result = mysqli_query($connect, "SHOW COLUMNS FROM reviewer LIKE 'Approve'");

if ($result === false) {
    // If query failed, create the table first
    mysqli_query($connect, $reviewer);
    // Try the query again
    $result = mysqli_query($connect, "SHOW COLUMNS FROM reviewer LIKE 'Approve'");
}

if ($result && mysqli_num_rows($result) == 0) {
    // Add the 'Approve' column if it doesn't exist
    $add_column = "ALTER TABLE reviewer ADD COLUMN Approve BOOLEAN DEFAULT 0";
    
    mysqli_query($connect, $add_column);
} 

$result = mysqli_query($connect, "SHOW COLUMNS FROM reviewer LIKE 'permissions'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE reviewer ADD COLUMN permissions VARCHAR(255) DEFAULT 'view'";
    mysqli_query($connect, $add_column);
}

$revise_table = "CREATE TABLE IF NOT EXISTS revise_table(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    fname VARCHAR(50),
    lname VARCHAR(50),
    title VARCHAR(255),
    abstract VARCHAR(255),
    ThesisFile VARCHAR(255),
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
    abstract VARCHAR(255),
    ThesisFile VARCHAR(255),
    reviewer_id VARCHAR(255),
    Privacy VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP


)";


$thesisrepo = "CREATE TABLE IF NOT EXISTS repoTable(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    fname VARCHAR(50),  
    lname VARCHAR(50),
    title VARCHAR(255),
    abstract VARCHAR(1000),
    introduction VARCHAR(1000),
    Project_objective VARCHAR(1000),
    significance_of_study VARCHAR(1000),
    system_analysis_and_design VARCHAR(1000),
    Chapter VARCHAR(1000),
    message VARCHAR(1000),
    members_id VARCHAR(1000),
    ThesisFile VARCHAR(255),
    reviewer_id VARCHAR(255),
    status VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$result = mysqli_query($connect, "SHOW COLUMNS FROM repoTable LIKE 'members_id'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE repoTable ADD COLUMN members_id VARCHAR(1000)";
    mysqli_query($connect, $add_column);
}

$result = mysqli_query($connect, "SHOW COLUMNS FROM repoTable LIKE 'introduction'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE repoTable ADD COLUMN introduction VARCHAR(1000)";
    mysqli_query($connect, $add_column);
}

$result = mysqli_query($connect, "SHOW COLUMNS FROM repoTable LIKE 'message'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE repoTable ADD COLUMN message VARCHAR(1000)";
    mysqli_query($connect, $add_column);
}

$result = mysqli_query($connect, "SHOW COLUMNS FROM repoTable LIKE 'Project_objective'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE repoTable ADD COLUMN Project_objective VARCHAR(1000)";
    mysqli_query($connect, $add_column);
}

$result = mysqli_query($connect, "SHOW COLUMNS FROM repoTable LIKE 'significance_of_study'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE repoTable ADD COLUMN significance_of_study VARCHAR(1000)";
    mysqli_query($connect, $add_column);
}

$result = mysqli_query($connect, "SHOW COLUMNS FROM repoTable LIKE 'system_analysis_and_design'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE repoTable ADD COLUMN system_analysis_and_design VARCHAR(1000)";
    mysqli_query($connect, $add_column);
}

$result = mysqli_query($connect, "SHOW COLUMNS FROM repoTable LIKE 'Chapter'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE repoTable ADD COLUMN Chapter VARCHAR(1000)";
    mysqli_query($connect, $add_column);
}



$thesis_history = "CREATE TABLE IF NOT EXISTS thesis_history (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    thesis_id INT NOT NULL,
    student_id VARCHAR(50),
    revision_num INT NOT NULL,
    file_name VARCHAR(255),
    revised_by VARCHAR(255),
    revised_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50),
    notes TEXT
)";
$admin = "CREATE TABLE IF NOT EXISTS admin (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    admin_id VARCHAR(255) NOT NULL UNIQUE,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    profileImg VARCHAR(255) DEFAULT 'noprofile.png',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($connect, $admin);

// Check if the default admin already exists
$check_admin = "SELECT * FROM admin";
$result = mysqli_query($connect, $check_admin);

if ($result && mysqli_num_rows($result) === 0) {
    // Insert default admin if it doesn't exist
    $default_admin = "INSERT INTO admin (admin_id, fname, lname, email, pass) VALUES
    ('ADM001', 'Default', 'Admin', 'admin@gmail.com', '" . md5("admin123456") . "'),
    ('ADM002', 'Default', 'Admin', 'iquenxzx@gmail.com', '" . md5("iquen123456") . "'),
    ('ADM003', 'Default', 'Admin', 'russeljhondasigan@gmail.com', '" . md5("russel123456") . "')";
    mysqli_query($connect, $default_admin);
}

// Add profileImg column if it doesn't exist
$result = mysqli_query($connect, "SHOW COLUMNS FROM admin LIKE 'profileImg'");
if ($result && mysqli_num_rows($result) == 0) {
    $alter_admin = "ALTER TABLE admin ADD COLUMN profileImg VARCHAR(255) DEFAULT 'noprofile.png'";
    mysqli_query($connect, $alter_admin);
}

$super_admin = "CREATE TABLE IF NOT EXISTS super_admin (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    super_admin_id VARCHAR(255) NOT NULL UNIQUE,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($connect, $super_admin);

// Check if the default super admin already exists
$check_super_admin = "SELECT * FROM super_admin";
$result = mysqli_query($connect, $check_super_admin);

if ($result && mysqli_num_rows($result) === 0) {
    // Insert default super admin if it doesn't exist
    $default_super_admin = "INSERT INTO super_admin (super_admin_id, fname, lname, email, pass) VALUES
    ('SADM001', 'Super', 'Admin', 'superadmin@gmail.com', '" . md5("superadmin123456") . "')";
    mysqli_query($connect, $default_super_admin);
}

// Create activity_logs table with updated structure
$activity_logs = "CREATE TABLE IF NOT EXISTS activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255),
    user_type ENUM('admin', 'super_admin') NOT NULL,
    action_type VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Only create the table if it doesn't exist
mysqli_query($connect, $activity_logs);
mysqli_query($connect, $thesisrepo);
mysqli_query($connect, $reviewer);
mysqli_query($connect, $student);
mysqli_query($connect, $publicRepo);
mysqli_query($connect, $revise_table);
mysqli_query($connect, $thesis_history);

$result = mysqli_query($connect, "SHOW COLUMNS FROM reviewer LIKE 'last_active'");
if ($result && mysqli_num_rows($result) == 0) {
    $add_column = "ALTER TABLE reviewer ADD COLUMN last_active DATETIME DEFAULT NULL";
    mysqli_query($connect, $add_column);
}
?>