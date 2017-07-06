<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_advertiser.php");
appHeaders();
requiresAdvertiserAuth();

if(isset($_POST['action_add']))
{
    if(isset($_POST['media_format_id']) && isset($_POST['country_filter_excludes']) && isset($_POST['country_filter_list']) && isset($_POST['media_url']))
    {
        addAdvertiserAdOfSelf($_POST['media_format_id'], $_POST['country_filter_excludes'], purgeString($_POST['media_url']), array_unique(splitAndPurgeString($_POST['country_filter_list'])));
    }
}

if(isset($_POST['action_save']))
{
    if(isset($_POST['id']) && isset($_POST['media_format_id']) && isset($_POST['country_filter_excludes']) && isset($_POST['country_filter_list']) && isset($_POST['media_url']))
    {
        if(isAdvertiserAdFromSelf($_POST['id']))
        {
            changeAdvertiserAd($_POST['id'], $_POST['media_format_id'], $_POST['country_filter_excludes'], purgeString($_POST['media_url']), array_unique(splitAndPurgeString($_POST['country_filter_list'])));
        }
    }
}

if(isset($_POST['action_delete']))
{
    if(isset($_POST['id']))
    {
        if(isAdvertiserAdFromSelf($_POST['id']))
        {
            deleteAdvertiserAd($_POST['id']);
        }
    }
}

removePostData();



$mediaFormats = getMediaFormats();
$mediaTypes = getMediaTypes();
$mediaFormatDurations = getMediaFormatDurations();
$mediaFormatsString = "";
foreach($mediaFormats as $id => $mediaFormat)
{
    $mediaFormatsString .= "<option value='".$id."'>".mediaFormatToString($mediaFormat, $mediaTypes, $mediaFormatDurations)."</option>";
}

$countryFilterExcludesString = "<option value='0'>Only:</option> <option value='1'>All Except:</option>";

$ads = getAdvertiserAdsOfSelf();

?>



<html>
    <head>
        <script>
            function setAdValues(formId, mediaFormatId, countryFilterExcludes, countryFilterList)
            {
                var form                            = document.getElementById(formId);
                var mediaFormatSelect               = form.elements["media_format_id"];
                var countryFilterExcludesSelect     = form.elements["country_filter_excludes"];
                var countryFilterListInput          = form.elements["country_filter_list"];
                
                mediaFormatSelect.value             = mediaFormatId;
                countryFilterExcludesSelect.value   = countryFilterExcludes;
                countryFilterListInput.value        = countryFilterList.join();
            }
        </script>
    </head>
    <body>
        <a href='.'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        <h1>Edit Ads</h1><br>
        
        <h2>Add</h2><br>
        <form id="form_add" action="?" method="post" autocomplete="off">
            <?php dontAutofillAccountFields(); ?>
            Media Format: <select name="media_format_id" autocomplete="off"><?php echo $mediaFormatsString ?></select><br>
            For Countries: <select name="country_filter_excludes" autocomplete="off"><?php echo $countryFilterExcludesString ?></select> <input type="text" name="country_filter_list" value="" size="200" autocomplete="off"> (example: EN,DE,FR)<br>
            Media URL: <input type="text" name="media_url" value="" size="200" autocomplete="off"><br>
            <input name="action_add" value="Add" type="submit" autocomplete="off">
        </form>
        <br>
        <br>
        
        <h2>Edit/Delete</h2><br>
        <?php foreach($ads as $id => $ad) { ?>
            <form id="form_edit_<?php echo $id; ?>" action="?" method="post" autocomplete="off">
                <?php dontAutofillAccountFields(); ?>
                ID: <?php echo $id; ?><br>
                Media Format: <select name="media_format_id" autocomplete="off"><?php echo $mediaFormatsString ?></select><br>
                For Countries: <select name="country_filter_excludes" autocomplete="off"><?php echo $countryFilterExcludesString ?></select> <input type="text" name="country_filter_list" value="" size="200" autocomplete="off"> (example: EN,DE,FR)<br>
                Media URL: <input type="text" name="media_url" value="<?php echo $ad['media_url']; ?>" size="200" autocomplete="off"><br>
                <input type="hidden" name="id" value="<?php echo $id; ?>" autocomplete="off">
                <input name="action_save" value="Save" type="submit" autocomplete="off"> <input name="action_delete" value="Delete" type="submit" autocomplete="off">
            </form>
            <br>
        <?php } ?>
        
        <script>
            setAdValues("form_add", "", "1", []);
            <?php foreach($ads as $id => $ad) { ?>
                var countryFilterList = [];
                <?php foreach($ad['country_filter_list'] as $country) { ?>
                    countryFilterList.push("<?php echo $country; ?>");
                <?php } ?>
                setAdValues("form_edit_<?php echo $id; ?>", "<?php echo $ad['type_media_format_id']; ?>", "<?php echo $ad['country_filter_excludes']; ?>", countryFilterList);
            <?php } ?>
        </script>
    </body>
</html>







