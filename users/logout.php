<?php

session_start();

if(isset($_SESSION['user']))
{
    unset($_SESSION['user']);
}
if(isset($_SESSION['userid']))
{
    unset($_SESSION['userid']);
}
$_SESSION['success'] = "";

header('location: ../index.php');

?>