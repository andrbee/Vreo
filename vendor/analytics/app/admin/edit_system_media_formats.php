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
    if(isset($_POST['type_media_id']) && isset($_POST['type_media_format_duration_id']) && isset($_POST['aspect_ratio']))
    {
        addMediaFormat($_POST['type_media_id'], $_POST['type_media_format_duration_id'], $_POST['aspect_ratio']);
    }
}

if(isset($_POST['action_save']))
{
    if(isset($_POST['id']) && isset($_POST['type_media_id']) && isset($_POST['type_media_format_duration_id']) && isset($_POST['aspect_ratio']))
    {
        changeMediaFormat($_POST['id'], $_POST['type_media_id'], $_POST['type_media_format_duration_id'], $_POST['aspect_ratio']);
    }
}

if(isset($_POST['action_delete']))
{
    if(isset($_POST['id']))
    {
        deleteMediaFormat($_POST['id']);
    }
}

removePostData();



$mediaTypesString = "";
$mediaTypes = getMediaTypes();
foreach($mediaTypes as $id => $mediaType)
{
    $mediaTypesString .= "<option value='".$id."'>".$mediaType['name']."</option>";
}

$mediaFormatDurationsString = "<option value='0'>All</option>";
$mediaFormatDurations = getMediaFormatDurations();
foreach($mediaFormatDurations as $id => $mediaFormatDuration)
{
    $mediaFormatDurationString = mediaFormatDurationToString($mediaFormatDuration);
    if(empty($mediaFormatDurationString))
    {
        continue;
    }
    $mediaFormatDurationsString .= "<option value='".$id."'>".$mediaFormatDurationString."</option>";
}

$mediaFormats = getMediaFormats();

?>



<html>
    <head>
        <?php includeJavascriptFunctionsGeneralScript(); ?>
        <script>
            function mediaTypeComboboxOnChange(combobox, formId)
            {
                var mediaTypeId             = combobox.selectedIndex + 1;
                var form                    = document.getElementById(formId);
                var mediaFormatDurationSpan = form.getElementsByClassName("media_format_duration")[0];
                var aspectRatioSpan         = form.getElementsByClassName("aspect_ratio")[0];
                
                if(mediaTypeId == 1) // image
                {
                    addElementClass(mediaFormatDurationSpan, "hidden");
                    removeElementClass(aspectRatioSpan, "hidden");
                }
                else if(mediaTypeId == 2) // video
                {
                    removeElementClass(mediaFormatDurationSpan, "hidden");
                    removeElementClass(aspectRatioSpan, "hidden");
                }
                else if(mediaTypeId == 3) // sound
                {
                    removeElementClass(mediaFormatDurationSpan, "hidden");
                    addElementClass(aspectRatioSpan, "hidden");
                }
                else // fallback
                {
                    removeElementClass(mediaFormatDurationSpan, "hidden");
                    removeElementClass(aspectRatioSpan, "hidden");
                }
            }
            function setMediaFormatValues(formId, mediaTypeId, mediaFormatDurationId)
            {
                var form                        = document.getElementById(formId);
                var mediaFormatDurationSpan     = form.getElementsByClassName("media_format_duration")[0];
                var aspectRatioSpan             = form.getElementsByClassName("aspect_ratio")[0];
                var mediaTypeSelect             = form.elements["type_media_id"];
                var mediaFormatDurationSelect   = form.elements["type_media_format_duration_id"];
                
                mediaTypeSelect.value           = mediaTypeId;
                mediaFormatDurationSelect.value = mediaFormatDurationId;
                
                if(mediaTypeId == 1) // image
                {
                    addElementClass(mediaFormatDurationSpan, "hidden");
                    removeElementClass(aspectRatioSpan, "hidden");
                }
                else if(mediaTypeId == 2) // video
                {
                    removeElementClass(mediaFormatDurationSpan, "hidden");
                    removeElementClass(aspectRatioSpan, "hidden");
                }
                else if(mediaTypeId == 3) // sound
                {
                    removeElementClass(mediaFormatDurationSpan, "hidden");
                    addElementClass(aspectRatioSpan, "hidden");
                }
                else // fallback
                {
                    removeElementClass(mediaFormatDurationSpan, "hidden");
                    removeElementClass(aspectRatioSpan, "hidden");
                }
            }
        </script>
        <style>
            .hidden
            {
                display: none;
            }
        </style>
    </head>
    <body>
        <a href='.'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        <h1>Edit Media Formats</h1><br>
        
        <h2>Add</h2><br>
        <form id="form_add" action="?" method="post" autocomplete="off">
            Media Type: <select name="type_media_id" onChange="mediaTypeComboboxOnChange(this, 'form_add')" autocomplete="off"><?php echo $mediaTypesString ?></select><br>
            <span class="media_format_duration">Media Format Duration: <select name="type_media_format_duration_id" autocomplete="off"><?php echo $mediaFormatDurationsString ?></select> seconds<br></span>
            <span class="aspect_ratio">Aspect Ratio: <input type="text" name="aspect_ratio" value="" autocomplete="off"> width per 1.0 height<br></span>
            <input name="action_add" value="Add" type="submit" autocomplete="off">
        </form>
        <br>
        <br>
        
        <h2>Edit/Delete</h2><br>
        <?php foreach($mediaFormats as $id => $mediaFormat) { ?>
            <form id="form_edit_<?php echo $id; ?>" action="?" method="post" autocomplete="off">
                ID: <?php echo $id; ?><br>
                Media Type: <select name="type_media_id" onChange="mediaTypeComboboxOnChange(this, 'form_edit_<?php echo $id; ?>')" autocomplete="off"><?php echo $mediaTypesString ?></select><br>
                <span class="media_format_duration">Media Format Duration: <select name="type_media_format_duration_id" autocomplete="off"><?php echo $mediaFormatDurationsString ?></select> seconds<br></span>
                <span class="aspect_ratio">Aspect Ratio: <input type="text" name="aspect_ratio" value="<?php echo $mediaFormat['aspect_ratio']; ?>" autocomplete="off"> width per 1.0 height<br></span>
                <input type="hidden" name="id" value="<?php echo $id; ?>" autocomplete="off">
                <input name="action_save" value="Save" type="submit" autocomplete="off"> <input name="action_delete" value="Delete" type="submit" autocomplete="off">
            </form>
            <br>
        <?php } ?>
        
        <script>
            setMediaFormatValues("form_add", "1", "0");
            <?php foreach($mediaFormats as $id => $mediaFormat) { ?>
                setMediaFormatValues("form_edit_<?php echo $id; ?>", "<?php echo $mediaFormat['type_media_id']; ?>", "<?php echo (empty($mediaFormat['type_media_format_duration_id']) ? 0 : $mediaFormat['type_media_format_duration_id']); ?>");
            <?php } ?>
        </script>
    </body>
</html>







