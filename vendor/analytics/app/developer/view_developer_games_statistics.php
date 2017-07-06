<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_developer.php");
appHeaders();
requiresDeveloperAuth();



$developerGamesStatistics = getDeveloperGamesStatisticsOfSelf();

?>



<html>
    <body>
        <a href='.'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        
        
        <h1>Game Statistics</h1><br>
        
        
        
        <h2>Summary</h2><br>
        <?php foreach($developerGamesStatistics as $id => $stats) { ?>
            ID: <?php echo $id; ?><br>
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
            
            <br>
            <br>
            <br>
        <?php } ?>
        
        
        
        <h2>All Data</h2><br>
        <?php debug($developerGamesStatistics); ?>
    </body>
</html>





