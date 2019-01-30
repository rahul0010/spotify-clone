<?php
    include("includes/classes/Account.php");

    $account = new Account();

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Spotify</title>
</head>
<body>
    <div id="inputContainer">
        <form action="register.php" id="loginForm" method="post">
            <h2>Login to your account</h2>
            <div>
                <label for="loginUsername">Username</label>
                <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. Rahul0010" required>
            </div>
            <div>
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="loginPassword" placeholder="Your Password" required >
            </div>
            <button type="submit" name="loginButton">Login</button>
        </form>

        <form action="register.php" id="registerForm" method="post">
            <h2>Create your free account</h2>
            <div>
                <?php
                    echo $account->getError('Your username must be between 5 and 25 characters');
                ?>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="e.g. Rahul0010" required>
            </div>
            <div>
                <?php
                    echo $account->getError('Your first name must be between 2 and 25 characters');
                ?>
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="e.g. Rahul" required>
            </div>
            <div>
                <?php
                    echo $account->getError('Your last name must be between 5 and 25 characters');
                ?>
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="e.g. Bharati" required>
            </div>
            <div>
                <?php
                    echo $account->getError('Your emails don\'t match');
                ?>
                <?php
                    echo $account->getError('Email is invalid');
                ?>
                <?php
                    // echo $account->getError('Your emails don\'t match');
                ?>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="e.g. rahul@gmail.com" required>
            </div>
            <div>
                <label for="email2">Confirm Email</label>
                <input type="email" id="email2" name="email2" placeholder="e.g. Rahul@gmail.com" required>
            </div>
            <div>
                <?php
                    echo $account->getError('Your passwords don\'t match');
                ?>
                <?php
                    echo $account->getError('Your passwords can only contain numbers and letters');
                ?>
                <?php
                    echo $account->getError('Your password must be between 5 and 30 characters');
                ?>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Your Password" required>
            </div>
            <div>
                <label for="password">Confirm Password</label>
                <input type="password" id="password2" name="password2" placeholder="Your Password" required>
            </div>
            <button type="submit" name="registerButton">Sign up</button>
        </form>
    </div>
</body>
</html>