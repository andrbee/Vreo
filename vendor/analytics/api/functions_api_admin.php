<?php



function truncateLoggedIps()
{
    global $database;
    $statement = prepareStatement("
 TRUNCATE logged_ips
    ");
    executeAndCloseStatement($statement);
}

function truncateAdvertiserStatisticsLoggedIps()
{
    global $database;
    $statement = prepareStatement("
 TRUNCATE advertiser_statistics_logged_ips
    ");
    executeAndCloseStatement($statement);
}

function truncateDeveloperGameStatisticsLoggedIps()
{
    global $database;
    $statement = prepareStatement("
 TRUNCATE developer_game_statistics_logged_ips
    ");
    executeAndCloseStatement($statement);
}





