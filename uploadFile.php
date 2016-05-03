<?php
session_start();

$remoteDir=$_SESSION['dir'].'/'.$_POST['localFilePath'];
$localDir='/home/'.get_current_user().'/Uploads/'.$_POST['localFilePath'];


include('phpseclib/Net/SSH2.php');
include('phpseclib/Net/SFTP.php');

$sftp = new Net_SFTP($_SESSION['ip'], $_SESSION['port']);
if (!$sftp->login($_SESSION['user'], $_SESSION['pass'])) {
    echo"<script>window.location.replace('logout.php')</script>";
    exit('Login Failed');
}


$sftp->put($remoteDir, $localDir, NET_SFTP_LOCAL_FILE);


echo"<script>window.location.replace('index.php')</script>";
?>