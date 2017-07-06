<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_developer.php");
appHeaders();
requiresDeveloperAuth();



$changeUsername_incorrectPassword = false;
$changeUsername_success = false;
if(isset($_POST['change_username']))
{
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        if(!changeDeveloperAuthUsername($_POST['password'], purgeString($_POST['username'])))
        {
            $changeUsername_incorrectPassword = true;
        }
        else
        {
            $changeUsername_success = true;
        }
    }
}

$changePassword_newPasswordsDontMatch = false;
$changePassword_incorrectPassword = false;
$changePassword_success = false;
if(isset($_POST['change_password']))
{
    if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['new_password_again']))
    {
        $old = $_POST['old_password'];
        $new = $_POST['new_password'];
        $new2 = $_POST['new_password_again'];
        if($new != $new2)
        {
            $changePassword_newPasswordsDontMatch = true;
        }
        else
        {
            if(!changeDeveloperAuthPassword($old, $new))
            {
                $changePassword_incorrectPassword = true;
            }
            else
            {
                $changePassword_success = true;
            }
        }
    }
}

$changeAccessToken_incorrectPassword = false;
if(isset($_POST['change_access_token']))
{
    if(isset($_POST['password']))
    {
        if(!refreshDeveloperAuthAccessToken($_POST['password']))
        {
            $changeAccessToken_incorrectPassword = true;
        }
        else
        {
            removePostData();
        }
    }
}

?>



<html>
    <body>
        <a href='.'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        <h1>Account</h1><br>
        
        
        
        <h2>Change Username</h2><br>
        
        <?php if($changeUsername_incorrectPassword) { ?>
            Incorrect password! Try again.<br><br>
        <?php } ?>
        
        <?php if($changeUsername_success) { ?>
            You username has been changed!<br><br>
        <?php } ?>
        
        <form action="?" method="post" autocomplete="off">
            <?php dontAutofillAccountFields(); ?>
            Username: <input type="text" name="username" value="<?php echo getDeveloperAuthUsername(); ?>" autocomplete="off"><br>
            Password: <input type="password" name="password" value="" autocomplete="off"><br>
            <input name="change_username" value="Change" type="submit" autocomplete="off">
        </form>
        
        
        
        <br>
        <br>
        
        
        
        <h2>Change Password</h2><br>
        
        <?php if($changePassword_newPasswordsDontMatch) { ?>
            New passwords don't match! Try again.<br><br>
        <?php } ?>
        
        <?php if($changePassword_incorrectPassword) { ?>
            Incorrect password! Try again.<br><br>
        <?php } ?>
        
        <?php if($changePassword_success) { ?>
            You password has been changed!<br><br>
        <?php } ?>
        
        <form action="?" method="post" autocomplete="off">
            <?php dontAutofillAccountFields(); ?>
            Old Password: <input type="password" name="old_password" value="" autocomplete="off"><br>
            New Password: <input type="password" name="new_password" value="" autocomplete="off"><br>
            New Password Again: <input type="password" name="new_password_again" value="" autocomplete="off"><br>
            <input name="change_password" value="Change" type="submit" autocomplete="off">
        </form>
        
        
        
        <br>
        <br>
        
        
        
        <h2>Access Token</h2><br>
        
        <?php if($changeAccessToken_incorrectPassword) { ?>
            Incorrect password! Try again.<br><br>
        <?php } ?>
        
        <form action="?" method="post" autocomplete="off">
            <?php dontAutofillAccountFields(); ?>
            ID: <?php echo getDeveloperAuthId(); ?><br>
            Access Token: <?php echo getDeveloperAuthAccessToken(); ?><br>
            <br>
            Warning! Regenerating the Access Token will invalidate the current one!<br>
            Password: <input type="password" name="password" value="" autocomplete="off"><br>
            <input name="change_access_token" value="Regenerate" type="submit" autocomplete="off">
        </form>
    </body>
</html>






