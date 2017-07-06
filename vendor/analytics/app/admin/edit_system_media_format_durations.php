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
    if(isset($_POST['duration_seconds_min']) && isset($_POST['duration_seconds_max']))
    {
        addMediaFormatDuration($_POST['duration_seconds_min'], $_POST['duration_seconds_max']);
    }
}

if(isset($_POST['action_save']))
{
    if(isset($_POST['id']) && isset($_POST['duration_seconds_min']) && isset($_POST['duration_seconds_max']))
    {
        changeMediaFormatDuration($_POST['id'], $_POST['duration_seconds_min'], $_POST['duration_seconds_max']);
    }
}

if(isset($_POST['action_delete']))
{
    if(isset($_POST['id']))
    {
        deleteMediaFormatDuration($_POST['id']);
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
        
        <h1>Edit Media Format Durations</h1><br>
        
        <h2>Add</h2><br>
        <form action="?" method="post" autocomplete="off">
            Minimum Duration (leave empty for no minimum): &nbsp;<input type="text" name="duration_seconds_min" value="" autocomplete="off"> seconds<br>
            Maximum Duration (leave empty for no maximum): <input type="text" name="duration_seconds_max" value="" autocomplete="off"> seconds<br>
            <input name="action_add" value="Add" type="submit" autocomplete="off">
        </form>
        <br>
        <br>
        
        <h2>Edit/Delete</h2><br>
        <?php $mediaFormatDurations = getMediaFormatDurations(); foreach($mediaFormatDurations as $id => $mediaFormatDuration) { ?>
            <form action="?" method="post" autocomplete="off">
                ID: <?php echo $id; ?><br>
                Minimum Duration (leave empty for no minimum): &nbsp;<input type="text" name="duration_seconds_min" value="<?php echo $mediaFormatDuration['duration_seconds_min']; ?>" autocomplete="off"> seconds<br>
                Maximum Duration (leave empty for no maximum): <input type="text" name="duration_seconds_max" value="<?php echo $mediaFormatDuration['duration_seconds_max']; ?>" autocomplete="off"> seconds<br>
                <input type="hidden" name="id" value="<?php echo $id; ?>" autocomplete="off">
                <input name="action_save" value="Save" type="submit" autocomplete="off"> <input name="action_delete" value="Delete" type="submit" autocomplete="off">
            </form>
            <br>
        <?php } ?>
    </body>
</html>







