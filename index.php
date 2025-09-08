<?php
    require 'ClassAutoLoad.php';

    // Using the class methods
    print $layout->header($conf);
    $form->signup();
    print $layout->footer($conf);
