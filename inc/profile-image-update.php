<?php
$url = explode("?",$_SERVER['HTTP_REFERER']);

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );


if( !is_user_logged_in() ) exit;

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$user_ID = get_current_user_id();
$user = get_user_by( 'id', $user_ID );
$timeProfile = $_POST['timeProfile'];


if( wp_verify_nonce( $_POST['profilePicUpload'], 'profilePic' ) ){
    if ( ! function_exists( 'wp_handle_upload' ) )
        require_once( ABSPATH . 'wp-admin/includes/file.php' );

    $file = &$_FILES['profilePic'];
    $overrides = array( 'test_form' => false );
//    $delet_file = $user_info->profilePicFile;
    $movefile = wp_handle_upload( $file, $overrides );


    if ( $movefile ) {
//        print_r( $movefile );
        update_user_meta($user_ID, 'profilePic', $movefile['url']);
//        update_user_meta($user_ID, 'profilePicFile', $movefile[file]);

    } else {
        echo "Possible attack when you download the file!\n";
    }
}

if( wp_verify_nonce( $_POST['profileHeaderPicUpload'], 'profileHeaderPic' ) ) {
    if (!function_exists('wp_handle_upload'))
        require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['profileHeaderPic'];
    $overrides = array('test_form' => false);
//    $delet_file = $user_info->profileHeaderPicFile;
    $movefile = wp_handle_upload($file, $overrides);

    if ($movefile) {
//        unlink($delet_file);
        update_user_meta($user_ID, 'profileHeaderPic', $movefile['url']);
//        update_user_meta($user_ID, 'profileHeaderPicFile', $movefile['file']);
    } else {
        echo "Possible attack when you download the file!\n";
    }
}
if(!empty($user_info->user_email) && !empty($user_info->first_name) && !empty($user_info->last_name) && !empty($user_info->display_name) && !empty($user_info->companyname) &&!empty($user_info->phone) && !empty($user_info->fax) && !empty($user_info->address) && !empty($user_info->country) && !empty($user_info->user_month) && !empty($user_info->user_date) && !empty($user_info->user_year) && !empty($user_info->user_gender) && !empty($user_info->description) && !empty($user_info->about_short) && !empty($user_info->web_site) && !empty($user_info->link_twitter) && !empty($user_info->link_facebook) && !empty($user_info->link_instagram) && !empty($user_info->text_left) && !empty($user_info->text_right) && !empty($user_info->paymentSurname) && !empty($user_info->paymentCompanyname) && !empty($user_info->paymentAddress) &&
  !empty($user_info->paymentCountry) && !empty($user_info->payment) && !empty($user_info->profile_categore) && !empty($user_info->profile_hash) && !empty($user_info->profileHeaderPic) &&
  !empty($user_info->profilePic) ){
    $status = true;

} else {
    $status = false;
}
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
header('location:' . $url[0] . '?status=ok');
exit;