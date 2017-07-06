<?php
$url = explode("?",$_SERVER['HTTP_REFERER']);

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );


if( !is_user_logged_in() ) exit;

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);

$user_ID = get_current_user_id();
$user = get_user_by( 'id', $user_ID );
$timeProfile = $_POST['timeProfile'];
if(!empty($_POST['visible_brand'])) {
    $visible = $_POST['visible_brand'];
} else {
    $visible = "visible";
}

if( $_POST['first_name'] && $_POST['last_name'] && is_email($_POST['user_email']) ) {

    // если пользователь указал новый емайл, а кто-то уже под ним зареган - отправляем на ошибку
    if( email_exists( $_POST['user_email'] ) && $_POST['user_email'] != $user->user_email ) {
        header('location:' . $url[0] . '?status=exist');
        exit;
    }

    wp_update_user( array(
        'ID' => $user_ID,
        'user_email'   => $_POST['user_email'],
        'first_name'   => $_POST['first_name'],
        'last_name'    => $_POST['last_name'],
        'display_name' => $_POST['first_name'] . ' ' . $_POST['last_name'] ));

    $metas = array(
        'companyname' => $_POST['companyname'],
        'phone'       => $_POST['phone'],
        'fax'         => $_POST['fax'],
        'address'     => $_POST['address'],
        'country'     => $_POST['country'],
        'user_month'  => $_POST['user_month'],
        'user_date'   => $_POST['user_date'],
        'user_year'   => $_POST['user_year'],
        'user_gender' => $_POST['user_gender'],
        'description' => $_POST['description'],
        'about_short' => $_POST['editor4'],
        'web_site' => $_POST['web-site'],
        'link_twitter' => $_POST['link-twitter'],
        'link_facebook' => $_POST['link-facebook'],
        'link_instagram' => $_POST['link-instagram'],
        'text_left' => $_POST['editor5'],
        'text_right' => $_POST['editor6'],
        'visible_brands'=> $visible
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
    // не все поля заполнены - перенеправляем
    header('location:' . $url[0] . '?status=required');
    exit;
}


// если выполнение кода дошло до сюда, то следовательно всё ок
header('location:' . $url[0] . '?status=ok');
exit;
