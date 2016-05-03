<?php
session_start();
if(!isset($_POST['x']))
{
    $_SESSION['dir']='/home/'.$_SESSION['user'];
}
else
{
    $x=$_POST['x'];
    $pathToDir=[];
    $pathToDir=$_SESSION['pathToDir'];
    //$path_parts = pathinfo($_SESSION['dir']);
    //$_SESSION['dir']=$path_parts['dirname'];
    $_SESSION['dir']='';
    for($i=0;$i<=$x;$x--){
         
        $_SESSION['dir']='/'.$pathToDir[$x].''.$_SESSION['dir'];
        
    }
}


echo"<script>window.location.replace('index.php')</script>";

?>