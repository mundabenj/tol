<?php
require_once '../ClassAutoLoad.php'; // Include the autoloader

// Method to disable foreign key checks
$disable_fk_checks = $SQL->disableForeignKeyChecks();

// Method to drop users table if exists
$drop_users = $SQL->dropTable('users');

// Method to create users table
$create_users = $SQL->createTable('users', [
    'userId' => 'bigint(10) AUTO_INCREMENT PRIMARY KEY',
    'fullname' => 'VARCHAR(50) default NULL',
    'email' => 'VARCHAR(100) default NULL unique',
    'password' => 'VARCHAR(60) NOT NULL',
    'verify_code' => 'VARCHAR(10) default NULL',
    'code_expiry_time' => 'TIMESTAMP NULL DEFAULT NULL',
    'mustchange' => 'tinyint(1) not null default 0',
    'status' => "ENUM('Active', 'Inactive', 'Suspended', 'Pending', 'Deleted') DEFAULT 'Pending'",
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    'roleId' => 'tinyint(1) not null default 1',
    'genderId' => 'tinyint(1) not null default 1'
]);

// Method to drop roles table if exists
$drop_roles = $SQL->dropTable('roles');

// Method to create roles table
$create_roles = $SQL->createTable('roles', [
    'roleId' => 'tinyint(1) AUTO_INCREMENT PRIMARY KEY',
    'roleName' => 'VARCHAR(50) NOT NULL unique',
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
]);

// Method to drop genders table if exists
$drop_genders = $SQL->dropTable('genders');

// Method to create genders table
$create_genders = $SQL->createTable('genders', [
    'genderId' => 'tinyint(1) AUTO_INCREMENT PRIMARY KEY',
    'genderName' => 'VARCHAR(50) NOT NULL unique',
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
]);

// Method to drop skills table if exists
$drop_skills = $SQL->dropTable('skills');

// Method to create skills table
$create_skills = $SQL->createTable('skills', [
    'skillId' => 'bigint(10) AUTO_INCREMENT PRIMARY KEY',
    'skillName' => 'VARCHAR(50) NOT NULL unique',
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
]);

// Method to drop user_skills table if exists
$drop_user_skills = $SQL->dropTable('user_skills');

// Method to create user_skills table
$create_user_skills = $SQL->createTable('user_skills', [
    'user_skillId' => 'bigint(10) AUTO_INCREMENT PRIMARY KEY',
    'userId' => 'bigint(10) NOT NULL',
    'skillId' => 'bigint(10) NOT NULL',
    'proficiency' => "ENUM('Beginner', 'Intermediate', 'Advanced', 'Expert') DEFAULT 'Beginner'",
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
]);

// Method to add constraints to users table
$alter_users_roles_constraint = $SQL->addConstraint('users', 'roles', 'roleId', 'CASCADE', 'CASCADE');
$alter_users_genders_constraint = $SQL->addConstraint('users', 'genders', 'genderId', 'CASCADE', 'CASCADE');

// Method to add constraints to user_skills table
$alter_user_skills_users_constraint = $SQL->addConstraint('user_skills', 'users', 'userId', 'CASCADE', 'CASCADE');
$alter_user_skills_skills_constraint = $SQL->addConstraint('user_skills', 'skills', 'skillId', 'CASCADE', 'CASCADE');

// Method to enable foreign key checks
$enable_fk_checks = $SQL->enableForeignKeyChecks();

// Message to show each operation status
$operations = [
    'Disable Foreign Key Checks' => $disable_fk_checks,
    'Drop Users Table' => $drop_users,
    'Create Users Table' => $create_users,
    'Drop Roles Table' => $drop_roles,
    'Create Roles Table' => $create_roles,
    'Drop Genders Table' => $drop_genders,
    'Create Genders Table' => $create_genders,
    'Drop Skills Table' => $drop_skills,
    'Create Skills Table' => $create_skills,
    'Drop User Skills Table' => $drop_user_skills,
    'Create User Skills Table' => $create_user_skills,
    'Alter Users Table' => $alter_users_roles_constraint,
    'Alter User Skills Table' => $alter_user_skills_users_constraint,
    'Enable Foreign Key Checks' => $enable_fk_checks
];
foreach ($operations as $operation => $result) {
    if ($result) {
        echo "$operation: Success | " . date('Y-m-d H:i:s') . "\n";
    } else {
        echo "$operation: Failed | " . date('Y-m-d H:i:s') . "\n";
    }
}