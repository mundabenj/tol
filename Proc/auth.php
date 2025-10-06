<?php
class auth{

    // Method to bind email variables
    public function bindEmailVars($template, $variables) {
        foreach ($variables as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }
        return $template;
    }

    // Method to calculate time elapsed
    public function time_elapsed($secs) {
        $units = array(
            'year'   => 31556926, // Average year in seconds
            'month'  => 2629743,  // Average month in seconds
            'week'   => 604800,   // Average week in seconds
            'day'    => 86400,    // Average day in seconds
            'hour'   => 3600,     // Average hour in seconds
            'minute' => 60,       // Average minute in seconds
            'second' => 1         // Average second in seconds
        );
        $ret = [];
        foreach ($units as $name => $divisor) {
            $quot = floor($secs / $divisor);
            if ($quot) {
                $ret[] = $quot . ' ' . $name . ($quot > 1 ? 's' : '');
                $secs %= $divisor;
            }
        }
        return $ret ? implode(', ', $ret) : '0 seconds';
    }

    public function signup(){
        global $conf, $ObjFncs, $lang, $ObjSendMail, $SQL;
        // code for signup
        if(isset($_POST['signup'])){

            // Initialize an array to hold errors
            $errors = [];

            // Retrieve and sanitize user inputs
            $fullname = $_SESSION['fullname'] = $SQL->escape_values(ucwords(strtolower($_POST['fullname'])));
            $email = $_SESSION['email'] = $SQL->escape_values(strtolower($_POST['email']));
            $password = $_SESSION['password'] = $SQL->escape_values($_POST['password']);

            // Set validation rules
            if (empty($fullname)) {
                $errors['name_error'] = "Fullname is required";
            }
            if (empty($email)) {
                $errors['mail_error'] = "Email is required";
            }
            if (empty($password)) {
                $errors['password_error'] = "Password is required";
            }

            // Only allow letters, whitespaces, and hyphens in fullname
            if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
                $errors['nameFormat_error'] = "Only letters and white space allowed in fullname";
            }

            // Verify the email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['mailFormat_error'] = "Invalid email format";
            }

            // Verify email domain
            $emailDomain = substr(strrchr($email, "@"), 1);
            if (!in_array($emailDomain, $conf['valid_email_domains'])) {
                $errors['emailDomain_error'] = "Invalid email domain";
            }

            // Check if email already exists in the database
     		$spot_email_res = $SQL->count_results(sprintf("SELECT email FROM users WHERE email = '%s' LIMIT 1", $email));
			if ($spot_email_res > 0){
				$errors['emailExists_error'] = "Email already exists. Please use a different email.";
			}

            // Verify password length
            if (strlen($password) < $conf['min_password_length']) {
                $errors['passwordLength_error'] = "Password must be at least " . $conf['min_password_length'] . " characters long";
            }

            // Verify password complexity (at least one letter and one number)
            if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $password)) {
                $errors['passwordComplexity_error'] = "Password must contain at least one letter and one number";
            }

            // Check for errors
            if (!count($errors)) {
                // If no errors, proceed with signup logic
                
                // Hash the password before storing it
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Set code expiry time format for the verification code
                $code_expiry_time = date('Y-m-d H:i:s', strtotime('+' . $this->time_elapsed($conf['code_expiry_time'])));

                // Prepare user data for insertion
                $user_data = array('fullname'=>$fullname, 'email'=>$email, 'password'=>$hashed_password, 'status'=>'Pending', 'verify_code'=>$conf['verification_code'], 'code_expiry_time' => $code_expiry_time);

                // Insert user data into the database
                $save_user = $SQL->insert('users', $user_data);

                // Perform signup logic (e.g., save to database)

                if($save_user === TRUE){

                // Prepare variables to replace in email template
                $variables = [
                    'site_name' => $conf['site_name'],
                    'fullname' => $fullname,
                    'activation_code' => $conf['verification_code'],
                    'mail_from_name' => $conf['mail_from_name'],
                    'code_expiry_string' => $this->time_elapsed($conf['code_expiry_time'])
                ];

                // Prepare email content
                $mailCnt = [
                    'name_from' => $conf['mail_from_name'],
                    'mail_from' => $conf['mail_from'],
                    'name_to' => $fullname,
                    'mail_to' => $email,
                    'subject' => $this->bindEmailVars($lang['reg_ver_subject'], $variables),
                    'body' => nl2br($this->bindEmailVars($lang['reg_ver_body'], $variables))
                ];

                // Send verification email
                $ObjSendMail->Send_Mail($conf, $mailCnt); 

                // Clear session data after successful signup
                unset($_SESSION['fullname']);
                unset($_SESSION['email']);
                unset($_SESSION['password']);
                $ObjFncs->setMsg('msg', 'Sign up successful. Please check your email for the verification code', 'success'); // Success message
                header("Location: verify_code.php"); // Redirect to verification page
                exit();
                }else{
                    die('Error: ' . $save_user);
                    $ObjFncs->setMsg('msg', 'Error during sign up. Please try again later.', 'danger'); // Database error message
                    header("Location: signup.php"); // Redirect to signup page
                    exit();
                }
            }else{
                $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
                $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
                header("Location: signup.php"); // Redirect to signup page
                exit();
            }
        }
    }

public function verify_code(){
    global $conf, $ObjFncs, $lang, $ObjSendMail, $SQL;
    // code for verifying code
    if(isset($_POST['verify_code'])){

        // Initialize an array to hold errors
        $errors = [];

        // Retrieve and sanitize user inputs
        $verification_code = $SQL->escape_values($_POST['verification_code']);

            if($_SESSION['origin'] == 'forgot_password.php'){
                $redirection = "change_password.php"; // Redirect to change password page
            }else{
                $redirection = "signin.php"; // Redirect to signin page
            }

        // Set validation rules
        if (empty($verification_code)) {
            $errors['code_error'] = "Verification code is required";
        }

        // Only allow digits in verification code
        if (!preg_match("/^[0-9]*$/", $verification_code)) {
            $errors['codeFormat_error'] = "Only digits are allowed in verification code";
        }

        // Check for errors
        if (!count($errors)) {
            // If no errors, proceed with verification logic

            // Check if the verification code matches and is not expired
            $current_time = date('Y-m-d H:i:s');
            $spot_user_query = sprintf("SELECT userId, verify_code FROM users WHERE verify_code = '%s' AND code_expiry_time >= '%s' LIMIT 1", $verification_code, $current_time);
  
            if ($SQL->count_results($spot_user_query) > 0){
                $check_userId_res = $SQL->select($spot_user_query);
                // Update user status to Active and clear the verification code and expiry time
                $update_data = array('status' => 'Active', 'verify_code' => NULL, 'code_expiry_time' => NULL);
                $update_user = $SQL->update('users', $update_data, sprintf("verify_code = '%s'", $verification_code));

                if($update_user === TRUE){
                    $_SESSION['change_userId_pass'] = $check_userId_res['userId'];
                    // Clear session data after successful verification
                   unset($_SESSION['origin']);
                   unset($_SESSION['email']);
                    $ObjFncs->setMsg('msg', 'Account verified successfully. You can now sign in.', 'success'); // Success message
                    header("Location: " . $redirection); // Redirect to signin or change password page
                    exit();
                }else{
                    die('Error: ' . $update_user);
                    $ObjFncs->setMsg('msg', 'Error during account verification. Please try again later.', 'danger'); // Database error message
                    header("Location: verify_code.php"); // Redirect to verification page
                    exit();
                }
            }else{
                $errors['invalidCode_error'] = "Invalid or expired verification code";
                $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
                $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
                header("Location: verify_code.php"); // Redirect to verification page
                exit();
            }
        }else{
            $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
            $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
            header("Location: verify_code.php"); // Redirect to verification page
            exit();
        }
    }
}
public function forgot_password(){
    global $conf, $ObjFncs, $lang, $ObjSendMail, $SQL;
    // code for forgot password
    if(isset($_POST['send_code'])){

        // Initialize an array to hold errors
        $errors = [];

        // Retrieve and sanitize user inputs
        $email = $_SESSION['email'] = $SQL->escape_values(strtolower($_POST['email']));
        $origin = $_SESSION['origin'] = $SQL->escape_values($_POST['origin']);
        // Set validation rules
        if (empty($email)) {
            $errors['mail_error'] = "Email is required";
        }

        // Verify the email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['mailFormat_error'] = "Invalid email format";
        }

        // Check if email exists in the database
        $spot_email_res = $SQL->count_results(sprintf("SELECT email, fullname FROM users WHERE email = '%s' LIMIT 1", $email));
        if ($spot_email_res == 0){
            $errors['emailNotFound_error'] = "Email not found. Please check and try again.";
        }

        // Check for errors
        if (!count($errors)) {
            // If no errors, proceed with forgot password logic

            // Set code expiry time format for the verification code
            $code_expiry_time = date('Y-m-d H:i:s', strtotime('+' . $this->time_elapsed($conf['code_expiry_time'])));

            // Update user record with new verification code and expiry time
            $update_data = array('verify_code'=>$conf['verification_code'], 'code_expiry_time' => $code_expiry_time);
            $update_user = $SQL->update('users', $update_data, sprintf("email = '%s'", $email));

            if($update_user === TRUE){
                // Fetch user's fullname for email personalization
                $user_info = $SQL->select(sprintf("SELECT fullname FROM users WHERE email = '%s' LIMIT 1", $email));

                $fullname = $user_info['fullname'];
                
                // Prepare variables to replace in email template
                $variables = [
                    'site_name' => $conf['site_name'],
                    'fullname' => $fullname,
                    'activation_code' => $conf['verification_code'],
                    'mail_from_name' => $conf['mail_from_name'],
                    'code_expiry_string' => $this->time_elapsed($conf['code_expiry_time'])
                ];
                // Prepare email content
                $mailCnt = [
                    'name_from' => $conf['mail_from_name'],
                    'mail_from' => $conf['mail_from'],
                    'name_to' => $fullname,
                    'mail_to' => $email,
                    'subject' => $this->bindEmailVars($lang['pwd_reset_subject'], $variables),
                    'body' => nl2br($this->bindEmailVars($lang['pwd_reset_body'], $variables))
                ];
                // Send password reset email
                $ObjSendMail->Send_Mail($conf, $mailCnt);
                $ObjFncs->setMsg('msg', 'Password reset code sent. Please check your email.', 'success'); // Success message
                header("Location: verify_code.php"); // Redirect to verification page
            }
        }else{
            $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
            $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
            header("Location: forgot_password.php"); // Redirect to forgot password page
            exit();
        }
    }
}
public function change_password(){
    global $conf, $ObjFncs, $lang, $ObjSendMail, $SQL;
    // code for changing password

   if(isset($_POST['change_password'])){
        // Initialize an array to hold errors
        $errors = [];
        // Retrieve and sanitize user inputs
        $new_password = $_SESSION['new_password'] = $SQL->escape_values($_POST['new_password']);
        $confirm_password = $_SESSION['confirm_password'] = $SQL->escape_values($_POST['confirm_password']);
        // If coming from forgot_password.php, no need for current password check
        if(isset($_SESSION['origin']) && $_SESSION['origin'] == 'forgot_password.php') {
            $current_password = $SQL->escape_values($_POST['current_password']);
            if ($current_password !== null && empty($current_password)) {
                $errors['currentPassword_error'] = "Current password is required";
            }
        }
        // Set validation rules
        if (empty($new_password)) {
            $errors['newPassword_error'] = "New password is required";
        }
        if (empty($confirm_password)) {
            $errors['confirmPassword_error'] = "Please confirm your new password";
        }
        // Verify new password length
        if (strlen($new_password) < $conf['min_password_length']) {
            $errors['newPassword_error'] = "New password must be at least " . $conf['min_password_length'] . " characters long";
        }
        // Verify new password complexity (at least one letter and one number)
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $new_password)) {
            $errors['newPassword_error'] = "New password must contain at least one letter and one number";
        }
        // Verify new password and confirm password match
        if ($new_password !== $confirm_password) {
            $errors['confirmPassword_error'] = "New password and confirm password do not match";
        }

        // Check for errors
        if (!count($errors)) {
            // If no errors, proceed with change password logic
            // Fetch user's current password hash from the database
            $user_info = $SQL->select(sprintf("SELECT password, email, fullname FROM users WHERE userId = '%d' LIMIT 1", $_SESSION['change_userId_pass']));
            if ($user_info) {
                $email = $user_info['email'];
                $fullname = $user_info['fullname'];
                if(isset($_SESSION['origin']) && $_SESSION['origin'] == 'forgot_password.php') {
                $stored_hashed_password = $user_info['password'];
                // If current password is provided, verify it
                if ($current_password !== null && !password_verify($current_password, $stored_hashed_password)) {
                    $errors['currentPassword_error'] = "Current password is incorrect";
                    $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
                    $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
                    header("Location: change_password.php"); // Redirect to change password page
                    exit();
                }
            }
                // Hash the new password before storing it
                $hashed_confirm_password = password_hash($confirm_password, PASSWORD_BCRYPT);
                // Update user record with new password and clear verification code and expiry time
                $update_data = array('password' => $hashed_confirm_password, 'verify_code' => NULL, 'code_expiry_time' => NULL);
                $update_user = $SQL->update('users', $update_data, sprintf("userId = '%d'", $_SESSION['change_userId_pass']));
                if($update_user === TRUE){
                    // Prepare variables to replace in email template
                    $variables = [
                        'site_name' => $conf['site_name'],
                        'fullname' => $fullname,
                        'mail_from_name' => $conf['mail_from_name']
                    ];
                    // Prepare email content
                    $mailCnt = [
                        'name_from' => $conf['mail_from_name'],
                        'mail_from' => $conf['mail_from'],
                        'name_to' => $fullname,
                        'mail_to' => $email,
                        'subject' => $this->bindEmailVars($lang['pwd_change_subject'], $variables),
                        'body' => nl2br($this->bindEmailVars($lang['pwd_change_body'], $variables))
                    ];
                    // Send password changed notification email
                    $ObjSendMail->Send_Mail($conf, $mailCnt);
                    // Clear session data after successful password change
                    unset($_SESSION['email']);
                    $ObjFncs->setMsg('msg', 'Your password has been changed successfully.', 'success');
                    header("Location: signin.php");
                    exit();
                }
            }
        }else{
                $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
                $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
                header("Location: change_password.php"); // Redirect to change password page
                exit();
            }
        }
    }
public function signin(){
    global $conf, $ObjFncs, $lang, $ObjSendMail, $SQL;
    // code for signin
    if(isset($_POST['signin'])){

        // Initialize an array to hold errors
        $errors = [];

        // Retrieve and sanitize user inputs
        $email = $_SESSION['email'] = $SQL->escape_values(strtolower($_POST['email']));
        $password = $_SESSION['password'] = $SQL->escape_values($_POST['password']);

        // Set validation rules
        if (empty($email)) {
            $errors['mail_error'] = "Email is required";
        }
        if (empty($password)) {
            $errors['password_error'] = "Password is required";
        }

        // Verify the email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['mailFormat_error'] = "Invalid email format";
        }

        // Check for errors
        if (!count($errors)) {
            // If no errors, proceed with signin logic

            // Fetch user's record from the database
            $user_info = $SQL->select(sprintf("SELECT userId, fullname, email, password, status FROM users WHERE email = '%s' LIMIT 1", $email));
            if ($user_info) {
                $stored_hashed_password = $user_info['password'];
                $status = $user_info['status'];
                // Verify the password
                if (password_verify($password, $stored_hashed_password)) {
                    if ($status === 'Active') {
                        // Password is correct and account is active
                        // Clear session data after successful signin
                        unset($_SESSION['email']);
                        unset($_SESSION['password']);
                        // Set user session or cookie as needed
                        $_SESSION['userId'] = $user_info['userId'];
                        $_SESSION['fullname'] = $user_info['fullname'];
                        $_SESSION['email'] = $user_info['email'];
                        $_SESSION['consort'] = true; // Example session variable to indicate logged-in status
                        $ObjFncs->setMsg('msg', 'Signin successful. Welcome back!', 'success'); // Success message
                        header("Location: dashboard.php"); // Redirect to dashboard or home page
                        exit();
                    } else {
                        $errors['accountStatus_error'] = "Your account is not active. Please verify your email or contact support.";
                        $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
                        $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
                        header("Location: signin.php"); // Redirect to signin page
                        exit();
                    }
                } else {
                    $errors['invalidCredentials_error'] = "Invalid email or password";
                    $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
                    $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
                    header("Location: signin.php"); // Redirect to signin page
                    exit();
                }
            } else {
                $errors['userNotFound_error'] = "User not found";
                $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
                $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
                header("Location: signin.php"); // Redirect to signin page
                exit();
            }
        }else{
            $ObjFncs->setMsg('errors', $errors, 'danger'); // Set errors in session
            $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger'); // General error message
            header("Location: signin.php"); // Redirect to signin page
            exit();
        }
    }
}
// Method to handle signout
    public function signout(){
        global $ObjFncs, $conf;
        // Signout process
        if(isset($_GET["signout"])){
                // Clear all session data
                unset($_SESSION["consort"]);
                session_destroy();
                header("Location: signin.php"); // Redirect to signin page
                exit();
        }
    }
}