<?php
$url = explode("?",$_SERVER['HTTP_REFERER']);

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );


if( !is_user_logged_in() ) exit;
global $wpdb;
$profileUserId = $_POST['id_user'];
$devUserId = $_POST['dev_user'];
$timePublish = $_POST['timeOut'];

switch ($_POST['profileBtn']){
	case 'signed': {
		delete_metadata('user', $devUserId, "follow_id",$profileUserId);
//		delete_metadata('user', $profileUserId, "follow_id",$devUserId);
		$argsNewCamp = get_user_meta($profileUserId, 'follow_id', false);
		$user_info = get_userdata($profileUserId);
		if ($user_info->roles[0] == 'developer') {
					$wpdb->insert(
						'activities',
						array(
							'id_user' => $devUserId,
							'type_notifications' => 'signedUser',
							'message' => "The signed developer -> <a href=\"/profile/?&user_id={$profileUserId}\">$user_info->display_name</a>",
							'status' => 0,
							'data' => $timePublish,
							'categories' => '',
							'hash_tag' => ''
						),
						array('%s', '%s')
					);
				} else {
					$wpdb->insert(
						'activities',
						array(
							'id_user' => $devUserId,
							'type_notifications' => 'signedUser',
							'message' => "The signed brand -> <a href=\"/profile/?&user_id={$profileUserId}\">$user_info->display_name</a>",
							'status' => 0,
							'data' => $timePublish,
							'categories' => '',
							'hash_tag' => ''
						),
						array('%s', '%s')
					);
		}
		break;
	}
	case 'follow': {
		add_user_meta( $devUserId, 'follow_id', $profileUserId, false );
//		add_user_meta( $profileUserId, 'follow_id', $devUserId, false );
		$argsNewCamp = get_user_meta($profileUserId, 'follow_id', false);
		$user_info = get_userdata($profileUserId);
		if ($user_info->roles[0] == 'developer') {
					$wpdb->insert(
						'activities',
						array(
							'id_user' => $devUserId,
							'type_notifications' => 'followUser',
							'message' => "<a href=\"/profile/?&user_id={$profileUserId}\">$user_info->display_name</a> wants to connect with you",
							'status' => 0,
							'data' => $timePublish,
							'categories' => '',
							'hash_tag' => ''
						),
						array('%s', '%s')
					);

				} else {
					$wpdb->insert(
						'activities',
						array(
							'id_user' => $devUserId,
							'type_notifications' => 'followUser',
							'message' => "<a href=\"/profile/?&user_id={$profileUserId}\">$user_info->display_name</a> wants to connect with you",
							'status' => 0,
							'data' => $timePublish,
							'categories' => '',
							'hash_tag' => ''
						),
						array('%s', '%s')
					);
				}
		break;
	}
	case 'signedMark': {
		$wpdb->delete( 'bookmark', array( 'id_users' => $profileUserId, 'id_post' => $devUserId ) );
		break;
	}
	case 'bookmark': {
		$user_info = get_userdata($profileUserId);
		$wpdb->insert(
			'bookmark',
			array(
				'id_users' => $profileUserId,
				'id_post' => $devUserId,
				'message' => "You have bookmarked [<a href=\"/profile/?&user_id={$devUserId}\">$user_info->display_name</a>]",
				'data' => $timePublish
			),
			array( '%s', '%s' )
		);
		break;
	}
	case 'signedCardMark': {
		$wpdb->delete( 'bookmark', array( 'id_users' => $devUserId, 'id_post' => $profileUserId ) );
		break;
	}
	case 'bookmarkCard': {
		$user_info = get_userdata($devUserId);
		$args = array(
			'p' => $profileUserId
		);
		$posts = get_posts( $args );
		foreach ($posts as $key) {
		$wpdb->insert(
			'bookmark',
			array(
				'id_users' => $devUserId,
				'id_post' => $profileUserId,
				'message' => "You have bookmarked [<a href=\"{$key->guid}\">$key->post_title</a>]",
				'data' => $timePublish
			),
			array( '%s', '%s' )
		);
		}
		break;
	}
	case 'bookmarkCardSigned': {
		$wpdb->delete( 'bookmark', array( 'id_users' => $profileUserId, 'id_post' => $devUserId ) );
		break;
	}
}
