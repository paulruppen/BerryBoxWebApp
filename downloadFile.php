<?php
session_start();

//require'sshClass.php';
//require'connect.php';

$remoteDir=$_POST['remoteDir'];
$localDir=$_POST['localDir'];
$file=$_POST['file'];


include('phpseclib/Net/SSH2.php');
include('phpseclib/Net/SFTP.php');

$sftp = new Net_SFTP($_SESSION['ip'], $_SESSION['port']);
if (!$sftp->login($_SESSION['user'], $_SESSION['pass'])) {
    echo"<script>window.location.replace('logout.php')</script>";    
    exit('Login Failed');
}

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header('Content-disposition: attachment; filename="'.$file.'"');

echo $sftp->get($remoteDir.'/'.$file);
$sftp->get($remoteDir.'/'.$file, $localDir.'/'.$file);

?>