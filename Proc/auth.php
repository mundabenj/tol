<?php
class auth{

    // Method to bind email template variables
    public function bindEmailTemplate($template, $variables) {
        foreach ($variables as $key => $value) {
            $template = str_replace("{{" . $key . "}}", $value, $template);
        }
        return $template;
    }

    public function signup($conf, $ObjFncs, $lang, $ObjSendMail){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])){

        $errors = array(); // Initialize an array to hold error messages

        $fullname = $_SESSION['fullname'] = ucwords(strtolower($_POST['fullname']));
        $email = $_SESSION['email'] = strtolower($_POST['email']);
        $password = $_SESSION['password'] = $_POST['password'];

            // Simple validation (you can expand this as needed)

            // Verify fullname
            if(empty($fullname) || !preg_match("/^[a-zA-Z ]*$/", $fullname)) {
                $errors['fullname_error'] = "Only letters and white space allowed in fullname";
            }

            // Verify email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['mailFormat_error'] = "Invalid email format";
            }

            // Verify if the email domainis valid
            $email_domain = substr(strrchr($email, "@"), 1);
            if (!in_array($email_domain, $conf['valid_email_domain'])) {
                $errors['mailDomain_error'] = "Email domain must be one of the following: " . implode(", ", $conf['valid_email_domain']);
            }
            // Verify password length
            if(strlen($password) < $conf['min_password_length']) {
                $errors['password_error'] = "Password must be at least " . $conf['min_password_length'] . " characters long";
            }

            // If there are errors, display them
            if(!count($errors)){

                // Bind email template variables
                $email_variables = [
                    'site_name' => $conf['site_name'],
                    'fullname' => $fullname,
                    'activation_code' => $conf['reg_ver_code'] // This should be a real activation code
                ];

                $mailCnt = [
                    'name_from' => $conf['site_name'],
                    'mail_from' => $conf['admin_email'],
                    'name_to' => $fullname,
                    'mail_to' => $email,
                    'subject' => $this->bindEmailTemplate($lang["ver_reg_subj"], $email_variables),
                    'body' => nl2br($this->bindEmailTemplate($lang["ver_reg_body"], $email_variables))
                ];

                $ObjSendMail->Send_Mail($conf, $mailCnt);

                // No errors, proceed with further processing (e.g., save to database)
                // die($fullname . ' ' . $email . ' ' . $password);
                $ObjFncs->setMsg('msg', 'Signup successful! Please check your email for activation instructions.', 'success');

                // Clear session data after successful signup
                unset($_SESSION['fullname']);
                unset($_SESSION['email']);
                unset($_SESSION['password']);
            } else {
                // Setting errors
                $ObjFncs->setMsg('errors', $errors, 'danger');
                $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger');
            }

    }
    }
}