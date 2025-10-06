<?php
// Check if configuration file exists
if (!file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'conf.php')) {
    die('Configuration file not found. Please create conf.php from conf.sample.php and configure it.');
}

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'conf.php'; // Include configuration file
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "Includes/dbConnection.php";
// Directories to search for class files
$directories = ["Forms", "Layouts", "Globals", "Proc"];

// Autoload classes from specified directories
spl_autoload_register(function ($className) use ($directories) {
    foreach ($directories as $directory) {
        $filePath = __DIR__ . "/$directory/" . $className . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
});

/* Create the DB Connection */
$SQL = New dbConnection($conf['db_type'], $conf['db_host'], $conf['db_name'], $conf['db_user'], $conf['db_pass'], $conf['db_port']);
// print'<pre>'; print_r($SQL); print'</pre>';


// Instantiate objects
$ObjSendMail = new SendMail();
$ObjForm = new forms();
$ObjLayout = new layouts();

$ObjAuth = new Auth();
$ObjFncs = new fncs();

$ObjAuth->signup();
$ObjAuth->verify_code();
$ObjAuth->forgot_password();
$ObjAuth->change_password();
$ObjAuth->signin();
$ObjAuth->signout();

// All files that must verify user is logged in
$protected_files = ['dashboard.php'];
if (in_array(basename($_SERVER['PHP_SELF']), $protected_files)) {
    $ObjFncs->checksignin();
}