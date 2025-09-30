 <?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ClassAutoLoad.php'; // Include the autoloader

// Set user data to insert
$user_data = ['fullname' => 'Alice Okama', 'email' => 'alice.okama@yahoo.com'];

// call the insert method
$insert_result = $SQL->insert('users', $user_data);
