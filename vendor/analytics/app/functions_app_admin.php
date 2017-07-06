<?php

require_once(__DIR__."/functions_app_general.php");
require_once(__DIR__."/functions_app_authentication.php");



function redirectToAdminRoot()
{
    redirectPath("app/admin/");
}

function requiresAdminAuth()
{
    if(!isAuth("admin"))
    {
        redirectPath("app/admin/account_login.php");
    }
}

function redirectIfAdminAuth()
{
    if(isAuth("admin"))
    {
        redirectPath("app/admin/");
    }
}

function tryAdminAuth($username, $password)
{
    if(tryAuth("admin", $username, $password))
    {
        redirectIfAdminAuth();
    }
}

function clearAdminAuth()
{
    return clearAuth("admin");
}

function getAdminAuthId()
{
    return getAuthId("admin");
}

function getAdminAuthUsername()
{
    return getAuthUsername("admin");
}

function changeAdminAuthUsername($password, $username)
{
    return changeAuthUsername("admin", $password, $username);
}

function changeAdminAuthPassword($oldPassword, $newPassword)
{
    return changeAuthPassword("admin", $oldPassword, $newPassword);
}



function canAdminEditAdmins()
{
    global $database;
    $myid = getAdminAuthId();
    if(!isset($myid))
    {
        return false;
    }
    $statement = prepareStatement("
 SELECT can_edit_admins
 FROM admin
 WHERE (id=?)
    ");
    $statement->bind_param("i", $myid);
    $result = getSingleStatementResult($statement);
    return (isset($result) && $result);
}

function canAdminEditSystem()
{
    global $database;
    $myid = getAdminAuthId();
    if(!isset($myid))
    {
        return false;
    }
    $statement = prepareStatement("
 SELECT can_edit_system
 FROM admin
 WHERE (id=?)
    ");
    $statement->bind_param("i", $myid);
    $result = getSingleStatementResult($statement);
    return (isset($result) && $result);
}



function getAdminsExceptSelf()
{
    global $database;
    $myid = getAdminAuthId();
    $statement = prepareStatement("
 SELECT id, username, can_edit_admins, can_edit_system
 FROM admin
 ORDER BY username
    ");
    $result = getStatementResultsWithCustomKey($statement, "id");
    if(isset($myid))
    {
        unset($result[$myid]);
    }
    return $result;
}

function deleteAdmin($id)
{
    global $database;
    $myid = getAdminAuthId();
    if(!isset($myid) || ($myid == $id))
    {
        // can't delete self
        return;
    }
    $statement = prepareStatement("
 DELETE
 FROM admin
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    executeAndCloseStatement($statement);
}

function changeAdmin($id, $username, $canEditAdmins, $canEditSystem)
{
    global $database;
    $myid = getAdminAuthId();
    if(!isset($myid) || ($myid == $id))
    {
        // can't delete self
        return;
    }
    $statement = prepareStatement("
 UPDATE admin
 SET username = ?, can_edit_admins = ?, can_edit_system = ?
 WHERE (id=?)
    ");
    $statement->bind_param("siii", $username, $canEditAdmins, $canEditSystem, $id);
    executeAndCloseStatement($statement);
}

function addAdmin($username, $password, $canEditAdmins, $canEditSystem)
{
    global $database;
    $statement = prepareStatement("
 INSERT INTO admin (username, password_hash, login_token, can_edit_admins, can_edit_system)
 VALUES (?, ?, ?, ?, ?)
    ");
    $passwordHash = generatePasswordHash($password);
    $loginToken = generateLoginToken();
    $statement->bind_param("sssii", $username, $passwordHash, $loginToken, $canEditAdmins, $canEditSystem);
    executeAndCloseStatement($statement);
}









