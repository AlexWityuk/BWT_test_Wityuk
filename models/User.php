<?php
namespace models;

class User {

    public static function checkName($name){
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }
    
    public static function checkSubject($subject){
        if (strlen($subject) >= 2) {
            return true;
        }
        return false;
    }
            
    public static function checkEmail($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    
    public static function checkMessage($comments){
        if (strlen($comments) >= 2) {
            return true;
        }
        return false;
    }

}

