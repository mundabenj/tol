<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session if not already started
}

// Environment Configuration
$conf['env'] = 'development'; // Change to 'production' in a live environment

// Set timezone
date_default_timezone_set('Africa/Nairobi'); // Change to your timezone

// Set base URL dynamically

if($conf['env'] == 'production'){
    error_reporting(0); // Disable error reporting in production
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';
}else{
    error_reporting(E_ALL); // Enable all error reporting in development
    ini_set('display_errors', 1); // Display errors in development
    $base_url = 'http://localhost/'; // Use this for local development
}

// Database Configuration
$conf['db_type'] = 'PDO'; // Options: 'MySQLi' or 'PDO'
$conf['db_host'] = 'localhost'; // Use 'localhost' for local development
$conf['db_user'] = 'db_user'; // Use 'root' for local development
$conf['db_pass'] = 'db_pass';  // Use '' for local development
$conf['db_name'] = 'db_name'; // Database name
$conf['db_port'] = '3306'; // Database port

// Site Information
$conf['site_name'] = 'PRO Community';
$conf['site_initials'] = 'pro';
$conf['site_domain'] = 'procommunity.com';
$conf['site_slogan'] = 'Connecting Minds, Building Futures';
$conf['site_url'] = $base_url . $conf['db_name'] . '/';
$conf['site_title'] = $conf['site_name'] . ' - ' . $conf['site_slogan'];
$conf['site_desc'] = 'Join ' . $conf['site_name'] . ' to connect with fellow students, share knowledge, and build a brighter future together.';
$conf['site_authors'] = ['Alex Okama', $conf['site_name']];
$conf['site_email'] = 'admin@' . $conf['site_domain'];
$conf['version'] = 'v1.0.0';

// Site Language
$conf['site_lang'] = 'en';
require_once __DIR__ . "/Lang/" . $conf['site_lang'] . ".php"; // Include language file

// Email Configuration
$conf['mail_type'] = 'smtp'; // Options: 'smtp' or 'mail'
$conf['smtp_host'] = 'smtp.gmail.com'; // For Gmail SMTP
$conf['smtp_user'] = 'example@gmail.com'; // Your email address
$conf['smtp_pass'] = 'secretpassword'; // Use App Password if 2FA is enabled
$conf['smtp_port'] = 465; // For SSL
$conf['smtp_secure'] = 'ssl'; // Options: 'ssl' or 'tls'
$conf['mail_from'] = 'no-reply@' . $conf['site_domain'];
$conf['mail_from_name'] = $conf['site_name'] . ' Team';

// Valid password length
$conf['min_password_length'] = 4; // Minimum password length

// Valid email domains
$conf['valid_email_domains'] = [$conf['site_domain'], 'gmail.com', 'yahoo.com', 'outlook.com', 'strathmore.edu'];

// Set verification code
$conf['verification_code'] = rand(100000, 999999); // Example: 6-digit code

// Set code expiry time
$conf['code_expiry_time'] = 86400; // Code expiry time in seconds. Example 86400 * 2 = 48 hours