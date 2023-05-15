<?php
namespace controllers;

class SecurityController
{
    public function is_connect() {
        // session_start();
        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
        {
            return  true;
        }
        else
        {
            return false;
        }
    }
    
     public function is_admin() {
        // session_start();
        if(isset($_SESSION['admin_pseudo']) && !empty($_SESSION['admin_pseudo']))
        {
            return  true;
        }
        else
        {
            return false;
        }
    }
}