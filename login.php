<!doctype html>
<html>
    <body>
        <head>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css" rel="stylesheet"/>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
            <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
            <title>BerryBox</title>
            <link rel="shortcut icon" href="images/berrybox2.ico"/>
        </head>
        <main>
            <nav class="light-green darken-3">
                <div class="navbar-wrapper container">
                    <a href="#" class="brand-logo center"><img src="images/berrybox2.png" width="50" style="padding-top:5px">BerryBox</a>
                </div>
            </nav>
        
            <div class="container">
                <div class="row">
                    <div class="col s4 offset-s4 center">
                        <h1>Log In</h1>
                        <div class="card-panel center">
                            <form action="index.php" method="post">
                                Username:<br>
                                <input type="text" name="username" id="username"><br>
                                IP Address:<br>
                                <input type="text" name="ip" id="ip"><br>
                                Port Number:<br>
                                <input type="text" name="port" id="port"><br>
                                Password:<br>
                                <input type="password" name="pass" id="pass"><br>
                                <button class="btn waves-effect waves-light" type="submit" name="action">Log In
                                </button>
                            </form>
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
