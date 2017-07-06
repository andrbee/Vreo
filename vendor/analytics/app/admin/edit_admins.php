<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_admin.php");
appHeaders();
requiresAdminAuth();

if(!canAdminEditAdmins())
{
    redirectToAdminRoot();
}

if(isset($_POST['action_add']))
{
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        addAdmin(purgeString($_POST['username']), $_POST['password'], isset($_POST['can_edit_admins']), isset($_POST['can_edit_system']));
    }
}

if(isset($_POST['action_save']))
{
    if(isset($_POST['id']) && isset($_POST['username']))
    {
        changeAdmin($_POST['id'], purgeString($_POST['username']), isset($_POST['can_edit_admins']), isset($_POST['can_edit_system']));
    }
}

if(isset($_POST['action_delete']))
{
    if(isset($_POST['id']))
    {
        deleteAdmin($_POST['id']);
    }
}

removePostData();

?>



<html>
    <body>
        <a href='.'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        <h1>Edit Admins</h1><br>
        
        <h2>Add</h2><br>
        <form action="?" method="post" autocomplete="off">
            <?php dontAutofillAccountFields(); ?>
            Username: <input type="text" name="username" value="" autocomplete="off"><br>
            Password: &nbsp;<input type="password" name="password" value="" autocomplete="off"><br>
            Can Edit Admins: <input type="checkbox" name="can_edit_admins" value="1" autocomplete="off"><br>
            Can Edit System: &nbsp;<input type="checkbox" name="can_edit_system" value="1" autocomplete="off"><br>
            <input name="action_add" value="Add" type="submit" autocomplete="off">
        </form>
        <br>
        <br>
        
        <h2>Edit/Delete</h2><br>
        <?php $admins = getAdminsExceptSelf(); foreach($admins as $id => $admin) { ?>
            <form action="?" method="post" autocomplete="off">
                <?php dontAutofillAccountFields(); ?>
                ID: <?php echo $id; ?><br>
                Username: <input type="text" name="username" value="<?php echo $admin['username']; ?>" autocomplete="off"><br>
                Can Edit Admins: <input type="checkbox" name="can_edit_admins" value="1" <?php echo ($admin['can_edit_admins'] ? "checked" : ""); ?> autocomplete="off"><br>
                Can Edit System: &nbsp;<input type="checkbox" name="can_edit_system" value="1" <?php echo ($admin['can_edit_system'] ? "checked" : ""); ?> autocomplete="off"><br>
                <input type="hidden" name="id" value="<?php echo $id; ?>" autocomplete="off">
                <input name="action_save" value="Save" type="submit" autocomplete="off"> <input name="action_delete" value="Delete" type="submit" autocomplete="off">
            </form>
            <br>
        <?php } ?>
    </body>
</html>







