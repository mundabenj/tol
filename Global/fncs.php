<?php
class fncs{
    // Set session message
    public function setMsg($name, $value, $class){
        if(is_array($value)){
            $_SESSION[$name] = $value;
        }else{
            $_SESSION[$name] = "<div class='alert alert-$class' role='alert'>$value</div>";
        }
    }

    // Display session message
    public function getMsg($name){
        if(isset($_SESSION[$name])){
            $msg = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $msg;
        }
        return null;
    }
}