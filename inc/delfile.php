<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-includes/pluggable.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);


$paymentCompanyname = str_replace(" ", "", $user_info->user_email);
$filename = $_SERVER['DOCUMENT_ROOT'] . "wp-content/uploads/" . $paymentCompanyname;
$pathNew = $_SERVER['DOCUMENT_ROOT'] . "wp-content/uploads/" . $paymentCompanyname;
$compaignName = $_GET['number'];
$compaignDelete = $_GET['namefile'];
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $paymentCompanyname . "/slider/" . $compaignName . "/";

//echo $_GET['deletNames'];
//echo "<pre>";
//print_r($_GET['deletNames']);
//echo "</pre>";

echo unlink($upload_dir . basename($compaignDelete));

