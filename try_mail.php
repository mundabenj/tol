<?php
require 'ClassAutoLoad.php';

$mailCnt = [
    'name_from' => 'sender name',
    'mail_from' => 'sender@yahoo.com',
    'name_to' => 'receiver name',
    'mail_to' => 'recipient@gmail.com',
    'subject' => 'Hello From ICS B',
    'body' => 'Welcome to ICS B! <br> This is a new semester. Let\'s have fun together.'
];

// $ObjSendMail->Send_Mail($conf, $mailCnt);


print rand(100000, 999999);