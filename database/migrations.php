 <?php
require_once '../ClassAutoLoad.php'; // Include the autoloader

// Drop users table if exists
$drop_users = $SQL->dropTable('users');

// Method to create users table
$create_users = $SQL->createTable('users', [
    'userId' => 'bigint(10) AUTO_INCREMENT PRIMARY KEY',
    'fullname' => 'VARCHAR(50) default NULL',
    'email' => 'VARCHAR(50) default NULL unique',
    'password' => 'VARCHAR(60) NOT NULL',
    'verify_code' => 'VARCHAR(10) NOT NULL',
    'code_expiry_time' => 'DATETIME NULL',
    'mustchange' => 'tinyint(1) not null default 0',
    'status' => "ENUM('Active', 'Inactive', 'Suspended', 'Pending', 'Deleted') DEFAULT 'Pending'",
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    'roleId' => 'tinyint(1) not null default 1',
    'genderId' => 'tinyint(1) not null default 1'
]);

if ($create_users === TRUE) {
  echo "Table users created successfully | ";
} else {
  echo "Error creating table: " . $create_users;
}

// Drop roles table if exists
$drop_roles = $SQL->dropTable('roles');

// Method to create roles table
$create_roles = $SQL->createTable('roles', [
    'roleId' => 'tinyint(1) AUTO_INCREMENT PRIMARY KEY',
    'roleName' => 'VARCHAR(50) NOT NULL unique',
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
]);

if ($create_roles === TRUE) {
  echo "Table roles created successfully | ";
} else {
  echo "Error creating table: " . $create_roles;
}

// Drop genders table if exists
$drop_genders = $SQL->dropTable('genders');

// Method to create genders table
$create_genders = $SQL->createTable('genders', [
    'genderId' => 'tinyint(1) AUTO_INCREMENT PRIMARY KEY',
    'genderName' => 'VARCHAR(50) NOT NULL unique',
    'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
]);

if ($create_genders === TRUE) {
  echo "Table genders created successfully | ";
} else {
  echo "Error creating table: " . $create_genders;
}

// Alter users table to add constraints
$alter_users_table = $SQL->addConstraint('users', 'roles', 'roleId', 'CASCADE', 'CASCADE');
$alter_users_table = $SQL->addConstraint('users', 'genders', 'genderId', 'CASCADE', 'CASCADE');
if ($alter_users_table === TRUE) {
  echo "Foreign key constraints added to users table successfully | ";
} else {
  echo "Error adding foreign key constraints: " . $alter_users_table;
}

// Close the database connection
$SQL->closeConnection();
?> 