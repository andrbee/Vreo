<?php

require_once(__DIR__."/functions_app_general.php");
require_once(__DIR__."/functions_app_authentication.php");



function redirectToAdvertiserRoot()
{
    redirectPath("app/advertiser/");
}

function requiresAdvertiserAuth()
{
    if(!isAuth("advertiser"))
    {
        redirectPath("app/advertiser/account_login.php");
    }
}

function redirectIfAdvertiserAuth()
{
    if(isAuth("advertiser"))
    {
        redirectPath("app/advertiser/");
    }
}

function tryAdvertiserAuth($username, $password)
{
    if(tryAuth("advertiser", $username, $password))
    {
        redirectIfAdvertiserAuth();
    }
}

function clearAdvertiserAuth()
{
    return clearAuth("advertiser");
}

function getAdvertiserAuthId()
{
    return getAuthId("advertiser");
}

function getAdvertiserAuthUsername()
{
    return getAuthUsername("advertiser");
}

function changeAdvertiserAuthUsername($password, $username)
{
    return changeAuthUsername("advertiser", $password, $username);
}

function changeAdvertiserAuthPassword($oldPassword, $newPassword)
{
    return changeAuthPassword("advertiser", $oldPassword, $newPassword);
}

function registerAdvertiserAuth($password, $username)
{
    if(registerAuth("advertiser", $password, $username, false))
    {
        redirectIfAdvertiserAuth();
    }
}



function isAdvertiserAdFromSelf($advertiserAdId)
{
    $myid = getAdvertiserAuthId();
    if(!isset($myid))
    {
        return false;
    }
    return isAdvertiserAdFromAdvertiser($advertiserAdId, $myid);
}

function getAdvertiserAdsOfSelf()
{
    $myid = getAdvertiserAuthId();
    if(!isset($myid))
    {
        return array();
    }
    return getAdvertiserAdsFromAdvertiser($myid);
}

function addAdvertiserAdOfSelf($typeMediaFormatId, $countryFilterExcludes, $mediaUrl, $countryFilterList)
{
    $myid = getAdvertiserAuthId();
    if(!isset($myid))
    {
        return;
    }
    addAdvertiserAd($myid, $typeMediaFormatId, $countryFilterExcludes, $mediaUrl, $countryFilterList);
}

function getAdvertisersStatisticsOfSelf()
{
    $myid = getAdvertiserAuthId();
    if(!isset($myid))
    {
        return array();
    }
    return getAdvertisersStatisticsOfAdvertiser($myid);
}

function changeAdvertiserAdDeveloperGamesOfSelf($developerGameId, $advertiserAdIds)
{
    $myid = getAdvertiserAuthId();
    if(!isset($myid))
    {
        return;
    }
    changeAdvertiserAdDeveloperGames($myid, $developerGameId, $advertiserAdIds);
}









