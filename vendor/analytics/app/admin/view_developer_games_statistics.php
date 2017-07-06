<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_admin.php");
appHeaders();
requiresAdminAuth();



$genres = getGameGenres();
$ageRestrictionIds = getAgeRestrictions();

$developerGamesStatistics = getDeveloperGamesStatisticsForAdmins();

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
            Game ID: <?php echo $stats['developer_game_id']; ?><br>
            Game Developer ID: <?php echo $stats['developer_id']; ?><br>
            Game Name: <?php echo $stats['name']; ?><br>
            Game Genres: <?php echo join(", ", replaceGameGenreIds($stats['genre_ids'], $genres)); ?><br>
            Game Minimum Age: <?php echo $ageRestrictionIds[$stats['type_age_restriction_id']]['minimum_age'] ?> years<br>
            Game Available: <?php echo ($stats['available'] ? "Yes" : "No"); ?><br>
            Game Developer Mode: <?php echo ($stats['developer_mode'] ? "Yes" : "No"); ?><br>
            
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
            <br>
            <br>
        <?php } ?>
        
        
        
        <h2>All Data</h2><br>
        <?php debug($developerGamesStatistics); ?>
    </body>
</html>





