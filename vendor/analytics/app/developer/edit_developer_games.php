<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_developer.php");
appHeaders();
requiresDeveloperAuth();

if(isset($_POST['action_add']))
{
    if(isset($_POST['name']) && isset($_POST['age_restriction_id']))
    {
        addDeveloperGameOfSelf(purgeString($_POST['name']), $_POST['age_restriction_id'], isset($_POST['available']), isset($_POST['developer_mode']), $_POST['genre_ids']);
    }
}

if(isset($_POST['action_save']))
{
    if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['age_restriction_id']))
    {
        if(isDeveloperGameFromSelf($_POST['id']))
        {
            changeDeveloperGame($_POST['id'], purgeString($_POST['name']), $_POST['age_restriction_id'], isset($_POST['available']), isset($_POST['developer_mode']), $_POST['genre_ids']);
        }
    }
}

if(isset($_POST['action_delete']))
{
    if(isset($_POST['id']))
    {
        if(isDeveloperGameFromSelf($_POST['id']))
        {
            deleteDeveloperGame($_POST['id']);
        }
    }
}

removePostData();



$gameGenres = getGameGenres();
$gameGenresString = "";
foreach($gameGenres as $id => $gameGenre)
{
    $gameGenresString .= "<option value='".$id."'>".$gameGenre['name']."</option>";
}

$ageRestrictions = getAgeRestrictions();
$ageRestrictionsMinimumValueId = 0;
$ageRestrictionsMinimumValueAge = 999999;
$ageRestrictionsString = "";
foreach($ageRestrictions as $id => $ageRestriction)
{
    $minimumAge = $ageRestriction['minimum_age'];
    if($minimumAge < $ageRestrictionsMinimumValueAge)
    {
        $ageRestrictionsMinimumValueId = $id;
        $ageRestrictionsMinimumValueAge = $minimumAge;
    }
    $ageRestrictionsString .= "<option value='".$id."'>".$minimumAge."</option>";
}

$games = getDeveloperGamesOfSelf();

?>



<html>
    <head>
        <?php includeJavascriptFunctionsGeneralScript(); ?>
        <script>
            function setGameValues(formId, gameGenreSelectIds, ageRestrictionId)
            {
                var form                    = document.getElementById(formId);
                var genresSelect            = form.elements["genre_ids[]"];
                var ageRestrictionSelect    = form.elements["age_restriction_id"];
                
                setMultiSelectSelection(genresSelect, gameGenreSelectIds);
                ageRestrictionSelect.value = ageRestrictionId;
            }
        </script>
    </head>
    <body>
        <a href='.'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        <h1>Edit Games</h1><br>
        
        <h2>Add</h2><br>
        <form id="form_add" action="?" method="post" autocomplete="off">
            <?php dontAutofillAccountFields(); ?>
            Name: <input type="text" name="name" value="" autocomplete="off"><br>
            Genres: (ctrl+click for multiple)<br>
            <select name="genre_ids[]" multiple="multiple" size="5" autocomplete="off"><?php echo $gameGenresString; ?></select><br>
            Minimum Age: <select name="age_restriction_id" autocomplete="off"><?php echo $ageRestrictionsString ?></select> years<br>
            Available: (show up for advertisers?) <input type="checkbox" name="available" value="1" autocomplete="off"><br>
            Developer Mode: (don't accept currency and keep track of statistics yet?) <input type="checkbox" name="developer_mode" value="1" checked autocomplete="off"><br>
            <input name="action_add" value="Add" type="submit" autocomplete="off">
        </form>
        <br>
        <br>
        
        <h2>Edit/Delete</h2><br>
        <?php foreach($games as $id => $game) { ?>
            <form id="form_edit_<?php echo $id; ?>" action="?" method="post" autocomplete="off">
                <?php dontAutofillAccountFields(); ?>
                ID: <?php echo $id; ?><br>
                Name: <input type="text" name="name" value="<?php echo $game['name']; ?>" autocomplete="off"><br>
                Genres: (ctrl+click for multiple)<br>
                <select name="genre_ids[]" multiple="multiple" size="5" autocomplete="off"><?php echo $gameGenresString; ?></select><br>
                Minimum Age: <select name="age_restriction_id" autocomplete="off"><?php echo $ageRestrictionsString ?></select> years<br>
                Available: (show up for advertisers?) <input type="checkbox" name="available" value="1" <?php echo ($game['available'] ? "checked" : ""); ?> autocomplete="off"><br>
                Developer Mode: (don't accept currency and keep track of statistics yet?) <input type="checkbox" name="developer_mode" value="1" <?php echo ($game['developer_mode'] ? "checked" : ""); ?> autocomplete="off"><br>
                <input type="hidden" name="id" value="<?php echo $id; ?>" autocomplete="off">
                <input name="action_save" value="Save" type="submit" autocomplete="off"> <input name="action_delete" value="Delete" type="submit" autocomplete="off">
            </form>
            <br>
        <?php } ?>
        
        <script>
            setGameValues("form_add", [], "<?php echo $ageRestrictionsMinimumValueId; ?>");
            <?php foreach($games as $id => $game) { ?>
                var selectedIds = [];
                <?php foreach($game['genre_ids'] as $genreId) { ?>
                    selectedIds.push("<?php echo $genreId; ?>");
                <?php } ?>
                setGameValues("form_edit_<?php echo $id; ?>", selectedIds, "<?php echo $game['type_age_restriction_id']; ?>");
            <?php } ?>
        </script>
    </body>
</html>







