<?php

require 'Plugins/PHPMailer/vendor/autoload.php';
require 'conf.php';
$directories = ['Layouts', 'Forms', 'Global'];

spl_autoload_register(function ($class_name) use ($directories) {
    foreach ($directories as $directory) {
        $file = __DIR__ . '/' . $directory . '/' . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
// Create an instance of the class
$ObjSendMail = new SendMail();
$ObjLayout = new Layouts();
$ObjForm = new Forms();