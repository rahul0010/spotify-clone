<?php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($con);

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getInputvalue($name)
    {
        if(isset($_POST[$name]))
        {
            echo $_POST[$name];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Spotify</title>
    <link rel="stylesheet" href="./assets/css/register.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
    <?php
        if(isset($_POST["registerButton"]))
        {
            echo '<script>
                $(document).ready(function(){
                    $("#loginForm").hide();
                    $("#registerForm").show();
                });
            </script>';
        }
        else
        {
            echo '<script>
                $(document).ready(function(){
                    $("#registerForm").hide();
                    $("#loginForm").show();
                });
            </script>';
        }
        
    ?>
    <div id="background">
        <div id="loginContainer">
            <div id="inputContainer">
                <form action="register.php" id="loginForm" method="post">
                    <h2>Login to your account</h2>
                    <div>
                        <?php
                            echo $account->getError(Constants::$loginFailed);
                        ?>
                        <label for="loginUsername">Username</label>
                        <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. Rahul0010" value="<?php getInputvalue('loginUsername'); ?>" required>
                    </div>
                    <div>
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="loginPassword" placeholder="Your Password" required >
                    </div>
                    <button type="submit" name="loginButton">Log in</button>
                    <div class="hasAccountText">
                        <span id="hideLogin">Don't have an account yet? Signup here</span>
                    </div>
                </form>

                <form action="register.php" id="registerForm" method="post">
                    <h2>Create your free account</h2>
                    <div>
                        <?php
                            echo $account->getError(Constants::$usernameCharacters);
                        ?>
                        <?php
                            echo $account->getError(Constants::$usernameTaken);
                        ?>
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="e.g. Rahul0010" value="<?php getInputvalue('username'); ?>" required>
                    </div>
                    <div>
                        <?php
                            echo $account->getError(Constants::$firstNameCharacters);
                        ?>
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="e.g. Rahul" value="<?php getInputvalue('firstName'); ?>" required>
                    </div>
                    <div>
                        <?php
                            echo $account->getError(Constants::$lastNameCharacters);
                        ?>
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="e.g. Bharati" value="<?php getInputvalue('lastName'); ?>" required>
                    </div>
                    <div>
                        <?php
                            echo $account->getError(Constants::$emailsDoNotMatch);
                        ?>
                        <?php
                            echo $account->getError(Constants::$emailInvalid);
                        ?>
                        <?php
                            echo $account->getError(Constants::$emailTaken);
                        ?>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="e.g. rahul@gmail.com" value="<?php getInputvalue('email'); ?>" required>
                    </div>
                    <div>
                        <label for="email2">Confirm Email</label>
                        <input type="email" id="email2" name="email2" placeholder="e.g. Rahul@gmail.com" value="<?php getInputvalue('email2'); ?>" required>
                    </div>
                    <div>
                        <?php
                            echo $account->getError(Constants::$passwordsDoNotMatch);
                        ?>
                        <?php
                            echo $account->getError(Constants::$passwordsAlphaNumeric);
                        ?>
                        <?php
                            echo $account->getError(Constants::$passwordCharacters);
                        ?>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Your Password" required>
                    </div>
                    <div>
                        <label for="password">Confirm Password</label>
                        <input type="password" id="password2" name="password2" placeholder="Your Password" required>
                    </div>
                    <button type="submit" name="registerButton">Sign up</button>
                    <div class="hasAccountText">
                        <span id="hideRegister">Already have an account? Login here</span>
                    </div>
                </form>
            </div>
            <div id="loginText">
                <h1>Get great music, right now</h1>
                <h2>Listen to loads of songs for free</h2>
                <ul>
                    <li>Discover music you fall in love with</li>
                    <li>Create your own playlists</li>
                    <li>Follow artists to keep up to date</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>