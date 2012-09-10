<?php
define('__ROOT__',dirname(dirname(__FILE__)));
set_include_path(__ROOT__);
require_once('../lib/includes.php');

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
                    <a class="brand" href="/">Buckt <?php echo get_include_path();?></a>
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
                <!--begin content -->
                            <?php
                            //NO FORM SUMBIT
                            if(empty($_POST)){ ?>
                                <form id="register" method="post">
                                    <fieldset>
                                        <legend>
                                            Pick A User Name
                                        </legend>
                                    <label for="username">Username:</label>
                                    <input type="text" name="username" id="username">
                                </fieldset>
                                <fieldset>
                                    <legend>
                                        Pick A Password
                                    </legend>
                                    <label for="password">Password:</label>
                                    <input type="password" name="password">
                                    <label for="confirmPassword">Confirm Password:</label>
                                    <input type="password" name="confirmPassword">
                                </fieldset>
                                <fieldset>
                                    <legend>
                                        What's your e-mail address?
                                    </legend>
                                    <input type="text" name="email">
                                </fieldset>
                                <fieldset>
                                    <legend>
                                        Confirm Humanity
                                    </legend>
                                    <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?PHP ECHO __RECAPTCHA_KEY_PUBLIC__; ?> "></script>
                                        <noscript>
                                           <iframe src="http://www.google.com/recaptcha/api/noscript?k=<?PHP ECHO __RECAPTCHA_KEY_PUBLIC__; ?>" height="300" width="500" frameborder="0"></iframe><br>
                                             <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                                             </textarea>
                                             <input type="hidden" name="recaptcha_response_field"
                                                 value="manual_challenge">
                                          </noscript>   
                                    <input type="submit"/>
                                </fieldset>
                            </form>
                        <?php
                        }else{
                            //FORM SUBMIT
                                //PASSED CAPTCHA
                                //include("library/passwordchallenge.php");
                                $newUser = new userAccountActions($_POST['username'], $_POST['password'], $_POST['confirmPassword'], $_POST['email']);
                                
                                //$newUser->setUname($_POST['username'], $_POST['password'], $_POST['confirmPassword'], $_POST['email']);
                                if($newUser->errorStatus > 0){
                                    //FORM CONTAINS ERRORS

                                    echo "problem with form";
                                    echo $newUser->errorStatus;
                                }else{
                                    //FORM HAS NO ERRORS, REGISTRATION SUCCESSFUL
                                    $registrationDb = new dbFactory('write');
                                    $registrationDb->setQueryString(__REGISTRATION_QUERY__);
                                    //set parameters to associative array
                                    $queryParams = array(':userName' => $newUser->userName, ':password' => $newUser->password, ':salt'=>$newUser->salt, ':userEmail'=>$newUser->eMail);
                                    $registrationDb->query($queryParams);
                                    $msg = "Dear $newUser->userName \n\r
                                            \n\r
                                            Welcome to TweetFail.org!\n\r
                                            Your account requires confirmation. In order to confirm your account, you simply need to click on the link below:\n\r
                                            \n\r
                                            <a href='http://localhost/tweet/confirm.php?uConfirm=".strval($newUser->confirmId)."&uName=".strval($newUser->userName)."'>http://localhost/tweet/confirm.php?uConfirm=".$newUser->confirmId."&uName=".strval($newUser->userName)."</a>\n\r
                                            \n\r
                                            Thank you very much for joining us.";
                                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                    $headers .= 'From: TweetFail.org <noreply@tweetfail.org>' . "\r\n";
                                    mail($newUser->eMail, 'TweetFail.org registration. Welcome!', $msg, $headers);
                                    echo "Pass Hash: " . $newUser->password . " Salt: " . $newUser->salt;
                                    ?>
                                    <h1>Welcome to <a href="<?php echo __FQDN_NON_SSL__;?> "><?php echo __SITE_TITLE__; ?> </a>!</h1>
                                    <h2>Thank you for registering. An email has been sent to the address you provided.</h2>
                                    <p>Please click the link on the email, or copy and paste it into your browser's address bar to activate your account.</p>
                                    <p>If it doesn't show up right away, please check your spam folder. While you're waiting, feel free to <a href="//">keep surfing TweetFail.org</a>, or <a href="http://www.tweetfail.org/submit/">submit a fail</a>.</p>
                                    <?php
                                }
                                //
                            //captcha fail. reprint form with some variables
                            ?>
                                <!--form id="register" method="post">
                                    <fieldset>
                                        <legend>
                                            Pick A User Name
                                        </legend>
                                        <label for="username">Username:</label>
                                        <input type="text" name="username" id="username" value="<?php echo $_POST['username'] ?>">
                                    </fieldset>
                                    <fieldset>
                                        <legend>
                                            Pick A Password
                                        </legend>
                                        <label for="password">Password:</label>
                                        <input type="password" name="password">
                                        <label for="confirmPassword">Confirm Password:</label>
                                        <input type="password" name="confirmPassword">
                                    </fieldset>
                                    <fieldset>
                                        <legend>
                                            What's your e-mail address?
                                        </legend>
                                        <input type="text" name="email" value="<?php echo $_POST['email'] ?>">
                                    </fieldset>
                                    <fieldset>
                                        <legend>
                                            Confirm Humanity
                                        </legend>
                                        <img src="library/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>"><br />
                                        <input type="text" name="code" /><input type="submit"/>
                                    </fieldset>
                                </form--!>
                            <?php
                        };
                        ?>
                        <!--end content-->
            </div>
            <div class="row">
                <div class="span4">Span 4</div>
                <div class="span4 offset4">Span 4 offset 4.</div>
                <div class="span4 offset8">Span4</div>
            </div>
        </div>