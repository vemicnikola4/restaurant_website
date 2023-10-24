<?php
session_start();

session_unset();
    //$_SESSION = [];
session_destroy();
// unset ($_COOKIE ['user']);
setcookie ('user',0, time()-60*60*24, "/");
header("Location: admin.php");

?>