<?php
// Site timezone
$conf['site_timezone'] = 'Africa/Nairobi';

// Site information
$conf['site_name'] = 'ICS B Academy';
$conf['site_url'] = 'http://localhost/tol';
$conf['admin_email'] = 'admin@icsbacademy.com';

// Site language
$conf['site_lang'] = 'en';

// Database configuration
$conf['db_type'] = 'pdo';
$conf['db_host'] = 'localhost';
$conf['db_user'] = 'root';
$conf['db_pass'] = '';
$conf['db_name'] = 'tol';

// Email configuration
$conf['mail_type'] = 'smtp'; // Options: 'smtp' or 'mail'
$conf['smtp_host'] = 'smtp.gmail.com';
$conf['smtp_user'] = 'your_email@gmail.com'; // Replace with your actual SMTP email
$conf['smtp_pass'] = 'yourpasswordhere'; // Replace with your actual SMTP password
$conf['smtp_port'] = 465;
$conf['smtp_secure'] = 'ssl';