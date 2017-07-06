<?php



function validateDeveloperAccessToken($developerId, $developerAccessToken)
{
    global $database;
    $statement = prepareStatement("
 SELECT COUNT(*)
 FROM developer
 WHERE (id=?) AND (access_token=?)
    ");
    $statement->bind_param("is", $developerId, $developerAccessToken);
    return getCountAboveZeroStatementResult($statement);
}

function validateDeveloperGameId($developerId, $developerGameId)
{
    global $database;
    $statement = prepareStatement("
 SELECT COUNT(*)
 FROM developer_game
 WHERE (id=?) AND (developer_id=?)
    ");
    $statement->bind_param("ii", $developerGameId, $developerId);
    return getCountAboveZeroStatementResult($statement);
}

function validateDeveloper($developerId, $developerAccessToken, $developerGameId)
{
    if(!validateDeveloperAccessToken($developerId, $developerAccessToken))
    {
        return false;
    }
    return validateDeveloperGameId($developerId, $developerGameId);
}



function getDeveloperGameDeveloperMode($developerGameId)
{
    global $database;
    $statement = prepareStatement("
 SELECT developer_mode
 FROM developer_game
 WHERE (id=?)
    ");
    $statement->bind_param("i", $developerGameId);
    $result = getSingleStatementResult($statement);
    if(!isset($result))
    {
        return true;
    }
    return $result;
}



function getRandomAdvertiserAd($developerGameId, $typeMediaFormatIds, $countryCode, $minimumAdvertiserScoreRemaining = 0.0001)
{
    global $database;
    $statement = null;
    $typeMediaFormatIdsCount = count($typeMediaFormatIds);
    if(false)// use old query?
    {
        // old query, slow because of ORDER BY RAND(), but will always work
        $statement = prepareStatement("
 SELECT ad.id, mf.type_media_id, ad.media_url
 FROM advertiser_ad ad
 INNER JOIN type_media_format mf ON (mf.id=ad.type_media_format_id) AND (ad.type_media_format_id IN (".generateArraySql($typeMediaFormatIdsCount)."))
 INNER JOIN advertiser_ad_developer_games ad_games ON (ad_games.advertiser_ad_id=ad.id) AND (ad_games.developer_game_id=?)
 INNER JOIN advertiser ON (advertiser.id=ad.advertiser_id) AND (advertiser.score_remaining>=?)
 WHERE ((ad.country_filter_excludes=1) AND (NOT EXISTS(
   SELECT 1
   FROM   advertiser_ad_country_filter_list countries
   WHERE  (countries.advertiser_ad_id=ad.id) AND (countries.country_code=?)
 ))) OR ((ad.country_filter_excludes=0) AND (EXISTS(
   SELECT 1
   FROM   advertiser_ad_country_filter_list countries
   WHERE  (countries.advertiser_ad_id=ad.id) AND (countries.country_code=?)
 )))
 ORDER BY RAND()
 LIMIT 1
        ");
    }
    else
    {
        // new query, far faster than the old query, but requires variables and cases
        executeQuery("SET @varIndex=0");
        executeQuery("SET @varRandomIndex=-1");
        $statement = prepareStatement("
 SELECT sub.aa AS `advertiser_ad_id`, sub.bb AS `type_media_id`, sub.cc AS `media_url`
 FROM(
   SELECT ad.id AS aa, mf.type_media_id AS bb, ad.media_url AS cc, @varIndex:=@varIndex+1 AS dd
   FROM advertiser_ad ad
   INNER JOIN type_media_format mf ON (mf.id=ad.type_media_format_id) AND (ad.type_media_format_id IN (".generateArraySql($typeMediaFormatIdsCount)."))
   INNER JOIN advertiser_ad_developer_games ad_games ON (ad_games.advertiser_ad_id=ad.id) AND (ad_games.developer_game_id=?)
   INNER JOIN advertiser ON (advertiser.id=ad.advertiser_id) AND (advertiser.score_remaining>=?)
   WHERE (CASE WHEN (ad.country_filter_excludes=1) THEN (NOT EXISTS(
     SELECT 1
     FROM   advertiser_ad_country_filter_list countries
     WHERE  (countries.advertiser_ad_id=ad.id) AND (countries.country_code=?)
   )) ELSE (EXISTS(
     SELECT 1
     FROM   advertiser_ad_country_filter_list countries
     WHERE  (countries.advertiser_ad_id=ad.id) AND (countries.country_code=?)
   )) END)
 ) AS sub
 WHERE (sub.dd = (CASE WHEN (@varRandomIndex = -1) THEN @varRandomIndex:=FLOOR(1+(RAND()*@varIndex)) ELSE @varRandomIndex END))
        ");
    }
    $bindParamTypes = generateArrayBindParam($typeMediaFormatIdsCount,"i") . "idss";
    $bindParamValues = $typeMediaFormatIds;
    $bindParamValues[] = $developerGameId;
    $bindParamValues[] = $minimumAdvertiserScoreRemaining;
    $bindParamValues[] = $countryCode;
    $bindParamValues[] = $countryCode;
    callBindParam($statement, $bindParamTypes, $bindParamValues);
    return getSingleStatementResultsRow($statement);
}



function getAdvertiserIdOfAdvertiserAdIdOrReturnError($advertiserAdId, $errorCode, $error)
{
    global $database;
    $statement = prepareStatement("
 SELECT advertiser_id
 FROM advertiser_ad
 WHERE (id=?)
    ");
    $statement->bind_param("i", $advertiserAdId);
    $result = getSingleStatementResult($statement);
    if(!isset($result))
    {
        returnError($errorCode, $error);
    }
    return $result;
}



function isLoggedIp($ip)
{
    global $database;
    $statement = prepareStatement("
 SELECT COUNT(*)
 FROM logged_ips
 WHERE (ip=?)
    ");
    $statement->bind_param("s", $ip);
    return getCountAboveZeroStatementResult($statement);
}

function isLoggedIpInAdvertiserStatistics($advertiserId, $ip)
{
    global $database;
    $statement = prepareStatement("
 SELECT COUNT(*)
 FROM advertiser_statistics_logged_ips
 WHERE (advertiser_id=?) AND (ip=?)
    ");
    $statement->bind_param("is", $advertiserId, $ip);
    return getCountAboveZeroStatementResult($statement);
}

function isLoggedIpInDeveloperGameStatistics($developerGameId, $ip)
{
    global $database;
    $statement = prepareStatement("
 SELECT COUNT(*)
 FROM developer_game_statistics_logged_ips
 WHERE (developer_game_id=?) AND (ip=?)
    ");
    $statement->bind_param("is", $developerGameId, $ip);
    return getCountAboveZeroStatementResult($statement);
}



function setIpIsLogged($ip, $isUnique)
{
    if(!$isUnique)
    {
        return;
    }
    global $database;
    $statement = prepareStatement("
 INSERT IGNORE
 INTO logged_ips (ip)
 VALUES (?);
    ");
    $statement->bind_param("s", $ip);
    executeAndCloseStatement($statement, true);
}

function setIpIsLoggedInAdvertiserStatistics($advertiserId, $ip, $isUnique)
{
    if(!$isUnique)
    {
        return;
    }
    global $database;
    $statement = prepareStatement("
 INSERT IGNORE
 INTO advertiser_statistics_logged_ips (advertiser_id, ip)
 VALUES (?, ?);
    ");
    $statement->bind_param("is", $advertiserId, $ip);
    executeAndCloseStatement($statement, true);
}

function setIpIsLoggedInDeveloperGameStatistics($developerGameId, $ip, $isUnique)
{
    if(!$isUnique)
    {
        return;
    }
    global $database;
    $statement = prepareStatement("
 INSERT IGNORE
 INTO developer_game_statistics_logged_ips (developer_game_id, ip)
 VALUES (?, ?);
    ");
    $statement->bind_param("is", $developerGameId, $ip);
    executeAndCloseStatement($statement, true);
}



function transferScoreFromAdvertiserToDeveloper($advertiserId, $developerId, $score)
{
    global $database;
    {
        $statement = prepareStatement("
 UPDATE advertiser
 SET score_remaining = score_remaining - ?
 WHERE (id=?)
        ");
        $statement->bind_param("di", $score, $advertiserId);
        executeAndCloseStatement($statement);
    }
    {
        $statement = prepareStatement("
 UPDATE developer
 SET score_earned = score_earned + ?
 WHERE (id=?)
        ");
        $statement->bind_param("di", $score, $developerId);
        executeAndCloseStatement($statement);
    }
}



function addAdvertiserStatistics($advertiserId, $countryCode, $isUnique, $countAsHit, $isVisual, $isAural, $score, $totalHitTime, $totalScreenPercentage, $totalScreenPositionX, $totalScreenPositionY, $totalBlockedPercentage, $totalVolumePercentage, $platform, $withVr)
{
    global $database;
    {
        $statement = prepareStatement("
 INSERT INTO advertiser_statistics
 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
 ON DUPLICATE KEY UPDATE unique_hits = unique_hits + ?, unique_views = unique_views + ?, unique_hears = unique_hears + ?, total_hits = total_hits + ?, total_views = total_views + ?, total_hears = total_hears + ?, total_hit_time = total_hit_time + ?, total_view_time = total_view_time + ?, total_hear_time = total_hear_time + ?, total_score = total_score + ?, total_screen_percentage = total_screen_percentage + ?, total_screen_position_x = total_screen_position_x + ?, total_screen_position_y = total_screen_position_y + ?, total_blocked_percentage = total_blocked_percentage + ?, total_volume_percent = total_volume_percent + ?, unique_hits_platform_windows = unique_hits_platform_windows + ?, unique_hits_platform_mac = unique_hits_platform_mac + ?, unique_hits_platform_linux = unique_hits_platform_linux + ?, unique_hits_platform_android = unique_hits_platform_android + ?, unique_hits_platform_ios = unique_hits_platform_ios + ?, unique_hits_platform_xboxone = unique_hits_platform_xboxone + ?, unique_hits_platform_ps4 = unique_hits_platform_ps4 + ?, unique_hits_platform_web = unique_hits_platform_web + ?, unique_hits_vr = unique_hits_vr + ?, total_hits_platform_windows = total_hits_platform_windows + ?, total_hits_platform_mac = total_hits_platform_mac + ?, total_hits_platform_linux = total_hits_platform_linux + ?, total_hits_platform_android = total_hits_platform_android + ?, total_hits_platform_ios = total_hits_platform_ios + ?, total_hits_platform_xboxone = total_hits_platform_xboxone + ?, total_hits_platform_ps4 = total_hits_platform_ps4 + ?, total_hits_platform_web = total_hits_platform_web + ?, total_hits_vr = total_hits_vr + ?
        ");
        $add_unique_hits                    = ($isUnique ? 1 : 0);
        $add_unique_views                   = (($isUnique && $isVisual) ? 1 : 0);
        $add_unique_hears                   = (($isUnique && $isAural) ? 1 : 0);
        
        $add_total_hits                     = ($countAsHit ? 1 : 0);
        $add_total_views                    = (($countAsHit && $isVisual) ? 1 : 0);
        $add_total_hears                    = (($countAsHit && $isAural) ? 1 : 0);
        
        $add_total_hit_time                 = $totalHitTime;
        $add_total_view_time                = ($isVisual ? $totalHitTime : 0);
        $add_total_hear_time                = ($isAural ? $totalHitTime : 0);
        
        $add_total_score                    = $score;
        $add_total_screen_percentage        = ($isVisual ? $totalScreenPercentage : 0);
        $add_total_screen_position_x        = ($isVisual ? $totalScreenPositionX : 0);
        $add_total_screen_position_y        = ($isVisual ? $totalScreenPositionY : 0);
        $add_total_blocked_percentage       = ($isVisual ? $totalBlockedPercentage : 0);
        $add_total_volume_percent           = ($isAural ? $totalVolumePercentage : 0);
        
        $add_unique_hits_platform_windows   = (($isUnique && ($platform == "windows")) ? 1 : 0);
        $add_unique_hits_platform_mac       = (($isUnique && ($platform == "mac")) ? 1 : 0);
        $add_unique_hits_platform_linux     = (($isUnique && ($platform == "linux")) ? 1 : 0);
        $add_unique_hits_platform_android   = (($isUnique && ($platform == "android")) ? 1 : 0);
        $add_unique_hits_platform_ios       = (($isUnique && ($platform == "ios")) ? 1 : 0);
        $add_unique_hits_platform_xboxone   = (($isUnique && ($platform == "xboxone")) ? 1 : 0);
        $add_unique_hits_platform_ps4       = (($isUnique && ($platform == "ps4")) ? 1 : 0);
        $add_unique_hits_platform_web       = (($isUnique && ($platform == "web")) ? 1 : 0);
        $add_unique_hits_vr                 = (($isUnique && $withVr) ? 1 : 0);
        
        $add_total_hits_platform_windows    = (($countAsHit && ($platform == "windows")) ? 1 : 0);
        $add_total_hits_platform_mac        = (($countAsHit && ($platform == "mac")) ? 1 : 0);
        $add_total_hits_platform_linux      = (($countAsHit && ($platform == "linux")) ? 1 : 0);
        $add_total_hits_platform_android    = (($countAsHit && ($platform == "android")) ? 1 : 0);
        $add_total_hits_platform_ios        = (($countAsHit && ($platform == "ios")) ? 1 : 0);
        $add_total_hits_platform_xboxone    = (($countAsHit && ($platform == "xboxone")) ? 1 : 0);
        $add_total_hits_platform_ps4        = (($countAsHit && ($platform == "ps4")) ? 1 : 0);
        $add_total_hits_platform_web        = (($countAsHit && ($platform == "web")) ? 1 : 0);
        $add_total_hits_vr                  = (($countAsHit && $withVr) ? 1 : 0);
        
        $statement->bind_param("iiiiiiidddddddddiiiiiiiiiiiiiiiiiiiiiiiidddddddddiiiiiiiiiiiiiiiiii", $advertiserId, $add_unique_hits, $add_unique_views, $add_unique_hears, $add_total_hits, $add_total_views, $add_total_hears, $add_total_hit_time, $add_total_view_time, $add_total_hear_time, $add_total_score, $add_total_screen_percentage, $add_total_screen_position_x, $add_total_screen_position_y, $add_total_blocked_percentage, $add_total_volume_percent, $add_unique_hits_platform_windows, $add_unique_hits_platform_mac, $add_unique_hits_platform_linux, $add_unique_hits_platform_android, $add_unique_hits_platform_ios, $add_unique_hits_platform_xboxone, $add_unique_hits_platform_ps4, $add_unique_hits_platform_web, $add_unique_hits_vr, $add_total_hits_platform_windows, $add_total_hits_platform_mac, $add_total_hits_platform_linux, $add_total_hits_platform_android, $add_total_hits_platform_ios, $add_total_hits_platform_xboxone, $add_total_hits_platform_ps4, $add_total_hits_platform_web, $add_total_hits_vr, $add_unique_hits, $add_unique_views, $add_unique_hears, $add_total_hits, $add_total_views, $add_total_hears, $add_total_hit_time, $add_total_view_time, $add_total_hear_time, $add_total_score, $add_total_screen_percentage, $add_total_screen_position_x, $add_total_screen_position_y, $add_total_blocked_percentage, $add_total_volume_percent, $add_unique_hits_platform_windows, $add_unique_hits_platform_mac, $add_unique_hits_platform_linux, $add_unique_hits_platform_android, $add_unique_hits_platform_ios, $add_unique_hits_platform_xboxone, $add_unique_hits_platform_ps4, $add_unique_hits_platform_web, $add_unique_hits_vr, $add_total_hits_platform_windows, $add_total_hits_platform_mac, $add_total_hits_platform_linux, $add_total_hits_platform_android, $add_total_hits_platform_ios, $add_total_hits_platform_xboxone, $add_total_hits_platform_ps4, $add_total_hits_platform_web, $add_total_hits_vr);
        executeAndCloseStatement($statement);
    }
    if(($isUnique || $countAsHit) && !empty($countryCode))
    {
        $statement = prepareStatement("
 INSERT INTO advertiser_statistics_per_country
 VALUES (?, ?, ?, ?)
 ON DUPLICATE KEY UPDATE unique_hits = unique_hits + ?, total_hits = total_hits + ?
        ");
        $add_unique_hits = ($isUnique ? 1 : 0);
        $add_total_hits  = ($countAsHit ? 1 : 0);
        
        $statement->bind_param("isiiii", $advertiserId, $countryCode, $add_unique_hits, $add_total_hits, $add_unique_hits, $add_total_hits);
        executeAndCloseStatement($statement);
    }
}

function addDeveloperGameStatistics($developerGameId, $countryCode, $isUnique, $countAsHit, $isVisual, $isAural, $score, $totalHitTime, $totalScreenPercentage, $totalScreenPositionX, $totalScreenPositionY, $totalBlockedPercentage, $totalVolumePercentage, $platform, $withVr)
{
    global $database;
    {
        $statement = prepareStatement("
 INSERT INTO developer_game_statistics
 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
 ON DUPLICATE KEY UPDATE unique_hits = unique_hits + ?, unique_views = unique_views + ?, unique_hears = unique_hears + ?, total_hits = total_hits + ?, total_views = total_views + ?, total_hears = total_hears + ?, total_hit_time = total_hit_time + ?, total_view_time = total_view_time + ?, total_hear_time = total_hear_time + ?, total_score = total_score + ?, total_screen_percentage = total_screen_percentage + ?, total_screen_position_x = total_screen_position_x + ?, total_screen_position_y = total_screen_position_y + ?, total_blocked_percentage = total_blocked_percentage + ?, total_volume_percent = total_volume_percent + ?, unique_hits_platform_windows = unique_hits_platform_windows + ?, unique_hits_platform_mac = unique_hits_platform_mac + ?, unique_hits_platform_linux = unique_hits_platform_linux + ?, unique_hits_platform_android = unique_hits_platform_android + ?, unique_hits_platform_ios = unique_hits_platform_ios + ?, unique_hits_platform_xboxone = unique_hits_platform_xboxone + ?, unique_hits_platform_ps4 = unique_hits_platform_ps4 + ?, unique_hits_platform_web = unique_hits_platform_web + ?, unique_hits_vr = unique_hits_vr + ?, total_hits_platform_windows = total_hits_platform_windows + ?, total_hits_platform_mac = total_hits_platform_mac + ?, total_hits_platform_linux = total_hits_platform_linux + ?, total_hits_platform_android = total_hits_platform_android + ?, total_hits_platform_ios = total_hits_platform_ios + ?, total_hits_platform_xboxone = total_hits_platform_xboxone + ?, total_hits_platform_ps4 = total_hits_platform_ps4 + ?, total_hits_platform_web = total_hits_platform_web + ?, total_hits_vr = total_hits_vr + ?
        ");
        $add_unique_hits                    = ($isUnique ? 1 : 0);
        $add_unique_views                   = (($isUnique && $isVisual) ? 1 : 0);
        $add_unique_hears                   = (($isUnique && $isAural) ? 1 : 0);
        
        $add_total_hits                     = ($countAsHit ? 1 : 0);
        $add_total_views                    = (($countAsHit && $isVisual) ? 1 : 0);
        $add_total_hears                    = (($countAsHit && $isAural) ? 1 : 0);
        
        $add_total_hit_time                 = $totalHitTime;
        $add_total_view_time                = ($isVisual ? $totalHitTime : 0);
        $add_total_hear_time                = ($isAural ? $totalHitTime : 0);
        
        $add_total_score                    = $score;
        $add_total_screen_percentage        = ($isVisual ? $totalScreenPercentage : 0);
        $add_total_screen_position_x        = ($isVisual ? $totalScreenPositionX : 0);
        $add_total_screen_position_y        = ($isVisual ? $totalScreenPositionY : 0);
        $add_total_blocked_percentage       = ($isVisual ? $totalBlockedPercentage : 0);
        $add_total_volume_percent           = ($isAural ? $totalVolumePercentage : 0);
        
        $add_unique_hits_platform_windows   = (($isUnique && ($platform == "windows")) ? 1 : 0);
        $add_unique_hits_platform_mac       = (($isUnique && ($platform == "mac")) ? 1 : 0);
        $add_unique_hits_platform_linux     = (($isUnique && ($platform == "linux")) ? 1 : 0);
        $add_unique_hits_platform_android   = (($isUnique && ($platform == "android")) ? 1 : 0);
        $add_unique_hits_platform_ios       = (($isUnique && ($platform == "ios")) ? 1 : 0);
        $add_unique_hits_platform_xboxone   = (($isUnique && ($platform == "xboxone")) ? 1 : 0);
        $add_unique_hits_platform_ps4       = (($isUnique && ($platform == "ps4")) ? 1 : 0);
        $add_unique_hits_platform_web       = (($isUnique && ($platform == "web")) ? 1 : 0);
        $add_unique_hits_vr                 = (($isUnique && $withVr) ? 1 : 0);
        
        $add_total_hits_platform_windows    = (($countAsHit && ($platform == "windows")) ? 1 : 0);
        $add_total_hits_platform_mac        = (($countAsHit && ($platform == "mac")) ? 1 : 0);
        $add_total_hits_platform_linux      = (($countAsHit && ($platform == "linux")) ? 1 : 0);
        $add_total_hits_platform_android    = (($countAsHit && ($platform == "android")) ? 1 : 0);
        $add_total_hits_platform_ios        = (($countAsHit && ($platform == "ios")) ? 1 : 0);
        $add_total_hits_platform_xboxone    = (($countAsHit && ($platform == "xboxone")) ? 1 : 0);
        $add_total_hits_platform_ps4        = (($countAsHit && ($platform == "ps4")) ? 1 : 0);
        $add_total_hits_platform_web        = (($countAsHit && ($platform == "web")) ? 1 : 0);
        $add_total_hits_vr                  = (($countAsHit && $withVr) ? 1 : 0);
        
        $statement->bind_param("iiiiiiidddddddddiiiiiiiiiiiiiiiiiiiiiiiidddddddddiiiiiiiiiiiiiiiiii", $developerGameId, $add_unique_hits, $add_unique_views, $add_unique_hears, $add_total_hits, $add_total_views, $add_total_hears, $add_total_hit_time, $add_total_view_time, $add_total_hear_time, $add_total_score, $add_total_screen_percentage, $add_total_screen_position_x, $add_total_screen_position_y, $add_total_blocked_percentage, $add_total_volume_percent, $add_unique_hits_platform_windows, $add_unique_hits_platform_mac, $add_unique_hits_platform_linux, $add_unique_hits_platform_android, $add_unique_hits_platform_ios, $add_unique_hits_platform_xboxone, $add_unique_hits_platform_ps4, $add_unique_hits_platform_web, $add_unique_hits_vr, $add_total_hits_platform_windows, $add_total_hits_platform_mac, $add_total_hits_platform_linux, $add_total_hits_platform_android, $add_total_hits_platform_ios, $add_total_hits_platform_xboxone, $add_total_hits_platform_ps4, $add_total_hits_platform_web, $add_total_hits_vr, $add_unique_hits, $add_unique_views, $add_unique_hears, $add_total_hits, $add_total_views, $add_total_hears, $add_total_hit_time, $add_total_view_time, $add_total_hear_time, $add_total_score, $add_total_screen_percentage, $add_total_screen_position_x, $add_total_screen_position_y, $add_total_blocked_percentage, $add_total_volume_percent, $add_unique_hits_platform_windows, $add_unique_hits_platform_mac, $add_unique_hits_platform_linux, $add_unique_hits_platform_android, $add_unique_hits_platform_ios, $add_unique_hits_platform_xboxone, $add_unique_hits_platform_ps4, $add_unique_hits_platform_web, $add_unique_hits_vr, $add_total_hits_platform_windows, $add_total_hits_platform_mac, $add_total_hits_platform_linux, $add_total_hits_platform_android, $add_total_hits_platform_ios, $add_total_hits_platform_xboxone, $add_total_hits_platform_ps4, $add_total_hits_platform_web, $add_total_hits_vr);
        executeAndCloseStatement($statement);
    }
    if(($isUnique || $countAsHit) && !empty($countryCode))
    {
        $statement = prepareStatement("
 INSERT INTO developer_game_statistics_per_country
 VALUES (?, ?, ?, ?)
 ON DUPLICATE KEY UPDATE unique_hits = unique_hits + ?, total_hits = total_hits + ?
        ");
        $add_unique_hits = ($isUnique ? 1 : 0);
        $add_total_hits  = ($countAsHit ? 1 : 0);
        
        $statement->bind_param("isiiii", $developerGameId, $countryCode, $add_unique_hits, $add_total_hits, $add_unique_hits, $add_total_hits);
        executeAndCloseStatement($statement);
    }
}







