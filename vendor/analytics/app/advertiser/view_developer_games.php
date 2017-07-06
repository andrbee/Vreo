<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_advertiser.php");
appHeaders();
requiresAdvertiserAuth();

if(isset($_POST['action_ads_save']))
{
    if(isset($_POST['id']))
    {
        changeAdvertiserAdDeveloperGamesOfSelf($_POST['id'], $_POST['ad_ids']);
    }
}

removePostData();



$genres = getGameGenres();
$ageRestrictionIds = getAgeRestrictions();

$developerGamesStatistics = getDeveloperGamesStatisticsForAdvertisers();



$mediaFormats = getMediaFormats();
$mediaTypes = getMediaTypes();
$mediaFormatDurations = getMediaFormatDurations();

$ads = getAdvertiserAdsOfSelf();
$adsString = "";
foreach($ads as $id => $ad)
{
    $mediaFormatString = mediaFormatToString($mediaFormats[$ad['type_media_format_id']], $mediaTypes, $mediaFormatDurations);
    $mediaUrl = $ad['media_url'];
    $countryFilterString = ($ad['country_filter_excludes'] ? "All Except " : "Only ");
    $countryFilterString .= ((count($ad['country_filter_list']) > 0) ? join(",", $ad['country_filter_list']) : "-none-");
    
    $delim  = "&nbsp;&nbsp;|&nbsp;&nbsp;";
    $prefix = "&nbsp;&nbsp;";
    $suffix = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $text   = $prefix.$id.$delim.$mediaFormatString.$delim."\"".$mediaUrl."\"".$delim."Countries: ".$countryFilterString.$suffix;
    
    $adsString .= "<option value='".$id."'>".$text."</option>";
}

?>



<html>
    <head>
        <?php includeJavascriptFunctionsGeneralScript(); ?>
        <script>
            function setGameAdsValues(formId, adSelectIds)
            {
                var form                    = document.getElementById(formId);
                var adsSelect            = form.elements["ad_ids[]"];
                
                setMultiSelectSelection(adsSelect, adSelectIds);
            }
        </script>
    </head>
    <body>
        <a href='.'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        
        
        <h1>Games</h1><br>
        
        
        
        <?php foreach($developerGamesStatistics as $id => $stats) { ?>
            Game ID: <?php echo $stats['developer_game_id']; ?><br>
            Game Developer ID: <?php echo $stats['developer_id']; ?><br>
            Game Name: <?php echo $stats['name']; ?><br>
            Game Genres: <?php echo join(", ", replaceGameGenreIds($stats['genre_ids'], $genres)); ?><br>
            Game Minimum Age: <?php echo $ageRestrictionIds[$stats['type_age_restriction_id']]['minimum_age'] ?> years<br>
            
            <?php if(!empty($stats['unique_hits'])) { ?>
                <br>
                
                Unique Hits: <?php echo $stats['unique_hits']; ?><br>
                Total Hits: <?php echo $stats['total_hits']; ?><br>
                Total Time: <?php echo $stats['total_hit_time']; ?> seconds<br>
                Total Score Earned: <?php echo $stats['total_score']; ?><br>
                
                <br>
                
                <?php $totalHits = $stats['total_hits']; if($totalHits > 0){ ?>
                    Time Per Unique Hit: <?php echo ($stats['total_hit_time'] / $totalHits) ?> seconds<br>
                <?php } ?>
                
                <?php $totalScore = $stats['total_score']; if($totalScore > 0){ ?>
                    Time Per Score Earned: <?php echo ($stats['total_hit_time'] / $totalScore) ?> seconds<br>
                <?php } ?>
                
                <br>
                
                <?php $totalViewTime = $stats['total_view_time']; if($totalViewTime > 0){ ?>
                    Average Screen Percentage: <?php echo ($stats['total_screen_percentage'] / $totalViewTime); ?>%<br>
                    Average Screen Position: x=<?php echo ($stats['total_screen_position_x'] / $totalViewTime); ?>% | y=<?php echo ($stats['total_screen_position_y'] / $totalViewTime); ?>%<br>
                    Average Blocked Percentage:  <?php echo ($stats['total_blocked_percentage'] / $totalViewTime); ?>%<br>
                <?php } ?>
                
                <br>
                
                <?php $totalHearTime = $stats['total_hear_time']; if($totalHearTime > 0){ ?>
                    Average Volume Percentage: <?php echo ($stats['total_volume_percent'] / $totalHearTime) ?>%<br>
                <?php } ?>
            <?php } ?>
            
            <br>
            <form id="form_ads_<?php echo $id; ?>" action="?" method="post" autocomplete="off">
                <?php dontAutofillAccountFields(); ?>
                Bind Ads: (ctrl+click for multiple)<br>
                <select name="ad_ids[]" multiple="multiple" size="10" autocomplete="off"><?php echo $adsString; ?></select><br>
                <input type="hidden" name="id" value="<?php echo $id; ?>" autocomplete="off">
                <input name="action_ads_save" value="Save" type="submit" autocomplete="off">
            </form>
            
            <br>
            <br>
            <br>
        <?php } ?>
        
        <script>
            <?php foreach($developerGamesStatistics as $id => $stats) { ?>
                var selectedIds = [];
                <?php foreach($stats['ad_ids'] as $adId) { ?>
                    selectedIds.push("<?php echo $adId; ?>");
                <?php } ?>
                setGameAdsValues("form_ads_<?php echo $id; ?>", selectedIds);
            <?php } ?>
        </script>
    </body>
</html>





