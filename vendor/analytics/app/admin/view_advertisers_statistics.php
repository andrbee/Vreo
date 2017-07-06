<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_admin.php");
appHeaders();
requiresAdminAuth();



$mediaFormats = getMediaFormats();
$mediaTypes = getMediaTypes();
$mediaFormatDurations = getMediaFormatDurations();

$advertisersStatistics = getAdvertisersStatisticsForAdmins();

?>



<html>
    <body>
        <a href='.'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        
        
        <h1>Advertiser Statistics</h1><br>
        
        
        
        <h2>Summary</h2><br>
        <?php foreach($advertisersStatistics as $id => $stats) { ?>
            Advertiser ID: <?php echo $stats['advertiser_id']; ?><br>
            
            <?php if(!empty($stats['unique_hits'])) { ?>
                <br>
                
                Unique Hits: <?php echo $stats['unique_hits']; ?><br>
                Total Hits: <?php echo $stats['total_hits']; ?><br>
                Total Time: <?php echo $stats['total_hit_time']; ?> seconds<br>
                Total Score Spend: <?php echo $stats['total_score']; ?><br>
                
                <br>
                
                <?php $totalHits = $stats['total_hits']; if($totalHits > 0){ ?>
                    Time Per Unique Hit: <?php echo ($stats['total_hit_time'] / $totalHits) ?> seconds<br>
                <?php } ?>
                
                <?php $totalScore = $stats['total_score']; if($totalScore > 0){ ?>
                    Time Per Score Spend: <?php echo ($stats['total_hit_time'] / $totalScore) ?> seconds<br>
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
            
            <?php foreach($stats['ads'] as $adId => $ad) { ?>
                <br>
                
                Ad ID: <?php echo $ad['id']; ?><br>
                Media Type: <?php echo mediaFormatToString($mediaFormats[$ad['type_media_format_id']], $mediaTypes, $mediaFormatDurations); ?><br>
                Media URL: <a href="<?php echo $ad['media_url']; ?>"><?php echo $ad['media_url']; ?></a><br>
                Countries: <?php echo ($ad['country_filter_excludes'] ? "All Except" : "Only"); ?> <?php echo ((count($ad['country_filter_list']) > 0) ? join(",", $ad['country_filter_list']) : "-none-"); ?><br>
            <?php } ?>
            
            <br>
            <br>
            <br>
        <?php } ?>
        
        
        
        <h2>All Data</h2><br>
        <?php debug($advertisersStatistics); ?>
    </body>
</html>





