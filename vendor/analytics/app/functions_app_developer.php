<?php

require_once(__DIR__."/functions_app_general.php");
require_once(__DIR__."/functions_app_authentication.php");



function redirectToDeveloperRoot()
{
    redirectPath("app/developer/");
}

function requiresDeveloperAuth()
{
    if(!isAuth("developer"))
    {
        redirectPath("app/developer/account_login.php");
    }
}

function redirectIfDeveloperAuth()
{
    if(isAuth("developer"))
    {
        redirectPath("app/developer/");
    }
}

function tryDeveloperAuth($username, $password)
{
    if(tryAuth("developer", $username, $password))
    {
        redirectIfDeveloperAuth();
    }
}

function clearDeveloperAuth()
{
    return clearAuth("developer");
}

function getDeveloperAuthId()
{
    return getAuthId("developer");
}

function getDeveloperAuthUsername()
{
    return getAuthUsername("developer");
}

function changeDeveloperAuthUsername($password, $username)
{
    return changeAuthUsername("developer", $password, $username);
}

function changeDeveloperAuthPassword($oldPassword, $newPassword)
{
    return changeAuthPassword("developer", $oldPassword, $newPassword);
}

function registerDeveloperAuth($password, $username)
{
    if(registerAuth("developer", $password, $username, true))
    {
        redirectIfDeveloperAuth();
    }
}

function getDeveloperAuthAccessToken()
{
    return getAuthAccessToken("developer");
}

function refreshDeveloperAuthAccessToken($password)
{
    return refreshAuthAccessToken("developer", $password);
}



function isDeveloperGameFromSelf($developerGameId)
{
    $myid = getDeveloperAuthId();
    if(!isset($myid))
    {
        return false;
    }
    return isDeveloperGameFromDeveloper($developerGameId, $myid);
}

function getDeveloperGamesOfSelf()
{
    $myid = getDeveloperAuthId();
    if(!isset($myid))
    {
        return array();
    }
    return getDeveloperGamesFromDeveloper($myid);
}

function addDeveloperGameOfSelf($name, $typeAgeRestrictionId, $available, $developerMode, $genreIds)
{
    $myid = getDeveloperAuthId();
    if(!isset($myid))
    {
        return;
    }
    addDeveloperGame($myid, $name, $typeAgeRestrictionId, $available, $developerMode, $genreIds);
}

function getDeveloperGamesStatisticsOfSelf()
{
    $myid = getDeveloperAuthId();
    if(!isset($myid))
    {
        return array();
    }
    return getDeveloperGamesStatisticsOfDeveloper($myid);
}









