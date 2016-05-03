<?php
session_start();

$remoteDir=$_SESSION['remoteDir'];
$file=$_SESSION['file'];

include('phpseclib/Net/SSH2.php');
include('phpseclib/Net/SFTP.php');    

$sftp = new Net_SFTP($_SESSION['ip'], $_SESSION['port']);
if (!$sftp->login($_SESSION['user'], $_SESSION['pass'])) {
    echo"<script>window.location.replace('logout.php')</script>";    
    exit('Login Failed');
}

$sftp->delete($remoteDir.'/'.$file,true);



echo"<script>window.location.replace('index.php')</script>";
?>