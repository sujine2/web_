<?php
session_start(); // 세션

if($_SESSION['user_id']!=null){
   session_destroy();
}
header ("Location:index.php");
 ?>
