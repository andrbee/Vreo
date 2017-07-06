<?php



function isRecaptchaEnabled()
{
    global $RECAPTCHA_ENABLED;
    return (isset($RECAPTCHA_ENABLED) && $RECAPTCHA_ENABLED);
}

function getRecaptchaScript()
{
    global $RECAPTCHA_SITE_KEY;
    if(!isRecaptchaEnabled())
    {
        return "";
    }
    return "
    <script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>
    <script>
        var CaptchaCallback = function()
        {
            var recaptchaWidgets = document.getElementsByClassName('g-recaptcha');
            for(var i=0; i<recaptchaWidgets.length; i++)
            {
                var recaptchaWidget = recaptchaWidgets[i];  
                grecaptcha.render(recaptchaWidget, {'sitekey' : '".$RECAPTCHA_SITE_KEY."'});
            }
        };
    </script>
    ";
}

function getRecaptchaWidget()
{
    global $RECAPTCHA_SITE_KEY;
    if(!isRecaptchaEnabled())
    {
        return "";
    }
    return "<div class='g-recaptcha' data-sitekey='" . $RECAPTCHA_SITE_KEY . "'></div>";
}

function validateRecaptchaResponse($array)
{
    global $RECAPTCHA_SECRET_KEY;
    if(!isRecaptchaEnabled())
    {
        return true;
    }
    if(!isset($array['g-recaptcha-response']))
    {
        return false;
    }
    $vars = "secret=" . $RECAPTCHA_SECRET_KEY . "&response=" . $array['g-recaptcha-response'];
    $ip = getIp();
    if(!empty($ip))
    {
        $vars .= "&ip=" . $ip;
    }
    $response = curlPost("https://www.google.com/recaptcha/api/siteverify", $vars);
    if(!isset($response))
    {
        // curl error
        return true;
    }
    $json = json_decode($response, true);
    if(!isset($json['success']))
    {
        return false;
    }
    return $json['success'];
}












