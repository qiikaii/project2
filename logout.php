<?php
session_start();
setcookie (session_id(), "", time() - 3600);
session_regenerate_id(true);
session_unset();
session_destroy();
unset($_SESSION);

 header("location:loginpage.php");
    

?>
