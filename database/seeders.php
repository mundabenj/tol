<?php
// define database constants
require_once '../ClassAutoLoad.php';

// Seed roles data
$insert_roles = $SQL->insert('roles', array('roleName' => 'Admin'));
$insert_roles = $SQL->insert('roles', array('roleName' => 'User'));
$insert_roles = $SQL->insert('roles', array('roleName' => 'Guest'));
if ($insert_roles === TRUE) {
    echo "Roles seeded successfully. | ";
} else {
    echo "Error seeding roles: " . $insert_roles;
}

// Seed genders data
$insert_genders = $SQL->insert('genders', array('genderName' => 'Male'));
$insert_genders = $SQL->insert('genders', array('genderName' => 'Female'));
$insert_genders = $SQL->insert('genders', array('genderName' => 'Other'));

// Check if genders were seeded successfully
if ($insert_genders === TRUE) {
    echo "Genders seeded successfully. | ";
} else {
    echo "Error seeding genders: " . $insert_genders;
}