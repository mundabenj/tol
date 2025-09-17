<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Site timezone
$conf['site_timezone'] = 'Africa/Nairobi';

// Site information
$conf['site_name'] = 'ICS B Academy';
$conf['site_url'] = 'http://localhost/tol';
$conf['admin_email'] = 'admin@icsbacademy.com';

// Site language
$conf['site_lang'] = 'en';
require_once __DIR__ . '/Lang/' . $conf['site_lang'] . '.php';

// Database configuration
$conf['db_type'] = 'pdo';
$conf['db_host'] = 'localhost';
$conf['db_user'] = 'root';
$conf['db_pass'] = '';
$conf['db_name'] = 'tol';

// Email configuration
$conf['mail_type'] = 'smtp'; // Options: 'smtp' or 'mail'
$conf['smtp_host'] = 'smtp.gmail.com';
$conf['smtp_user'] = 'example@gmail.com'; // Replace with your actual SMTP email
$conf['smtp_pass'] = 'yourpasswordhere'; // Replace with your actual SMTP password
$conf['smtp_port'] = 465;
$conf['smtp_secure'] = 'ssl';


// Set password length
$conf['min_password_length'] = 8;

// Set valid email domain (for example: 'icsbacademy.com')
$conf['valid_email_domain'] = ['icsbacademy.com', 'yahoo.com', 'gmail.com', 'outlook.com', 'hotmail.com', 'strathmore.edu'];

// Set random verification code
$conf['reg_ver_code'] = rand(100000, 999999);

// Set verification code expiry time (in minutes)
$conf['ver_code_expiry'] = 10;