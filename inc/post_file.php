<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-includes/pluggable.php');
require_once( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$demo_mode = false;

$allowed_ext = array('jpg','jpeg','png','gif');


$paymentCompanyname = str_replace(" ","",$user_info->user_email);
$filename = $_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/".$paymentCompanyname;
$pathNew = $_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/".$paymentCompanyname;
$compaignName = $_GET['number'];
$upload_dir = $_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/".$paymentCompanyname."/slider/".$compaignName."/";

$pathNew2 = $pathNew . "/slider/";
$pathNew3 = $pathNew2 ."{$compaignName}";


if (file_exists($filename)) {
	if (file_exists($pathNew3)){
		if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
			exit_status('Error! Wrong HTTP method!');
		}
		if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ) {
			$pic = $_FILES['pic'];

			if(!in_array(get_extension($pic['name']),$allowed_ext)){
				exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
			}

			if($demo_mode){
				// File uploads are ignored. We only log them.

				$line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $pic['size'], $pic['name']));
				file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);
				exit_status('Uploads are ignored in demo mode.');
			}
			// Move the uploaded file from the temporary
			// directory to the uploads folder:
			if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){

				exit_status('File was uploaded successfuly!');
			}
		}
	} else {
		mkdir($pathNew3, 0755);
		if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
			exit_status('Error! Wrong HTTP method!');
		}
		if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ) {
			$pic = $_FILES['pic'];

			if(!in_array(get_extension($pic['name']),$allowed_ext)){
				exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
			}

			if($demo_mode){
				// File uploads are ignored. We only log them.

				$line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $pic['size'], $pic['name']));
				file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);
				exit_status('Uploads are ignored in demo mode.');
			}
			// Move the uploaded file from the temporary
			// directory to the uploads folder:

			if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){
				exit_status('File was uploaded successfuly!');
			}
		}
	}
} else {
		mkdir($pathNew, 0755);

		mkdir($pathNew2, 0755);

		mkdir($pathNew3, 0755);
		if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
			exit_status('Error! Wrong HTTP method!');
		}
		if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ) {
			$pic = $_FILES['pic'];

			if(!in_array(get_extension($pic['name']),$allowed_ext)){
				exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
			}

			if($demo_mode){

				// File uploads are ignored. We only log them.

				$line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $pic['size'], $pic['name']));
				file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);

				exit_status('Uploads are ignored in demo mode.');
			}


				// Move the uploaded file from the temporary
				// directory to the uploads folder:

				if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){
						exit_status('File was uploaded successfuly!');
				}

		}
}

exit_status('Something went wrong with your upload!');


// Helper functions

function exit_status($str){
	echo json_encode(array('status'=>$str));
	exit;
}

function get_extension($file_name){
	$ext = explode('.', $file_name);
	$ext = array_pop($ext);
	return strtolower($ext);
}
?>