<?php



$APP_DIR = __DIR__;



require_once(__DIR__."/core/libs/backwardsCompatibility.php");
require_once(__DIR__."/core/libs/passwordLib.php");

require_once(__DIR__."/core/functions_general.php");

require_once(__DIR__."/config/environment.php");
if(isset($ENABLE_ERROR_REPORTING) && $ENABLE_ERROR_REPORTING)
{
    enableErrorReporting();
}

require_once(__DIR__."/config/headers.php");

require_once(__DIR__."/config/database.php");
require_once(__DIR__."/core/functions_database.php");

require_once(__DIR__."/config/recaptcha.php");
require_once(__DIR__."/core/functions_recaptcha.php");





