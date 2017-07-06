<?php



function setSessionAuth($sessionname, $id, $loginToken)
{
    openSession();
    $_SESSION[$sessionname . '__auth_id'] = $id;
    $_SESSION[$sessionname . '__auth_key'] = hash('sha512', ($sessionname . $loginToken . $_SERVER['HTTP_USER_AGENT']));
    writeSession();
}

function clearSessionAuth($sessionname)
{
    openSession();
    unset($_SESSION[$sessionname . '__auth_id']);
    unset($_SESSION[$sessionname . '__auth_key']);
    writeSession();
}

function getSessionAuthId($sessionname)
{
    openSession();
    if(!isset($_SESSION[$sessionname . '__auth_id']) || !isset($_SESSION[$sessionname . '__auth_key']))
    {
        return null;
    }
    return $_SESSION[$sessionname . '__auth_id'];
}

function isSessionAuth($sessionname, $id, $loginToken)
{
    openSession();
    if(!isset($_SESSION[$sessionname . '__auth_id']) || !isset($_SESSION[$sessionname . '__auth_key']))
    {
        return false;
    }
    if($_SESSION[$sessionname . '__auth_id'] != $id)
    {
        return false;
    }
    $authkey = hash('sha512', ($sessionname . $loginToken . $_SERVER['HTTP_USER_AGENT']));
    return hash_equals($_SESSION[$sessionname . '__auth_key'], $authkey);
}



function isAuth($databaseTableName)
{
    $myid = getSessionAuthId($databaseTableName);
    if(!isset($myid))
    {
        return false;
    }
    $authData = getAuthDataById($databaseTableName, $myid);
    if(empty($authData))
    {
        clearSessionAuth($databaseTableName);
        return false;
    }
    if(!isSessionAuth($databaseTableName, $authData['id'], $authData['login_token']))
    {
        clearSessionAuth($databaseTableName);
        return false;
    }
    return true;
}

function tryAuth($databaseTableName, $username, $password)
{
    clearSessionAuth($databaseTableName);
    $authData = getAuthDataByUsernamePassword($databaseTableName, $username, $password);
    if(empty($authData))
    {
        return false;
    }
    setSessionAuth($databaseTableName, $authData['id'], $authData['login_token']);
    return true;
}

function clearAuth($databaseTableName)
{
    clearSessionAuth($databaseTableName);
}

function getAuthId($databaseTableName)
{
    return getSessionAuthId($databaseTableName);
}

function getAuthUsername($databaseTableName)
{
    $myid = getSessionAuthId($databaseTableName);
    if(!isset($myid))
    {
        return null;
    }
    return getAuthUsernameById($databaseTableName, $myid);
}

function changeAuthUsername($databaseTableName, $password, $username)
{
    $myid = getSessionAuthId($databaseTableName);
    if(!isset($myid))
    {
        return false;
    }
    $authData = setAuthUsernameAndGetAuthDataById($databaseTableName, $myid, $password, $username);
    if(empty($authData))
    {
        return false;
    }
    setSessionAuth($databaseTableName, $authData['id'], $authData['login_token']);
    return true;
}

function changeAuthPassword($databaseTableName, $oldPassword, $newPassword)
{
    $myid = getSessionAuthId($databaseTableName);
    if(!isset($myid))
    {
        return false;
    }
    $authData = setAuthPasswordAndGetAuthDataById($databaseTableName, $myid, $oldPassword, $newPassword);
    if(empty($authData))
    {
        return false;
    }
    setSessionAuth($databaseTableName, $authData['id'], $authData['login_token']);
    return true;
}

function registerAuth($databaseTableName, $username, $password, $hasAccessToken)
{
    clearSessionAuth($databaseTableName);
    $authData = registerAuthAndGetAuthData($databaseTableName, $username, $password, $hasAccessToken);
    if(empty($authData))
    {
        return false;
    }
    setSessionAuth($databaseTableName, $authData['id'], $authData['login_token']);
    return true;
}

function getAuthAccessToken($databaseTableName)
{
    $myid = getSessionAuthId($databaseTableName);
    if(!isset($myid))
    {
        return null;
    }
    return getAuthAccessTokenOfId($databaseTableName, $myid);
}

function refreshAuthAccessToken($databaseTableName, $password)
{
    $myid = getSessionAuthId($databaseTableName);
    if(!isset($myid))
    {
        return false;
    }
    return refreshAuthAccessTokenOfId($databaseTableName, $myid, $password);
}



function getAuthDataById($databaseTableName, $id)
{
    global $database;
    $statement = prepareStatement("
 SELECT login_token
 FROM ".$databaseTableName."
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    $result = getSingleStatementResultsRow($statement);
    if(empty($result))
    {
        return array();
    }
    $result['id'] = $id;
    return $result;
}

function getAuthDataByUsernamePassword($databaseTableName, $username, $password)
{
    global $database;
    $statement = prepareStatement("
 SELECT id, login_token, password_hash
 FROM ".$databaseTableName."
 WHERE (username=?)
    ");
    $statement->bind_param("s", $username);
    $result = getSingleStatementResultsRow($statement);
    if(empty($result))
    {
        return array();
    }
    if(!password_verify($password, $result['password_hash']))
    {
        return array();
    }
    unset($result['password_hash']);
    return $result;
}

function isAuthPasswordCorrect($databaseTableName, $id, $password)
{
    global $database;
    $statement = prepareStatement("
 SELECT password_hash
 FROM ".$databaseTableName."
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    $passwordHash = getSingleStatementResult($statement);
    if(!isset($passwordHash))
    {
        return false;
    }
    return password_verify($password, $passwordHash);
}

function setAuthUsernameAndGetAuthDataById($databaseTableName, $id, $password, $username)
{
    global $database;
    if(!isAuthPasswordCorrect($databaseTableName, $id, $password))
    {
        return array();
    }
    $statement = prepareStatement("
 UPDATE ".$databaseTableName."
 SET username = ?, login_token = ?
 WHERE (id=?)
        ");
    $newLoginToken = generateLoginToken();
    $statement->bind_param("ssi", $username, $newLoginToken, $id);
    executeAndCloseStatement($statement);
    return array('id' => $id, 'login_token' => $newLoginToken);
}

function setAuthPasswordAndGetAuthDataById($databaseTableName, $id, $oldPassword, $newPassword)
{
    global $database;
    if(!isAuthPasswordCorrect($databaseTableName, $id, $oldPassword))
    {
        return array();
    }
    $statement = prepareStatement("
 UPDATE ".$databaseTableName."
 SET password_hash = ?, login_token = ?
 WHERE (id=?)
        ");
    $newLoginToken = generateLoginToken();
    $newPasswordHash = generatePasswordHash($newPassword);
    $statement->bind_param("ssi", $newPasswordHash, $newLoginToken, $id);
    executeAndCloseStatement($statement);
    return array('id' => $id, 'login_token' => $newLoginToken);
}

function getAuthUsernameById($databaseTableName, $id)
{
    global $database;
    $statement = prepareStatement("
 SELECT username
 FROM ".$databaseTableName."
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    return getSingleStatementResult($statement);
}

function registerAuthAndGetAuthData($databaseTableName, $username, $password, $hasAccesToken)
{
    global $database;
    $passwordHash = generatePasswordHash($password);
    $loginToken = generateLoginToken();
    if($hasAccesToken)
    {
        $statement = prepareStatement("
     INSERT INTO ".$databaseTableName." (username, password_hash, login_token, access_token)
     VALUES (?, ?, ?, ?)
            ");
        $acessToken = generateAccessToken();
        $statement->bind_param("ssss", $username, $passwordHash, $loginToken, $acessToken);
        executeAndCloseStatement($statement);
    }
    else
    {
        $statement = prepareStatement("
     INSERT INTO ".$databaseTableName." (username, password_hash, login_token)
     VALUES (?, ?, ?)
            ");
        $statement->bind_param("sss", $username, $passwordHash, $loginToken);
        executeAndCloseStatement($statement);
    }
    $id = getLastInsertedId();
    return array('id' => $id, 'login_token' => $loginToken);
}



function getAuthAccessTokenOfId($databaseTableName, $id)
{
    global $database;
    $statement = prepareStatement("
 SELECT access_token
 FROM ".$databaseTableName."
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    return getSingleStatementResult($statement);
}

function refreshAuthAccessTokenOfId($databaseTableName, $id, $password)
{
    global $database;
    if(!isAuthPasswordCorrect($databaseTableName, $id, $password))
    {
        return false;
    }
    $statement = prepareStatement("
 UPDATE ".$databaseTableName."
 SET access_token = ?
 WHERE (id=?)
    ");
    $accessToken = generateAccessToken();
    $statement->bind_param("si", $accessToken, $id);
    executeAndCloseStatement($statement);
    return true;
}










