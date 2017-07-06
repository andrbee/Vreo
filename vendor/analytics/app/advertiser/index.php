<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_advertiser.php");
appHeaders();
requiresAdvertiserAuth();

?>



<html>
    <body>
        <a href='../'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        <h1>Advertiser Panel</h1><br>
        
        <a href="edit_advertiser_ads.php">Edit Ads</a><br>
        <a href="view_developer_games.php">Bind Ads To Games</a><br>
        <br>
        <a href="view_advertisers_statistics.php">View Statistics</a><br>
    </body>
</html>







