<?php
$url = explode("?",$_SERVER['HTTP_REFERER']);

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );


if( !is_user_logged_in() ) exit;

$cur_user_id = get_current_user_id();
$user_ID = get_current_user_id();
$user = get_user_by( 'id', $user_ID );
$timeProfile = $_POST['timeProfile'];

if( $_POST['profile-categore'] && $_POST['profile-hash']) {
    $metas = array(
        'profile_categore'     => $_POST['profile-categore'],
        'profile_hash' => $_POST['profile-hash']
    );
    foreach($metas as $key => $value) {
        update_user_meta( $user_ID, $key, $value );
    }
    if(!empty($user_info->user_email) && !empty($user_info->first_name) && !empty($user_info->last_name) && !empty($user_info->display_name) && !empty($user_info->companyname) &&!empty($user_info->phone) && !empty($user_info->fax) && !empty($user_info->address) && !empty($user_info->country) && !empty($user_info->user_month) && !empty($user_info->user_date) && !empty($user_info->user_year) && !empty($user_info->user_gender) && !empty($user_info->description) && !empty($user_info->about_short) && !empty($user_info->web_site) && !empty($user_info->link_twitter) && !empty($user_info->link_facebook) && !empty($user_info->link_instagram) && !empty($user_info->text_left) && !empty($user_info->text_right) && !empty($user_info->paymentSurname) && !empty($user_info->paymentCompanyname) && !empty($user_info->paymentAddress) &&
      !empty($user_info->paymentCountry) && !empty($user_info->payment) && !empty($user_info->profile_categore) && !empty($user_info->profile_hash) && !empty($user_info->profileHeaderPic) &&
      !empty($user_info->profilePic) ){
        $status = true;

    } else {
        $status = false;
    }
    $timeProfile = $_POST['timeProfile'];
    if ($status == false) {
        $serverUrls = $_SERVER['SERVER_NAME']."/?p=".$postID;
        $wpdb->insert(
          'activities',
          array(
            'id_user' => $cur_user_id,
            'type_notifications' => 'profileAccount',
            'message' => "You have updated your <a href=\"/edit-profile/\">profile</a> information",
            'status' => 0,
            'data' => $timeProfile,
            'categories' => '',
            'hash_tag' => ''
          ),
          array( '%s', '%s' )
        );
    }
} else {
    header('location:' . $url[0] . '?status=required');
    exit;
}

header('location:' . $url[0] . '?status=ok');
exit;