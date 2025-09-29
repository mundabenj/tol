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
}