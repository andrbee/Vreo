<?php

$id_campaign=$_POST['idCampaign']; // не обязательный пар-тр, так на всякий случай
$name_campaign=$_POST['nameCampaign'];
$link_campaign=$_POST['linkCampaign'];
$id_developer=$_POST['idDeveloper']; // не обязательный пар-тр, так на всякий случай
$name_developer=$_POST['nameDeveloper'];
$link_developer=$_POST['linkDeveloper'];
if(!empty($name_campaign) && !empty($link_campaign) && !empty($name_developer) && !empty($link_developer)){
    // Сообщение
    $message = "<h2>$name_campaign</h2><br>";
    $message .= "<a href='$link_campaign'>link campaign</a><br>";
    $message .= "<h2>$name_developer</h2><br>";
    $message .= "<a href='$link_developer'>link developer</a>";

// На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
//    $message = wordwrap($message, 70, "\r\n");

// Отправляем
    $status_mail=mail('andrbee@gmail.com', 'Complain campaign', $message);
//    echo $status_mail? "Complaint submitted": "The complaint is not sent";
    if($status_mail){ echo "Complaint submitted";} else  { echo "The complaint is not sent";}

} else {
    echo "The complaint is not sent";
}
?>