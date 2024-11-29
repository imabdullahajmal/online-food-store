<?php
if(isset($_SESSION['user']) &&  $_SESSION['user']== 'cus')
{
    header("Location: cus_home.php");
    die();
}
if(isset($_SESSION['user']) &&  $_SESSION['user']== 'res')
{
    header("Location: res_home.php");
    die();
}
?>