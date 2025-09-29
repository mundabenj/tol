<?php
// Example usage of dbConnection class
require_once 'classAutoLoad.php';

// Create table values
$insert_data = [
    'fullname' => 'Alex Okama',
    'email' => 'alex@example.com'
];

//call the insert method
$create_user = $SQL->insert('users', $insert_data);

// Check if the user was created successfully
if ($create_user === TRUE) {
    echo "User created successfully.";
} else {
    echo "Error creating user.";
}
