<?php
    // load language file ($language is defined in "base.php").
    $login_main_strings_html = file_get_contents($directory . $language. "/" . "login_main_strings.php");
    
    eval(" ?> " . $login_main_strings_html . " <?php ");
?>

<?php

    include($directory . "dbcrypt.php");
    include($directory . "dbuser.php");

    function cleanCharacterString ($str) {
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        $connection = Database::getInstance();
        return $connection -> real_escape_string($str);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (ISSET($_POST['register'])) {                    
            $connection = Database::getInstance();
            
            // Field values sent from Form Tag 
            $email = cleanCharacterString($_POST['email']);
            // Validate 
            $confirmemail = cleanCharacterString($_POST['confirmemail']);
                        
            if ($email != $confirmemail) {
                // Emails are not the same..
                session_write_close();
                exit();
            }
            
            $username = "";
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $maxid = 0;
                foreach ($dbuser -> getMaxId() as $tuple) {
                    $maxid = $tuple['MAX(user_id)'];
                }
                $username = 'user' . ($maxid + 1);
            } else {
                // email for now can be NULL
                session_write_close();
                exit();
            }
            
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];
            
            if ($password != $confirmpassword) {
                // Passwords are not the same..
                session_write_close();
                exit();
            }
            
            // Crypt passwords..
            $password = encryptToHashWithSaltAndBlowfish(cleanCharacterString($_POST['password']));
            $confirmpassword = encryptToHashWithSaltAndBlowfish(cleanCharacterString($_POST['confirmpassword']));
            
            if ($dbuser -> existEmail($email)) {
                session_write_close();
                exit();
            } else {
                $dbuser -> write($username, $email, $password);
            }   //    date('Y-m-d', strtotime(str_replace('-', '/', date('Y-m-d'))))
            
            // $connection -> close();
        } else if (ISSET($_POST['login'])) {
            $connection = Database::getInstance();
            // FIXME: not firstname, but nickname..
            $nickname = cleanCharacterString($_POST['nickname']);
            foreach ($dbuser -> existUser($nickname) as $tuple) { // only one result..
                $isValid = verifyCryptation(cleanCharacterString($_POST['password']), $tuple['password']);
                if ($isValid) {
                    
                    // log user..
                    session_regenerate_id();
                    $_SESSION['s_user_id'] = $tuple['user_id'];
                    $_SESSION['s_username'] = $tuple['username'];
                    session_write_close();
                    
                    // save last login date
                    $now = date('Y/m/d H');
                    $dbuser -> updateLastSeen($now, $_SESSION['s_user_id']);
                    
                    if (ISSET($_POST['rememberme'])) {
                        $_SESSION['s_rememberme'] = true;
                        echo setcookies(60);
                    } else {
                        $_SESSION['s_rememberme'] = false;
                    }
                    if(ISSET($_SESSION["s_user_id"])) {
                        header("Location: " . $directory . "dashboard.php");
                    }
                } else {
                    // Invalid credentials
                }
                break; // useless, but..
            }
        }
    }     
?>

<div id="registrate">
    <form action="#" method="post" class="regform">
        <h1><span class="log-in">Log in</span> or <span class="sign-up">sign up</span></h1>
        <p class="float">
           <input type="text" name="email" id="email" placeholder="Email.." required>
           <img src="<?php print($directory); ?>/gcr/images/logreg/user.svg">
        </p>
        <p class="float">
           <input type="text" name="confirmemail" id="confirmemail" placeholder="<?php print($lang_confirm_email); ?>" required>
           <img src="<?php print($directory); ?>/gcr/images/logreg/dots.svg">
        </p>
    
        <p class="float">
           <input type="password" name="password" id="regpassword" placeholder="Password.." required><br/>
           <img src="<?php print($directory); ?>/gcr/images/logreg/lock.svg">
        </p>
        <p class="float">
           <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password.." required><br/>
           <img src="<?php print($directory); ?>/gcr/images/logreg/dots.svg">
        </p>
        <p class="submit">
            <div class="button">
                <input type="submit" name="register" id="register" value="Signup">
            </div>
        </p>
        <h1></h1>
        <p class="change_link"> Are you just a member?&nbsp;
            <a href="" class="to_login">Login</a>
        </p>
    </form>
    <form action="#" method="post" class="loginform">
        <h1><span class="log-in">Log in</span> or <span class="sign-up">sign up</span></h1>
        <p class="float">
           <input type="text" name="nickname" id="useremail" placeholder="Username or Email.." required>
           <img src="<?php print($directory); ?>/gcr/images/logreg/user.svg">
           <!-- <i class="icon-user icon-large"></i> -->
        </p>
        <p class="float">
           <input type="password" name="password" id="logpassword" placeholder="Password.." required>
           <img src="<?php print($directory); ?>/gcr/images/logreg/lock.svg">
           <!-- <i class="icon-lock icon-large"></i> -->
        </p>
        <p>
            <div class="remember">
                <input type="checkbox" name="rememberme" id="remember">
                <label for="remember"></label>
            </div>
            <label for="remember" class="remembermelabel">Remember Me</label>
        </p> 
        <p class="submit">
            <div class="button">
                <input type="submit" name="login" id="login" value="Login">
            </div>
        </p>
        <h1></h1>
        <p class="change_link"> Not a member yet?&nbsp;
            <a href="" class="to_register">Join us</a>
        </p>
        </form> 
 </div>

<script type="text/javascript" src="<?php print($directory); ?>/gcr/js/logreg_handler.js"></script>
