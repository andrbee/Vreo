<?php



function enableErrorReporting()
{
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
}



function debug($var)
{
    echo("<pre>".print_r($var, true)."</pre>");
}



function receiveJson()
{
    return json_decode(file_get_contents("php://input"), true);
}

/** useful for debugging **/
function receiveJsonFromRequest($key = "json")
{
    global $_REQUEST;
    if(!isset($_REQUEST[$key]))
    {
        return array();
    }
    return json_decode($_REQUEST[$key], true);
}



function returnResult($result = null)
{
    header('Content-Type:application/json;charset=utf-8');
    if(isset($result))
    {
        echo(json_encode(array("success" => "true", "result" => $result)));
    }
    else
    {
        echo(json_encode(array("success" => "true")));
    }
    exit;
}

function returnError($errorCode, $error)
{
    header('Content-Type:application/json;charset=utf-8');
    echo(json_encode(array("success" => "false", "error_code" => $errorCode, "error" => $error)));
    exit;
}



function returnErrorIfNotInArray($errorCode, $errorMessage, $array, $varnames)
{
    foreach($varnames as $varname)
    {
        if(!isset($array[$varname]))
        {
            returnError($errorCode, str_replace("{var}", $varname, $errorMessage));
        }
    }
}



function getIp()
{
    if(isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
    {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if(isset($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP))
    {
        return $_SERVER['REMOTE_ADDR'];
    }
    return "";
}

function getIpOrReturnError($errorCode, $errorMessage)
{
    $ip = getIp();
    if(empty($ip))
    {
        returnError($errorCode, $errorMessage);
    }
    return $ip;
}

function getCountryCode($ip)
{
    if(empty($ip))
    {
        return "";
    }
    $ipdata = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
    if(isset($ipdata) && isset($ipdata->geoplugin_countryCode))
    {
        return strtoupper($ipdata->geoplugin_countryCode);
    }
    return "";
}



function redirectUrl($url)
{
    header("Location: " . $url);
    echo "<script type='text/javascript'>window.location = '" .$url . "'</script>";
    die();
}

function redirectPath($path)
{
    redirectUrl(getRequestScheme() . $_SERVER['HTTP_HOST'] . getAppPath() . $path);
}

function redirectRelativePath($path)
{
    redirectUrl(getRequestScheme() . $_SERVER['HTTP_HOST'] . getRelativePath() . $path);
}

function refresh()
{
    redirectUrl(getRequestScheme() . $_SERVER['HTTP_HOST'] . getRelativePathIncludingFile() . $path);
}



function removePostData()
{
    if(isset($_POST) && !empty($_POST))
    {
        refresh();
    }
}



function getAppPath()
{
    global $APP_DIR;
    $a = substr(getcwd(), strlen($APP_DIR));
    $b = substr(dirname($_SERVER['SCRIPT_FILENAME']), strlen($_SERVER['DOCUMENT_ROOT']));
    $c = substr($b, 0, strlen($b) - strlen($a));
    return $c . "/";
}

function getRelativePath()
{
    $b = substr(dirname($_SERVER['SCRIPT_FILENAME']), strlen($_SERVER['DOCUMENT_ROOT']));
    return $b . "/";
}

function getRelativePathIncludingFile()
{
    $b = substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['DOCUMENT_ROOT']));
    return $b;
}



function isHttps()
{
    if(isset($_SERVER['SERVER_PORT']) && !empty($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] == 443))
    {
        return true;
    }
    if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) !== 'off'))
    {
        return true;
    }
    return false;
}

function getRequestScheme()
{
     return (isHttps() ? "https://" : "http://");
}



function curlPost($url, $vars, $dieOnError = false)
{
    $ch = curl_init();
    if($ch === false)
    {
        if($dieOnError)
        {
            returnError(10401, "curl failed to initialize");
        }
        else
        {
            return null;
        }
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    if($response === false)
    {
        if($dieOnError)
        {
            $errormessage = "[" . curl_errno($ch) . "] " . curl_error($ch);
            curl_close($ch);
            returnError(10402, $errormessage);
        }
        else
        {
            curl_close($ch);
            return null;
        }
    }
    curl_close($ch);
    return $response;
}

function curlGet($url, $dieOnError = false)
{
    $ch = curl_init();
    if($ch === false)
    {
        if($dieOnError)
        {
            returnError(10401, "curl failed to initialize");
        }
        else
        {
            return null;
        }
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    if($response === false)
    {
        if($dieOnError)
        {
            $errormessage = "[" . curl_errno($ch) . "] " . curl_error($ch);
            curl_close($ch);
            returnError(10403, $errormessage);
        }
        else
        {
            curl_close($ch);
            return null;
        }
    }
    curl_close($ch);
    return $response;
}



function openSession()
{
    if(!isset($_SESSION))
    {
        session_start();
    }
}

function closeSession()
{
    if(isset($_SESSION))
    {
        session_write_close();
        unset($_SESSION);
    }
}

function writeSession()
{
    if(isset($_SESSION))
    {
        session_write_close();
        session_start();
    }
}



function generateRandomString($length, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $charactersLength = strlen($characters);
    $randomString = '';
    for($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



function generatePasswordHash($password)
{
    global $PASSWORDS_BCRYPT_COST;
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => $PASSWORDS_BCRYPT_COST]);
}

function generateLoginToken()
{
    return generateRandomString(50);
}

function generateAccessToken()
{
    return generateRandomString(50);
}



function includeJavascriptFunctionsGeneralScript()
{
    echo "<script src='".getAppPath()."core/javascript_functions_general.js'></script>\r\n";
}



function dontAutofillAccountFields()
{
    echo "<input name='dont_autofill_the_username' type='text' style='display:none;'>";
    echo "<input name='dont_autofill_the_password' type='password' style='display:none;'>";
}



function purgeString($string)
{
    return str_replace("\"", "", str_replace("'", "", trim($string)));
}



function splitAndTrim($string)
{
    $arrayraw = explode(",", $string);
    $array = array();
    foreach($arrayraw as $item)
    {
        $item = trim($item);
        if(strlen($item) > 0)
        {
            $array[] = $item;
        }
    }
    return $array;
}

function splitAndPurgeString($string)
{
    $arrayraw = explode(",", $string);
    $array = array();
    foreach($arrayraw as $item)
    {
        $item = purgeString($item);
        if(strlen($item) > 0)
        {
            $array[] = $item;
        }
    }
    return $array;
}












