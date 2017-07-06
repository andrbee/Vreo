<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_api_admin.php");
apiHeaders();



// a transaction, just to be certain nothing weird can ever happen
startTransaction();
{
    truncateLoggedIps();
    truncateAdvertiserStatisticsLoggedIps();
    truncateDeveloperGameStatisticsLoggedIps();
}
endTransaction(true);

returnResult();



