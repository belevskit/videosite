<?php

session_start();

if(isset($_SESSION['user']))
{
    unset($_SESSION['user']);
}
$_SESSION['success'] = "";

header('location: ../index.php');

?>