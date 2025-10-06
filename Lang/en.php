<?php

// email subject for registration verification
$lang['reg_ver_subject'] = "Account Activation Code - {{site_name}}";

// email body for registration verification
$lang['reg_ver_body'] = "
Hello {{fullname}},

You requested an account on <strong>{{site_name}}</strong>.
Your activation code is:
<h2>{{activation_code}}</h2>
The verification code is valid for {{code_expiry_string}}.
If you did not request this, please ignore this email.
Regards,
{{mail_from_name}}
";

// email subject for password reset
$lang['pwd_reset_subject'] = "Password Reset Code - {{site_name}}";

// email body for password reset
$lang['pwd_reset_body'] = "
Hello {{fullname}},
You requested a password reset on <strong>{{site_name}}</strong>.
Your password reset code is:
<h2>{{activation_code}}</h2>
The reset code is valid for {{code_expiry_string}}.
If you did not request this, please ignore this email.
Regards,
{{mail_from_name}}
";

// email subject for password change confirmation
$lang['pwd_change_subject'] = "Password Changed - {{site_name}}";

// email body for password change confirmation
$lang['pwd_change_body'] = "
Hello {{fullname}},
Your password has been successfully changed on <strong>{{site_name}}</strong>.
If you did not make this change, please contact support immediately.
Regards,
{{mail_from_name}}
";