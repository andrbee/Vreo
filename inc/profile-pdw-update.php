<?php
$url = explode("?",$_SERVER['HTTP_REFERER']);

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );


if( !is_user_logged_in() ) exit;


$user_ID = get_current_user_id();
$user = get_user_by( 'id', $user_ID );


if( $_POST['pwd1'] || $_POST['pwd2'] || $_POST['pwd3'] ) {

    if( $_POST['pwd1'] && $_POST['pwd2'] && $_POST['pwd3'] ) {
        if( $_POST['pwd2'] == $_POST['pwd3'] ){
            if( strlen( $_POST['pwd2'] ) < 8 ) {
                header('location:' . $url[0] . '?status=short');
                exit;
            }
            if( wp_check_password( $_POST['pwd1'], $user->data->user_pass, $user->ID) ) {
                wp_set_password( $_POST['pwd2'], $user_ID );
                $creds['user_login'] = $user->user_login;
                $creds['user_password'] = $_POST['pwd2'];
                $creds['remember'] = true;
                $user = wp_signon( $creds, false );
            } else {
                header('location:' . $url[0] . '?status=wrong');
                exit;
            }
        } else {
            header('location:' . $url[0] . '?status=mismatch');
            exit;
        }

    } else {
        header('location:' . $url[0] . '?status=required');
        exit;
    }
}

header('location:' . $url[0] . '?status=ok');
exit;