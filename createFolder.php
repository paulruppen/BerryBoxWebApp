<?php
session_start();

$newFolderName=$_POST['newFolderName'];

include('phpseclib/Net/SSH2.php');
include('phpseclib/Net/SFTP.php');

$sftp = new Net_SFTP($_SESSION['ip'], $_SESSION['port']);
if (!$sftp->login($_SESSION['user'], $_SESSION['pass'])) {
    echo"<script>window.location.replace('logout.php')</script>";    
    exit('Login Failed');
}

$sftp->chdir($_SESSION['dir']);

$sftp->mkdir($newFolderName);


echo"<script>window.location.replace('index.php')</script>";



?>