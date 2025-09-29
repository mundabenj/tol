<?php
require_once '../classAutoLoad.php';

// Drop table if it exists
$drop_user_table = $SQL->dropTable('users');
if ($drop_user_table === TRUE) {
    echo "Table users dropped successfully.<br>";
} else {
    echo "Error dropping table: " . $SQL->getLastError() . "<br>";
}

// Create users table if it doesn't exist
$create_user_table = $SQL->createTable('users', [
    'userId' => 'BIGINT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    'fullname' => 'VARCHAR(50) NOT NULL',
    'email' => 'VARCHAR(50) NOT NULL UNIQUE',
    'password' => 'VARCHAR(60) NOT NULL',
    'verify_code' => 'VARCHAR(10) DEFAULT NULL',
    'code_expiry_time' => 'DATETIME DEFAULT NULL',
    'status' => "ENUM('Active', 'Pending', 'Suspended', 'Deleted') DEFAULT 'Pending'",
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'genderId' => 'TINYINT(1) not null DEFAULT 1',
    'roleId' => 'TINYINT(1) not null DEFAULT 1',
]);

// Check if the table was created successfully
if ($create_user_table === TRUE) {
    echo "Table users created successfully.<br>";
} else {
    echo "Error creating table: " . $SQL->getLastError() . "<br>";
}
