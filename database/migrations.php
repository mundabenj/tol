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

// Drop roles table if it exists
$drop_roles_table = $SQL->dropTable('roles');
if ($drop_roles_table === TRUE) {
    echo "Table roles dropped successfully.<br>";
} else {
    echo "Error dropping table: " . $SQL->getLastError() . "<br>";
}

// Create roles table if it doesn't exist
$create_roles_table = $SQL->createTable('roles', [
    'roleId' => 'TINYINT(1) AUTO_INCREMENT PRIMARY KEY',
    'roleName' => 'VARCHAR(50) NOT NULL',
    'roleDesc' => 'VARCHAR(255) DEFAULT NULL',
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
]);

// Check if the table was created successfully
if ($create_roles_table === TRUE) {
    echo "Table roles created successfully.<br>";
} else {
    echo "Error creating table: " . $SQL->getLastError() . "<br>";
}

// Drop genders table if it exists
$drop_genders_table = $SQL->dropTable('genders');
if ($drop_genders_table === TRUE) {
    echo "Table genders dropped successfully.<br>";
} else {
    echo "Error dropping table: " . $SQL->getLastError() . "<br>";
}

// Create genders table if it doesn't exist
$create_genders_table = $SQL->createTable('genders', [
    'genderId' => 'TINYINT(1) AUTO_INCREMENT PRIMARY KEY',
    'genderName' => 'VARCHAR(50) NOT NULL',
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
]);

// Check if the table was created successfully
if ($create_genders_table === TRUE) {
    echo "Table genders created successfully.<br>";
} else {
    echo "Error creating table: " . $SQL->getLastError() . "<br>";
}

// Alter users table to add constraints
$alter_users = $SQL->addForeignKey('users', 'roleId', 'roles', 'roleId');
$alter_users = $SQL->addForeignKey('users', 'genderId', 'genders', 'genderId');