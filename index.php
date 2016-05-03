<!doctype html>
<html>
    <body>
        <head>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css" rel="stylesheet"/>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
            <script type="text/javascript" src="jquery.js"></script>
            <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
            <title>BerryBox</title>
            <link rel="shortcut icon" href="images/berrybox2.ico"/>
            <script language="JavaScript" type="text/javascript">
                
                
                function pastePath(Path, textID) {
                    document.getElementById(textID).value = Path.value;
                }
               
            </script>
        </head>
    <main>
        
        <?php
        session_start();
        include('phpseclib/Net/SSH2.php');
        include('phpseclib/Net/SFTP.php');
        
        if(!isset($_SESSION['user'])){
            $_SESSION['user'] = $_POST['username'];
            $_SESSION['ip'] = $_POST['ip']; 
            $_SESSION['port'] =$_POST['port']; 
            $_SESSION['pass'] = $_POST['pass'];
        }
        $sftp = new Net_SFTP($_SESSION['ip'], $_SESSION['port']);
        if (!$sftp->login($_SESSION['user'], $_SESSION['pass'])) {
            echo"<script>window.location.replace('logout.php')</script>";
            exit('Login Failed ');
        }
        $user=$_SESSION['user'];
                    
        
        
        function fileSizeUnits($bytes)
        {
            if ($bytes>=1073741824)
            {
                $bytes=number_format($bytes / 1073741824, 2).' GB';
            }
            elseif ($bytes>=1048576)
            {
                $bytes=number_format($bytes / 1048576, 2).' MB';
            }
            elseif ($bytes>=1024)
            {
                $bytes=number_format($bytes/1024, 2).' KB';
            }
            elseif ($bytes>1)
            {
                $bytes=$bytes.' bytes';
            }
            elseif ($bytes==1)
            {
                $bytes=$bytes.' byte';
            }
            else
            {
                $bytes='0 bytes';
            }

            return $bytes;
        }
        
        
        ?>
        
        <nav class="light-green darken-3">
            <div class="navbar-wrapper container">
                <div class="brand-logo center"><a href="navBackward.php"><img src="images/berrybox2.png" width="50" style="padding-top:5px">BerryBox</a></div>
                
                <ul class="right">
                    <li><?php echo $_SESSION['user']; ?></li>
                    <!--<li><a href="#">Home</a></li>-->
                    <li> <a href="logout.php" method="post">Log out</a> </li>
                </ul>
            </div>
        </nav>
        
        <div class="container">
            <div class="row">
                <!--<div class="col s3">
                    <div class="card-panel">
                        



                    </div>
                </div>-->
                <div class="col s12">
                    <div class="card-panel">
                        <form name="uploadFileForm" id="uploadFileForm" action="uploadFile.php" method="post">
                            <input type="submit" value="Upload File">
                            <div class="file-field input-field">    
                                <div class="btn">
                                    <span>Select File</span>
                                    <input type="file" id="file" name="file" onchange="pastePath(this, 'localFilePath');"> 
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" id="localFilePath" name="localFilePath" readonly="readonly">
                                </div>
                            </div>
                        </form>
                        <br>
                        
                        <?php
                                                
                        if(!isset($_SESSION['dir']))
                            $_SESSION['dir']=$sftp->pwd();
                        
                        $pathParts=pathinfo($_SESSION['dir']);
                        $continue=true;
                        
                        $pathToDir=[];
                        while($continue==true){
                            if(strcmp($pathParts['dirname'],'/')==0){
                                $continue=false;
                            }
                            $pathToDir[]=$pathParts['basename'];
                            $pathParts=pathinfo($pathParts['dirname']);
                            
                            
                        }
                        
                        $_SESSION['pathToDir']=[];
                        $_SESSION['pathToDir']=array_reverse($pathToDir);
                        $x=0;
                        foreach($_SESSION['pathToDir'] as $value){
                            if($x+1==count($pathToDir)){
                                echo '/'.$value;
                            }
                            else
                            {
                                echo '<form action="navBackward.php" method="post">
                                /<input type="submit" value="'.$value.'">
                                <input type="hidden" value="'.$x.'" id="x" name="x">
                                </form>';
                            }
                            $x++;
                        }
                            
                        echo '
                        <span style="float:right">
                        
                        <form action="createFolder.php" method="post">
                        <button class="btn waves-effect waves-light" type="submit" name="action" style="float:right">Create Folder
                        </button>
                        <input placeholder="Folder Name" id="newFolderName" name="newFolderName" style="moz-box-shadow: 0px;box-shadow: 0px;width:200px">
                        </form>
                        </span>';
                        
                        echo '<br><br><h5>Files:</h5><hr>';
                        
                        $sftp->setListOrder('size', SORTDESC, $_SESSION['dir'], SORT_ASC);
                        foreach($sftp->rawlist($_SESSION['dir']) as $folder => $attr) {
                            
                            if (strpos($folder, '.') === 0)
                                continue;
                            
                            if ($attr['type'] == NET_SFTP_TYPE_DIRECTORY) {
                                echo 
                                    '<form action="navForward.php" method="post">
                                    <img src="images/folder.png" width="20"><input type="submit" value="'.$folder.'" id="folder" name="folder">
                                    </form>
                                    
                                    <span style="float:right">
                                    <form id="deleteFolderForm" name="deleteFolderForm" action="confirmDelete.php" method="post">
                                    <input type="image" src="images/trash.png" width="20">
                                    <input type="hidden" name="remoteDir" id="remoteDir" value="'.$_SESSION['dir'].'">
                                    <input type="hidden" name="file" id="file" value="'.$folder.'">
                                    </form>
                                    
                                    
                                    <form id="downloadFolderForm" name="downloadFolderForm" action="downloadFile.php" method="post">
                                    <input type="image" src="images/Download.png" width="20">
                                    <input type="hidden" name="remoteDir" id="remoteDir" value="'.$_SESSION['dir'].'">
                                    <input type="hidden" name="localDir" id="localDir" value="/home/'.get_current_user().'/Downloads">
                                    <input type="hidden" name="folder" id="folder" value="'.$folder.'">
                                    </form></span>';
                                echo'<hr>';
                            }
                            
                        }
                        
                        foreach($sftp->rawlist($_SESSION['dir']) as $file => $attr) {
                            
                            if (strpos($file, '.') === 0)
                                continue;
                            
                            if ($attr['type'] != NET_SFTP_TYPE_DIRECTORY) {
                                if(strpos($file, '.zip') !== false || strpos($file, '.tar') !== false){
                                    $imgfile='images/zip.png';
                                }
                                else if(strpos($file, '.png') !== false || strpos($file, '.jpg') !== false ||strpos($file, '.gif') !== false ||strpos($file, '.jpeg') !== false ||strpos($file, '.pdf') !== false){
                                    $imgfile='images/image.png';
                                }
                                else{
                                    $imgfile='images/file.png';
                                }
                                echo 
                                    '<img src="'.$imgfile.'" width="20">'.$file.'
                                    
                                    <span style="float:right">
                                    <form id="deleteFileForm" name="deleteFileForm" action="confirmDelete.php" method="post">
                                    '.fileSizeUnits($sftp->size($file)).'<input type="image" src="images/trash.png" width="20">  
                                    <input type="hidden" name="remoteDir" id="remoteDir" value="'.$_SESSION['dir'].'">
                                    <input type="hidden" name="file" id="file" value="'.$file.'">
                                    </form>
                                    
                                    
                                    <form id="downloadFileForm" name="downloadFileForm" action="downloadFile.php" method="post">
                                    <input type="image" src="images/Download.png" width="20"><br>
                                    <input type="hidden" name="remoteDir" id="remoteDir" value="'.$_SESSION['dir'].'">
                                    <input type="hidden" name="localDir" id="localDir" value="/home/'.get_current_user().'/Downloads">
                                    <input type="hidden" name="file" id="file" value="'.$file.'">
                                    </form></span>';
                                    //echo 'onclick="downloadFile(\''.$_SESSION['dir'].'\',\'/home/'.get_current_user().'/Downloads/\',\''.$file.'\')"';
                                echo'<hr>';
                            }
                        }
                        
                        ?> 
                    </div>
                </div>
            </div>
        </div>
        </main>
        
        <footer class="page-footer red accent-4">
            <div class="footer-copyright">
                BerryBox 2016 - Christian Solecki | David Bussom | Briana Stroman | Paul Ruppenthal
            </div>
        </footer>
    </body>
</html>
