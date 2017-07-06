<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

require_once(__DIR__."/application.php");
appHeaders();



if(!isset($ALLOW_TEST_INSTALLATION) || !$ALLOW_TEST_INSTALLATION)
{
    die("not allowed");
}



enableErrorReporting();



startTransaction();
endTransaction(true);

startTransaction();
endTransaction(false);



curlGet("https://demo.", true);



openSession();
closeSession();



returnResult();