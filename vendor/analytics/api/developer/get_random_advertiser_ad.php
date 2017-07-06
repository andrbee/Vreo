<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_api_developer.php");
apiHeaders();



$ip                         = getIpOrReturnError(10101, "can't retrieve IP");
$countryCode                = getCountryCode($ip);
$receivedData               = receiveJson();

returnErrorIfNotInArray(10102, "missing {var}", $receivedData, array('developer_id', 'developer_access_token', 'developer_game_id', 'type_media_format_ids'));

$developerId                = $receivedData['developer_id'];
$developerAccessToken       = $receivedData['developer_access_token'];
$developerGameId            = $receivedData['developer_game_id'];

if(!validateDeveloper($developerId, $developerAccessToken, $developerGameId))
{
    returnError(10103, "invalid developer [Account ID], [Access Token] or [Game ID], check your Vreo plugin settings");
}

$typeMediaFormatIds         = explode(",", $receivedData['type_media_format_ids']);



$randomAd                   = getRandomAdvertiserAd($developerGameId, $typeMediaFormatIds, $countryCode);

if(empty($randomAd))
{
    returnError(10201, "no advertisement is available"); // change to "Place Your Advertisement Here" result
}
returnResult($randomAd);






