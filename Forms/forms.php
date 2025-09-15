<?php
class forms{
    public function signup($conf, $ObjFncs){
      $err = $ObjFncs->getMsg('errors');
      print $ObjFncs->getMsg('msg');
?>
<h2>Sign Up Here</h2>
<form action="" method="post" autocomplete="off">
  <div class="mb-3">
    <label for="fullname" class="form-label">Fullname</label>
    <input type="text" class="form-control" id="fullname" name="fullname" aria-describedby="nameHelp" maxlength="50" placeholder="Enter your fullname" value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>" required>
    <?php if(isset($err['fullname_error'])) { ?><div id="nameHelp" class="alert alert-danger" role="alert"><?php echo $err['fullname_error']; ?></div><?php } ?>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" maxlength="100" placeholder="Enter your email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
    <?php if(isset($err['mailFormat_error'])) { ?><div id="emailHelp" class="alert alert-danger" role="alert"><?php echo $err['mailFormat_error']; ?></div><?php } ?>
    <?php if(isset($err['mailDomain_error'])) { ?><div id="emailHelp" class="alert alert-danger" role="alert"><?php echo $err['mailDomain_error']; ?></div><?php } ?>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>" required>
    <?php if(isset($err['password_error'])) { ?><div id="passwordHelp" class="alert alert-danger" role="alert"><?php echo $err['password_error']; ?></div><?php } ?>
  </div>
      <?php $this->submit_button('Sign Up', 'signup'); ?> <a href='signin.php'>Already have an account? Login</a>
</form>

<?php
    }
    private function submit_button($value, $name){
?>
        <button type='submit' class="btn btn-primary" name='<?php echo $name; ?>'><?php echo $value; ?></button>
<?php
    }
    public function signin($conf, $ObjFncs){
?>
<h2>Sign In Here</h2>
<form>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div>
    <?php $this->submit_button('Sign In', 'signin'); ?> <a href='signup.php'>Don't have an account? Sign Up</a>
</form>
<?php
    }
}