<?php



function apiHeaders()
{
    // the back-end headers
    header('Access-Control-Allow-Origin: *');  
    header('Access-Control-Allow-Methods: GET, POST');
    header('Access-Control-Allow-Headers: content-type, pragma, x-unrealengine-agent');
}



function appHeaders()
{
    // the front-end headers
}



