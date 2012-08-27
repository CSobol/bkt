<?php
define('__ROOT__',dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/lib/includes.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/css/bootstrap-responsive.min.css" />
    </head>
    <body>
        <nav class="navbar">
            <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <!--span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span-->
                  </a>
                  <a class="brand" href="/">Buckt</a>
                  <div class="nav-collapse span8">
                    <ul class="nav">
                      <li class="active"><a href="#">Home</a></li>
                      <li><a href="#about">About</a></li>
                      <li><a href="#contact">Contact</a></li>
                    </ul>
                  </div><!--/.nav-collapse -->
                  <form class="form-search span4 no-margin">
                    <input type="text" class="input-medium search-query">
                    <button type="submit" class="btn">Search</button>
                  </form>
                </div>
                
          </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="span12"><h1><?php
                if(userClass::checkIfUserIsLoggedIn()){
                    echo "logged in";
                }else{
                    echo "not logged in";
                }
                ?></h1></div>
            </div>
            <div class="row">
                <div class="span4">Span 4</div>
                <div class="span4 offset4">Span 4 offset 4.</div>
                <div class="span4 offset8">Span4</div>
            </div>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
