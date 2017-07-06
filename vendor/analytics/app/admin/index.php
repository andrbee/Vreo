<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_admin.php");
appHeaders();
requiresAdminAuth();

?>



<html>
    <body>
        <a href='../'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        <h1>Admin Panel</h1>
        
        <?php if(canAdminEditAdmins()) { ?>
            <br>
            <a href='edit_admins.php'>Edit Admins</a><br>
        <?php } ?>
        
        <?php if(canAdminEditSystem()) { ?>
            <br>
            <a href='edit_system_game_genres.php'>Edit Game Genres</a><br>
            <a href='edit_system_age_restrictions.php'>Edit Age Restrictions</a><br>
            <a href='edit_system_media_format_durations.php'>Edit Media Format Durations</a><br>
            <a href='edit_system_media_formats.php'>Edit Media Formats</a><br>
        <?php } ?>
        
        <br>
        <a href='view_developer_games_statistics.php'>View Games</a><br>
        <a href='view_advertisers_statistics.php'>View Advertisers</a><br>
    </body>
</html>







