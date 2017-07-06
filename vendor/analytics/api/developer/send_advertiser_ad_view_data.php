<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_api_developer.php");
apiHeaders();



$ip                         = getIpOrReturnError(10101, "can't retrieve IP");
$countryCode                = getCountryCode($ip);
$receivedData               = receiveJson();

returnErrorIfNotInArray(10102, "missing {var}", $receivedData, array('developer_id', 'developer_access_token', 'developer_game_id', 'has_send_data_before_for_game', 'has_send_data_before_for_ad', 'advertiser_ad_id', 'advertiser_ad_is_visual', 'advertiser_ad_is_aural', 'total_hit_time', 'total_screen_percentage', 'total_screen_position_x', 'total_screen_position_y', 'total_blocked_percentage', 'total_volume_percentage', 'platform', 'with_vr'));

$developerId                = $receivedData['developer_id'];
$developerAccessToken       = $receivedData['developer_access_token'];
$developerGameId            = $receivedData['developer_game_id'];

if(!validateDeveloper($developerId, $developerAccessToken, $developerGameId))
{
    returnError(10103, "invalid developer [Account ID], [Access Token] or [Game ID], check your Vreo plugin settings");
}

$hasSendDataBeforeForGame   = $receivedData['has_send_data_before_for_game'];
$hasSendDataBeforeForAd     = $receivedData['has_send_data_before_for_ad'];
$advertiserAdId             = $receivedData['advertiser_ad_id'];
$advertiserAdIsVisual       = $receivedData['advertiser_ad_is_visual'];
$advertiserAdIsAural        = $receivedData['advertiser_ad_is_aural'];
$totalHitTime               = $receivedData['total_hit_time'];
$totalScreenPercentage      = $receivedData['total_screen_percentage'];
$totalScreenPositionX       = $receivedData['total_screen_position_x'];
$totalScreenPositionY       = $receivedData['total_screen_position_y'];
$totalBlockedPercentage     = $receivedData['total_blocked_percentage'];
$totalVolumePercentage      = $receivedData['total_volume_percentage'];
$platform                   = strtolower($receivedData['platform']);
$withVr                     = $receivedData['with_vr'];

if(($totalHitTime <= 0) || ($totalScreenPercentage < 0) || ($totalScreenPositionX < 0) || ($totalScreenPositionY < 0) || ($totalBlockedPercentage < 0) || ($totalVolumePercentage < 0))
{
    returnError(10104, "invalid data (total_hit_time, total_screen_percentage, total_screen_position_x, total_screen_position_y, total_blocked_percentage or total_volume_percentage is under 0)");
}



$isDeveloperMode            = getDeveloperGameDeveloperMode($developerGameId);

if($isDeveloperMode)
{
    returnResult();
}



$advertiserId               = getAdvertiserIdOfAdvertiserAdIdOrReturnError($advertiserAdId, 10105, "invalid advertiser_ad_id");
$uniqueForIp                = (($hasSendDataBeforeForAd || $hasSendDataBeforeForGame) ? false : !isLoggedIp($ip));
$uniqueForAdvertiser        = ($hasSendDataBeforeForAd ? false : !isLoggedIpInAdvertiserStatistics($advertiserId, $ip));
$uniqueForDeveloperGame     = ($hasSendDataBeforeForGame ? false : !isLoggedIpInDeveloperGameStatistics($developerGameId, $ip));
$countAsHitForAdvertiser    = !$hasSendDataBeforeForAd;
$countAsHitForDeveloperGame = !$hasSendDataBeforeForGame;
$score                      = 0;

if(!$uniqueForIp)
{
    setIpIsLogged($ip, $uniqueForIp);
    setIpIsLoggedInAdvertiserStatistics($advertiserId, $ip, $uniqueForAdvertiser);
    setIpIsLoggedInDeveloperGameStatistics($advertiserId, $ip, $uniqueForDeveloperGame);
    addAdvertiserStatistics($advertiserId, $countryCode, $uniqueForAdvertiser, $countAsHitForAdvertiser, $advertiserAdIsVisual, $advertiserAdIsAural, $score, $totalHitTime, $totalScreenPercentage, $totalScreenPositionX, $totalScreenPositionY, $totalBlockedPercentage, $totalVolumePercentage, $platform, $withVr);
    addDeveloperGameStatistics($developerGameId, $countryCode, $uniqueForDeveloperGame, $countAsHitForDeveloperGame, $advertiserAdIsVisual, $advertiserAdIsAural, $score, $totalHitTime, $totalScreenPercentage, $totalScreenPositionX, $totalScreenPositionY, $totalBlockedPercentage, $totalVolumePercentage, $platform, $withVr);
    returnResult();
}



// a transaction, because we don't want users to be able to quickly send several requests and cause them all to count as unique
startTransaction();
{
    $uniqueForIp = !isLoggedIp($ip);
    setIpIsLogged($ip, $uniqueForIp);
}
endTransaction(true);

if($uniqueForIp)
{
    if($advertiserAdIsVisual)
    {
        $minScreenPercentage = 3.0;
        $maxScreenPercentage = 10.0;
        $minScreenPercentageScore = 9.0;
        $maxScreenPercentageScore = 30.0;
        if($totalScreenPercentage >= $minScreenPercentage)
        {
            $screenPercentageToScore = (($totalScreenPercentage <= $maxScreenPercentage) ? $totalScreenPercentage : $maxScreenPercentage) - $minScreenPercentage;
            $maxScreenPercentageToScore = $maxScreenPercentage - $minScreenPercentage;
            
            $score = (($maxScreenPercentageScore - $minScreenPercentageScore) * ($screenPercentageToScore / $maxScreenPercentageToScore)) + $minScreenPercentageScore;
            transferScoreFromAdvertiserToDeveloper($advertiserId, $developerId, $score);
        }
    }
    else if($advertiserAdIsAural)
    {
        $score = 15.0;
        transferScoreFromAdvertiserToDeveloper($advertiserId, $developerId, $score);
    }
}

setIpIsLoggedInAdvertiserStatistics($advertiserId, $ip, $uniqueForAdvertiser);
setIpIsLoggedInDeveloperGameStatistics($advertiserId, $ip, $uniqueForDeveloperGame);
addAdvertiserStatistics($advertiserId, $countryCode, $uniqueForAdvertiser, $countAsHitForAdvertiser, $advertiserAdIsVisual, $advertiserAdIsAural, $score, $totalHitTime, $totalScreenPercentage, $totalScreenPositionX, $totalScreenPositionY, $totalBlockedPercentage, $totalVolumePercentage, $platform, $withVr);
addDeveloperGameStatistics($developerGameId, $countryCode, $uniqueForDeveloperGame, $countAsHitForDeveloperGame, $advertiserAdIsVisual, $advertiserAdIsAural, $score, $totalHitTime, $totalScreenPercentage, $totalScreenPositionX, $totalScreenPositionY, $totalBlockedPercentage, $totalVolumePercentage, $platform, $withVr);

returnResult();








