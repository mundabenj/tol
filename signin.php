<?php
    require 'ClassAutoLoad.php';

    // Using the class methods
    print $layout->header($conf);
    $form->signin();
    print $layout->footer($conf);
