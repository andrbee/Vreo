<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_developer.php");
appHeaders();
redirectIfDeveloperAuth();



$login_invalidRecaptchaResponse = false;
$login_incorrectLoginData = false;
if(isset($_POST['action_login']))
{
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        if(!validateRecaptchaResponse($_POST))
        {
            $login_invalidRecaptchaResponse = true;
        }
        else
        {
            tryDeveloperAuth(purgeString($_POST['username']), $_POST['password']);
            
            // if it didn't redirect, it failed
            $login_incorrectLoginData = true;
        }
    }
}

$register_invalidRecaptchaResponse = false;
if(isset($_POST['action_register']))
{
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        if(!validateRecaptchaResponse($_POST))
        {
            $register_invalidRecaptchaResponse = true;
        }
        else
        {
            registerDeveloperAuth(purgeString($_POST['username']), $_POST['password']);
        }
    }
}

?>



<html>
    <head>
        <?php echo(getRecaptchaScript()); ?>
    </head>

    <body>
        <a href='../'>Back</a><br>
        <br>
        <br>
        <br>
        
        
        
        <h1>Developer Panel</h1><br>
        
        
        
        <h2>Login</h2>
        
        <?php if($login_invalidRecaptchaResponse) { ?>
            Invalid Recaptcha! Try again.<br><br>
        <?php } ?>
        
        <?php if($login_incorrectLoginData) { ?>
            Wrong login data! Try again.<br><br>
        <?php } ?>
        
        <form action="?" method="post" autocomplete="off">
            <?php //dontAutofillAccountFields(); ?>
            Username: <input type="text" name="username" value="" autocomplete="off"><br>
            Password: &nbsp;<input type="password" name="password" value="" autocomplete="off"><br>
            <br>
            <?php echo(getRecaptchaWidget()); ?><br>
            <input name="action_login" value="Log In" type="submit" autocomplete="off">
        </form>
        
        
        
        <br>
        <br>
        
        
        
        <h2>Register</h2>
        
        <?php if($register_invalidRecaptchaResponse) { ?>
            Invalid Recaptcha! Try again.<br><br>
        <?php } ?>
        
        <form action="?" method="post" autocomplete="off">
            <?php dontAutofillAccountFields(); ?>
            Username: <input type="text" name="username" value="" autocomplete="off"><br>
            Password: &nbsp;<input type="password" name="password" value="" autocomplete="off"><br>
            <br>
            <?php echo(getRecaptchaWidget()); ?><br>
            <input name="action_register" value="Register" type="submit" autocomplete="off">
        </form>
    </body>
</html>






