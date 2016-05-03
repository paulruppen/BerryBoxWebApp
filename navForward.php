<?php
session_start();

$newDir=$_SESSION['dir'].'/'.$_POST['folder'];
$_SESSION['dir']=$newDir;
    
/*$folder=$_POST['folder'];
$_SESSION['filepath']=$_SESSION['filepath'].$folder.'/';
*/
echo"<script>window.location.replace('index.php')</script>";
?>