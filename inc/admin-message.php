<?php
$url = explode("page=activities?",$_SERVER['HTTP_REFERER']);

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );


$cur_user_id = get_current_user_id();

$activitiesAdmin = $_POST['activitiesAdmin'];
$timePublish = $_POST['timePublish'];
//print_r($url);
if (!empty($activitiesAdmin)){
	$argsUser = array('role__not_in' => 'administrator');
	$masUser = get_users($argsUser);
	$colUser = 0;
	foreach ($masUser as $item) {
		$bdUserKey[$colUser] = $item->ID;
		$colUser++;
	}
	for ($i = 0; $i<count($bdUserKey); $i++) {
		$wpdb->insert(
			'activities',
			array(
				'id_user' => $bdUserKey[$i],
				'type_notifications' => 'adminMessageAll',
				'message' => $activitiesAdmin,
				'status' => 0,
				'data' => $timePublish,
				'categories' => '',
				'hash_tag' => ''
			),
			array( '%s', '%s' )
		);

	}

	header('location:' . $url[0] . '&status=ok');
	exit;
} else {
	header('location:' . $url[0] . '&status=required');
	exit;
}
