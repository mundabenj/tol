<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ClassAutoLoad.php';

$ObjLayout->header($conf);
$ObjLayout->navbar($conf);
$ObjLayout->banner($conf);
$ObjLayout->form_content($conf, $ObjForm, $ObjFncs);
$ObjLayout->footer($conf);