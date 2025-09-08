<?php
class forms{
    public function signup(){
?>
<form action='' method='post'>
    <input type='text' name='username' placeholder='Username' required><br><br>
    <input type='email' name='email' placeholder='Email' required><br><br>
    <input type='password' name='password' placeholder='Password' required><br><br>

    <?php $this->submit_button('Sign Up', 'signup'); ?>

    <a href='signin.php'>Already have an account? Login</a>
</form>
<?php
    }

    private function submit_button($value, $name){
?>
        <button type='submit' name='<?php echo $name; ?>'><?php echo $value; ?></button>
<?php
    }

    public function signin(){
?>
<form action='' method='post'>
    <input type='email' name='email' placeholder='Email' required><br><br>
    <input type='password' name='password' placeholder='Password' required><br><br>
    <?php $this->submit_button('Sign In', 'signin'); ?>
    <a href='./'>Don't have an account? Sign Up</a>
</form>
<?php
    }
}