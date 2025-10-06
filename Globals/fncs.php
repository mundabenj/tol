<?php
class fncs{
    // Function to set messages in session
    public function setMsg($name, $value, $class){
        if(is_array($value)){
            $_SESSION[$name] = $value;
        } else {
            $_SESSION[$name] = "<div class='alert alert-$class' role='alert'>$value</div>";
        }
    }

    // Function to get and clear messages from session
    public function getMsg($name){
        if(isset($_SESSION[$name])){
            $msg = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $msg;
        }
        return null;
    }

    // Function to redirect home page after signin
    public function home_url(){
        global $conf;
        if(!isset($_SESSION['consort']) || $_SESSION['consort'] !== true) {
                $home_url = $conf['site_url']; // Redirect to signin page if not logged in
            }else{
                $home_url = 'dashboard.php'; // Redirect to dashboard if logged in
            }
        return $home_url;
    }

    // Function to ensure user is signed in
    public function checksignin() {
        global $conf;
        if (!isset($_SESSION["consort"]) || $_SESSION["consort"] !== true) {
            $this->setMsg('msg', 'User must signin.', 'warning');
            header("Location: " . $conf['site_url'] . "signin.php");
            exit ();
        }
    }
}