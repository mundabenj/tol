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

    public function signup($conf, $ObjFncs, $lang, $ObjSendMail, $SQL){
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
}