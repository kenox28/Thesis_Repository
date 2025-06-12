<?php
include_once "Database.php";

// Create activity_logs table
$sql = "CREATE TABLE IF NOT EXISTS activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id VARCHAR(10),
    action_type VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE SET NULL
)";

if (mysqli_query($connect, $sql)) {
    echo "Activity logs table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($connect);
}
?> 