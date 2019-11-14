<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}

// first time user
if (!isset($_SESSION['member_id'])){
    $_SESSION['email'] = 'public@public.com';
    $_SESSION['member_id'] = '12345';
} 

//in navbar, if email = public@public.com then log in
// if email != public@public.com, then log out

