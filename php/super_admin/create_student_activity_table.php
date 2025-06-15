<?php
require_once __DIR__ . '/../Database.php';

// Check if the index already exists
$checkIndexSQL = "SHOW INDEX FROM student WHERE Key_name = 'idx_student_id'";
$result = mysqli_query($connect, $checkIndexSQL);

if (!$result || mysqli_num_rows($result) == 0) {
    // Index doesn't exist, create it
    $addStudentIdIndexSQL = "ALTER TABLE student ADD UNIQUE INDEX idx_student_id (student_id)";
    if (!mysqli_query($connect, $addStudentIdIndexSQL)) {
        echo "Error adding student_id index: " . mysqli_error($connect) . "\n";
    }
}

// SQL to create student_activity table
$createTableSQL = "CREATE TABLE IF NOT EXISTS student_activity (
    activity_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(255),
    activity_type VARCHAR(50) NOT NULL,
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activity_description TEXT,
    FOREIGN KEY (student_id) REFERENCES student(student_id) ON DELETE CASCADE
)";

// Execute the create table query
// Start output buffering to capture any error messages
ob_start();

$success = true;
$errors = [];

if (!mysqli_query($connect, $createTableSQL)) {
    $success = false;
    $errors[] = "Error creating table: " . mysqli_error($connect);
} else {
    // Check and add indexes if they don't exist
    $checkIndexes = "SHOW INDEX FROM student_activity";
    $indexResult = mysqli_query($connect, $checkIndexes);
    $existingIndexes = [];
    
    if ($indexResult) {
        while ($row = mysqli_fetch_assoc($indexResult)) {
            $existingIndexes[] = $row['Key_name'];
        }
    }
    
    // Add student_date index if it doesn't exist
    if (!in_array('idx_student_date', $existingIndexes)) {
        $addStudentDateIndex = "ALTER TABLE student_activity 
                                ADD INDEX idx_student_date (student_id, activity_date)";
        if (!mysqli_query($connect, $addStudentDateIndex)) {
            $success = false;
            $errors[] = "Error adding student date index: " . mysqli_error($connect);
        }
    }
    
    // Add activity_date index if it doesn't exist
    if (!in_array('idx_activity_date', $existingIndexes)) {
        $addActivityDateIndex = "ALTER TABLE student_activity 
                                 ADD INDEX idx_activity_date (activity_date)";
        if (!mysqli_query($connect, $addActivityDateIndex)) {
            $success = false;
            $errors[] = "Error adding activity date index: " . mysqli_error($connect);
        }
    }
}

// Clear any output that might have been generated
ob_end_clean();

// First drop the view if it exists
$dropViewSQL = "DROP VIEW IF EXISTS student_activity_view";
mysqli_query($connect, $dropViewSQL);

// Create the view
$createViewSQL = "CREATE VIEW student_activity_view AS
    SELECT 
        s.student_id,
        s.fname,
        s.lname,
        COALESCE(MAX(sa.activity_date), '0000-00-00 00:00:00') as last_active,
        COUNT(DISTINCT pr.id) as thesis_count
    FROM student s
    LEFT JOIN student_activity sa ON s.student_id = sa.student_id
    LEFT JOIN publicRepo pr ON s.student_id = pr.student_id
    GROUP BY s.student_id, s.fname, s.lname";

if (!mysqli_query($connect, $createViewSQL)) {
    $success = false;
    $errors[] = "Error creating view: " . mysqli_error($connect);
}

// Drop existing trigger if it exists
$dropTriggerSQL = "DROP TRIGGER IF EXISTS after_thesis_upload";
mysqli_query($connect, $dropTriggerSQL);

// Create a trigger to automatically log student activities
$createTriggerSQL = "CREATE TRIGGER after_thesis_upload
    AFTER INSERT ON publicRepo
    FOR EACH ROW
    BEGIN
        INSERT INTO student_activity (student_id, activity_type, activity_description)
        VALUES (NEW.student_id, 'thesis_upload', CONCAT('Uploaded thesis: ', NEW.title));
    END;";

if (!mysqli_query($connect, $createTriggerSQL)) {
    $success = false;
    $errors[] = "Error creating trigger: " . mysqli_error($connect);
}

// Create additional triggers for other activities
$createLoginTriggerSQL = "CREATE TRIGGER after_student_login
    AFTER UPDATE ON student
    FOR EACH ROW
    BEGIN
        IF NEW.updated != OLD.updated THEN
            INSERT INTO student_activity (student_id, activity_type, activity_description)
            VALUES (NEW.student_id, 'login', 'Student logged in');
        END IF;
    END;";

// First check if the 'updated' column exists in the student table
$checkColumnSQL = "SHOW COLUMNS FROM student LIKE 'updated'";
$columnResult = mysqli_query($connect, $checkColumnSQL);

if (mysqli_num_rows($columnResult) == 0) {
    // Add the 'updated' column if it doesn't exist
    $addColumnSQL = "ALTER TABLE student ADD COLUMN updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
    mysqli_query($connect, $addColumnSQL);
}

// Drop existing trigger if it exists (silently)
mysqli_query($connect, "DROP TRIGGER IF EXISTS after_student_login");

// Try to create the trigger
if (!mysqli_query($connect, $createLoginTriggerSQL)) {
    // Silently log the error without adding it to the errors array
    error_log("Error creating login trigger: " . mysqli_error($connect));
}

// Don't close the connection here as it's needed by the calling page
?> 