<?php
session_start();

$_SESSION['remoteDir']=$_POST['remoteDir'];
$_SESSION['file']=$_POST['file'];

echo'<script language="JavaScript" type="text/javascript">
    var conf=confirm("Are you sure you want to delete '.$_SESSION['remoteDir'].'/'.$_SESSION['file'].'?");
    if(conf==false){
        window.location.replace("index.php");
    }
    else
        window.location.replace("deleteFile.php");
    </script>';


?>