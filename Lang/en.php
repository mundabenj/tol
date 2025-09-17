<?php
// Subject of the email sent to user when they register an account
$lang["ver_reg_subj"] = "Account Activation on {{site_name}}";

// Body of the email sent to user when they register an account
$lang["ver_reg_body"] = "
Hello {{fullname}},
You have requested an account on <strong>{{site_name}}</strong>.
Your activation code is:
<h1>{{activation_code}}</h1>
Regards,
Systems Admin
{{site_name}}
";