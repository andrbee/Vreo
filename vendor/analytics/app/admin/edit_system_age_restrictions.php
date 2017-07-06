<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_admin.php");
appHeaders();
requiresAdminAuth();

if(!canAdminEditSystem())
{
    redirectToAdminRoot();
}

if(isset($_POST['action_add']))
{
    if(isset($_POST['minimum_age']))
    {
        addAgeRestriction($_POST['minimum_age']);
    }
}

if(isset($_POST['action_save']))
{
    if(isset($_POST['id']) && isset($_POST['minimum_age']))
    {
        changeAgeRestriction($_POST['id'], $_POST['minimum_age']);
    }
}

if(isset($_POST['action_delete']))
{
    if(isset($_POST['id']))
    {
        deleteAgeRestriction($_POST['id']);
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
        
        <h1>Edit Age Restrictions</h1><br>
        
        <h2>Add</h2><br>
        <form action="?" method="post" autocomplete="off">
            Minimum Age: <input type="text" name="minimum_age" value="" autocomplete="off"><br>
            <input name="action_add" value="Add" type="submit" autocomplete="off">
        </form>
        <br>
        <br>
        
        <h2>Edit/Delete</h2><br>
        <?php $ageRestrictions = getAgeRestrictions(); foreach($ageRestrictions as $id => $ageRestriction) { ?>
            <form action="?" method="post" autocomplete="off">
                ID: <?php echo $id; ?><br>
                Minimum Age: <input type="text" name="minimum_age" value="<?php echo $ageRestriction['minimum_age']; ?>" autocomplete="off"><br>
                <input type="hidden" name="id" value="<?php echo $id; ?>" autocomplete="off">
                <input name="action_save" value="Save" type="submit" autocomplete="off"> <input name="action_delete" value="Delete" type="submit" autocomplete="off">
            </form>
            <br>
        <?php } ?>
    </body>
</html>







