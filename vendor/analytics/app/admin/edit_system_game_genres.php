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
    if(isset($_POST['name']))
    {
        addGameGenre(purgeString($_POST['name']));
    }
}

if(isset($_POST['action_save']))
{
    if(isset($_POST['id']) && isset($_POST['name']))
    {
        changeGameGenre($_POST['id'], purgeString($_POST['name']));
    }
}

if(isset($_POST['action_delete']))
{
    if(isset($_POST['id']))
    {
        deleteGameGenre($_POST['id']);
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
        
        <h1>Edit Game Genres</h1><br>
        
        <h2>Add</h2><br>
        <form action="?" method="post" autocomplete="off">
            Genre: <input type="text" name="name" value="" autocomplete="off"><br>
            <input name="action_add" value="Add" type="submit" autocomplete="off">
        </form>
        <br>
        <br>
        
        <h2>Edit/Delete</h2><br>
        <?php $genres = getGameGenres(); foreach($genres as $id => $genre) { ?>
            <form action="?" method="post" autocomplete="off">
                ID: <?php echo $id; ?><br>
                Genre: <input type="text" name="name" value="<?php echo $genre['name']; ?>" autocomplete="off"><br>
                <input type="hidden" name="id" value="<?php echo $id; ?>" autocomplete="off">
                <input name="action_save" value="Save" type="submit" autocomplete="off"> <input name="action_delete" value="Delete" type="submit" autocomplete="off">
            </form>
            <br>
        <?php } ?>
    </body>
</html>







