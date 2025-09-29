<?php
require_once '../classAutoLoad.php';

// Clear existing data
$SQL->truncate("`users`");
$SQL->truncate("`roles`");
$clear_genders = $SQL->truncate("`genders`");

if ($clear_genders === TRUE) {
    print "Genders table cleared successfully.";
}else {
    print "Error clearing genders table." . $clear_genders;
}

// Seed roles table
$insert_roles = $SQL->insert('roles', ['roleName' => 'Admin']);
$insert_roles = $SQL->insert('roles', ['roleName' => 'User']);

// Seed genders table
$insert_genders = $SQL->insert('genders', ['genderName' => 'Male']);
$insert_genders = $SQL->insert('genders', ['genderName' => 'Female']);
$insert_genders = $SQL->insert('genders', ['genderName' => 'Other']);