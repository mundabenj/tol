<?php
class forms {

    private function submit_button($value, $name) {
        ?>
        <button type="submit" class="btn btn-primary" name="<?php echo $name; ?>" value="<?php echo $value; ?>"><?php echo $value; ?></button>
        <?php
    }

    public function signup() {
      global $conf, $ObjFncs;
      $err = $ObjFncs->getMsg('errors'); print $ObjFncs->getMsg('msg');
    ?>
<h1>Sign Up</h1>
<form action="" method="post" autocomplete="off">
  <div class="mb-3">
    <label for="fullname" class="form-label">Fullname</label>
    <input type="text" class="form-control" id="fullname" name="fullname" aria-describedby="nameHelp" maxlength="50" value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>" placeholder="Enter your fullname" required>
    <?php print (isset($err['nameFormat_error']) ? '<div id="nameHelp" class="alert alert-danger">'.$err['nameFormat_error'].'</div>' : ''); ?>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" maxlength="100" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" placeholder="Enter your email" required>
    <?php print (isset($err['mailFormat_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['mailFormat_error'].'</div>' : ''); ?>
    <?php print (isset($err['emailDomain_error']) ? '<div id="nameHelp" class="alert alert-danger">'.$err['emailDomain_error'].'</div>' : ''); ?>
    <?php print (isset($err['emailExists_error']) ? '<div id="nameHelp" class="alert alert-danger">'.$err['emailExists_error'].'</div>' : ''); ?>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>" placeholder="Enter your password" required>
    <?php print (isset($err['passwordLength_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['passwordLength_error'].'</div>' : ''); ?>
    <?php print (isset($err['passwordComplexity_error']) ? '<div id="nameHelp" class="alert alert-danger">'.$err['passwordComplexity_error'].'</div>' : ''); ?>
    <input type="hidden" name="origin" value="<?php print basename($_SERVER['PHP_SELF']); ?>">
  </div>
          <?php $this->submit_button("Sign Up", "signup"); ?> Already have an account? <a href="signin.php">Sign In</a>
</form>

<?php
    }

    public function verify_code() {
      global $conf, $ObjFncs;
      $err = $ObjFncs->getMsg('errors'); print $ObjFncs->getMsg('msg');
        ?>
    <h1>Code Verification</h1>
    <form action="" method="post" autocomplete="off">
      <div class="mb-3">
        <label for="verification_code" class="form-label">Verification Code</label>
        <input type="number" class="form-control" id="verification_code" name="verification_code" maxlength="6" placeholder="Enter your verification code" required>
        <?php print (isset($err['code_error']) ? '<div id="codeHelp" class="alert alert-danger">'.$err['code_error'].'</div>' : ''); ?>
        <?php print (isset($_SESSION['verification_code']) ? '<div id="codeHelp" class="alert alert-danger">'.$_SESSION['verification_code'].'</div>' : ''); ?>
        <?php print (isset($err['codeFormat_error']) ? '<div id="codeHelp" class="alert alert-danger">'.$err['codeFormat_error'].'</div>' : ''); ?>
      </div>
      <?php $this->submit_button("Verify Code", "verify_code"); ?> Can't verify? <a href="forgot_password.php">Resend code</a>
    </form>
    <?php
    }

    public function forgot_password() {
      global $conf, $ObjFncs;
      $err = $ObjFncs->getMsg('errors'); print $ObjFncs->getMsg('msg');
        ?>
    <h1>Forgot Password</h1>
    <form action="" method="post" autocomplete="off">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
        <?php print (isset($err['mailFormat_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['mailFormat_error'].'</div>' : ''); ?>
        <?php print (isset($err['emailNotFound_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['emailNotFound_error'].'</div>' : ''); ?>
        <input type="hidden" name="origin" value="<?php print basename($_SERVER['PHP_SELF']); ?>">
      </div>
      <?php $this->submit_button("Send Code", "send_code"); ?> Dont have an account? <a href="signup.php">Sign up</a>
    </form>
    <?php
    }
public function change_password() {
      global $conf, $ObjFncs;
      $err = $ObjFncs->getMsg('errors'); print $ObjFncs->getMsg('msg');
        ?>
    <h1>Change Password</h1>
    <form action="" method="post" autocomplete="off">
      
      <?php if(isset($_SESSION['origin']) && $_SESSION['origin'] == 'forgot_password.php') { ?>
      <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" class="form-control" id="current_password" name="current_password" value="<?php echo isset($_SESSION['current_password']) ? $_SESSION['current_password'] : ''; ?>" required>
        <?php print (isset($err['currentPassword_error']) ? '<div id="currentPasswordHelp" class="alert alert-danger">'.$err['currentPassword_error'].'</div>' : ''); ?>
      </div>
      <?php } ?>
      <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new_password" name="new_password" value="<?php echo isset($_SESSION['new_password']) ? $_SESSION['new_password'] : ''; ?>" required>
        <?php print (isset($err['newPassword_error']) ? '<div id="newPasswordHelp" class="alert alert-danger">'.$err['newPassword_error'].'</div>' : ''); ?>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?php echo isset($_SESSION['confirm_password']) ? $_SESSION['confirm_password'] : ''; ?>" required>
        <?php print (isset($err['confirmPassword_error']) ? '<div id="confirmPasswordHelp" class="alert alert-danger">'.$err['confirmPassword_error'].'</div>' : ''); ?>
      </div>
      <?php $this->submit_button("Change Password", "change_password"); ?> Remembered your password? <a href="signin.php">Sign In</a>
    </form>
    <?php
    }

    public function signin() {
      global $conf, $ObjFncs;
      $err = $ObjFncs->getMsg('errors'); print $ObjFncs->getMsg('msg');
        ?>
    <h1>Sign In</h1>
    <form action="" method="post" autocomplete="off">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" maxlength="100" placeholder="Enter your email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
        <?php print (isset($err['mailFormat_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['mailFormat_error'].'</div>' : ''); ?>
        <?php print (isset($err['emailNotFound_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['emailNotFound_error'].'</div>' : ''); ?>
        <?php print (isset($err['accountInactive_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['accountInactive_error'].'</div>' : ''); ?>
        <?php print (isset($err['accountSuspended_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['accountSuspended_error'].'</div>' : ''); ?>
        <?php print (isset($err['accountDeleted_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['accountDeleted_error'].'</div>' : ''); ?>
        <?php print (isset($err['invalidCredentials_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['invalidCredentials_error'].'</div>' : ''); ?>
        <?php print (isset($err['userNotFound_error']) ? '<div id="emailHelp" class="alert alert-danger">'.$err['userNotFound_error'].'</div>' : ''); ?>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="Enter your password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>" required>
        <?php print (isset($err['passwordFormat_error']) ? '<div id="passwordHelp" class="alert alert-danger">'.$err['passwordFormat_error'].'</div>' : ''); ?>
        <?php print (isset($err['invalidCredentials_error']) ? '<div id="passwordHelp" class="alert alert-danger">'.$err['invalidCredentials_error'].'</div>' : ''); ?>
        <?php print (isset($err['userNotFound_error']) ? '<div id="passwordHelp" class="alert alert-danger">'.$err['userNotFound_error'].'</div>' : ''); ?>
        <?php print (isset($err['invalidLogin_error']) ? '<div id="passwordHelp" class="alert alert-danger">'.$err['invalidLogin_error'].'</div>' : ''); ?>
        <input type="hidden" name="origin" value="<?php print basename($_SERVER['PHP_SELF']); ?>">

      </div>
        <?php $this->submit_button("Sign In", "signin"); ?> Don't have an account? <a href="signup.php">Sign up</a> Or <a href="forgot_password.php">Reset password</a>
    </form>
        <?php
    }
}