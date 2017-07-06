<?php
global $wpdb;
require_once( dirname(__FILE__) . '/../../../../../wp-load.php' );

$idDevPlace = filter_input(INPUT_POST, 'idDevPlace', FILTER_SANITIZE_NUMBER_INT);
$postIdPlace = filter_input(INPUT_POST, 'postIdPlace', FILTER_SANITIZE_NUMBER_INT);
$cur_user_id = filter_input(INPUT_POST, 'curIdPlace', FILTER_SANITIZE_NUMBER_INT);
$messageUser = filter_input(INPUT_POST, 'messageUser', FILTER_SANITIZE_SPECIAL_CHARS);
$id = get_current_user_id();

$timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone'])*60, 0);
$date=new DateTime("",new DateTimeZone($timezone));
$date=$date->format('Y-m-d H:i:s');

switch ($_GET['formSet']) {
    case 'price':
        $cpv = $_POST['cpv'];
        $bp = $_POST['bp'];
        $result = $wpdb->get_results("SELECT * FROM ps_price WHERE curIdPlace = $cur_user_id AND postIdPlace = $postIdPlace AND statusPrice = 0");
        if (count($result) <= 5) {


            $result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
            $id_brand = $result2[0]->id_brand;
            $id_dev = $result2[0]->id_dev;
            $resultDecline = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace  AND statusDecline = 1 ORDER BY id DESC LIMIT 1");
            if ($result2[0]->id_brand == $cur_user_id) {
                $wpdb->update(
                    'ps_price',
                    array(
                        'statusDecline' => 0
                    ),
                    array( 'ID' =>$resultDecline[0]->id )
                );

                $serverUrls = "/place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}";
                $user_info = get_userdata($id_brand);
                $compaign_title = $user_info->user_nicename;

                $wpdb->insert(
                    'activities',
                    array(
                        'id_user' => $id_dev,
                        'type_notifications' => 'stepPrice',
                        'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has made a new offer",
                        'status' => 0,
                        'data' => $date,
                        'categories' => '',
                        'hash_tag' => ''
                    ),
                    array('%s', '%s')
                );
            } elseif ($result2[0]->id_dev == $cur_user_id) {
                $wpdb->update(
                    'ps_price',
                    array(
                        'statusDecline' => 0
                    ),
                    array( 'ID' =>$resultDecline[0]->id )
                );
                $serverUrls = "/place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}";
                $user_info = get_userdata($id_dev);
                $compaign_title = $user_info->user_nicename;

                $wpdb->insert(
                    'activities',
                    array(
                        'id_user' => $id_brand,
                        'type_notifications' => 'stepPrice',
                        'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has made a new offer ",
                        'status' => 0,
                        'data' => $date,
                        'categories' => '',
                        'hash_tag' => ''
                    ),
                    array('%s', '%s')
                );
            }
            $wpdb->insert(
                'ps_price',
                array(
                    'cpv' => $cpv,
                    'bp' => $bp,
                    'postIdPlace' => $postIdPlace,
                    'idDevPlace' => $idDevPlace,
                    'curIdPlace' => $cur_user_id,
                    'statusPrice' => 0
                ),
                array('%s', '%f')
            );
            header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        } else {
            header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        }
        break;
    case 'approve':
        $result = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 0 ORDER BY id DESC LIMIT 1");

        $result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $result2[0]->id_brand;
        $id_dev = $result2[0]->id_dev;

        if ($result2[0]->id_brand == $cur_user_id) {
            if (!$statusBrand){
                $wpdb->insert(
                    'ps_price',
                    array(
                        'cpv' => $result[0]->cpv,
                        'bp' => $result[0]->bp,
                        'postIdPlace' => $postIdPlace,
                        'idDevPlace' => $idDevPlace,
                        'curIdPlace' => $cur_user_id,
                        'statusPrice' => 1
                    ),
                    array('%s', '%f')
                );
                $serverUrls = "/place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}";
                $user_info = get_userdata($id_brand);
                $compaign_title = $user_info->user_nicename;

                $wpdb->insert(
                    'activities',
                    array(
                        'id_user' => $id_dev,
                        'type_notifications' => 'stepPrice',
                        'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has accepted your offer",
                        'status' => 0,
                        'data' => $date,
                        'categories' => '',
                        'hash_tag' => ''
                    ),
                    array('%s', '%s')
                );
                $statusBrand = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 1 AND curIdPlace = $id_brand ORDER BY id DESC LIMIT 1");

                $statusDev = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 1 AND curIdPlace = $id_dev ORDER BY id DESC LIMIT 1");

                if ($statusBrand && $statusDev){
                    $post_data = array(
                        'ID'            => $postIdPlace,
                        'meta_input'    => array(
                            'cost_campaign'           => $result[0]->cpv,
                            'budget_number_campaign'  => $result[0]->bp
                        )
                    );
                    wp_update_post( $post_data );
                }
            }
            header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        } elseif ($result2[0]->id_dev == $cur_user_id) {
            $wpdb->insert(
                'ps_price',
                array(
                    'cpv' => $result[0]->cpv,
                    'bp' => $result[0]->bp,
                    'postIdPlace' => $postIdPlace,
                    'idDevPlace' => $idDevPlace,
                    'curIdPlace' => $cur_user_id,
                    'statusPrice' => 1
                ),
                array('%s', '%f')
            );

            $serverUrls = "/place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_info = get_userdata($id_dev);
            $compaign_title = $user_info->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_brand,
                    'type_notifications' => 'stepPrice',
                    'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has accepted your offer",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
            $statusBrand = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 1 AND curIdPlace = $id_brand ORDER BY id DESC LIMIT 1");

            $statusDev = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 1 AND curIdPlace = $id_dev ORDER BY id DESC LIMIT 1");

            if ($statusBrand && $statusDev){
                $post_data = array(
                    'ID'            => $postIdPlace,
                    'meta_input'    => array(
                        'cost_campaign'           => $result[0]->cpv,
                        'budget_number_campaign'  => $result[0]->bp
                    )
                );
                wp_update_post( $post_data );
            }
            header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        }
        break;
    case 'message':

        $result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $result2[0]->id_brand;
        $id_dev = $result2[0]->id_dev;

        $wpdb->insert(
            'ps_message',
            array(
                'id_post' => $postIdPlace,
                'id_dev' => $idDevPlace,
                'user_message_id' => $cur_user_id,
                'message' => $messageUser,
                'date' => $date
            ),
            array('%s', '%f')
        );
        $post_title = get_the_title( $postIdPlace );
        if ($result2[0]->id_brand == $cur_user_id) {

            $serverUrls = "/place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_info = get_userdata($id_dev);
            $compaign_title = $user_info->display_name;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_dev,
                    'type_notifications' => 'stepPrice',
                    'message' => "There are new messages for <a href=\"{$serverUrls}\">$post_title</a>",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        } elseif ($result2[0]->id_dev == $cur_user_id) {

            $serverUrls = "/place-step-second/?idDev={$idDevPlace}&pageId={$post_title}";
            $user_info = get_userdata($id_brand);
            $compaign_title = $user_info->display_name;
            
            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_brand,
                    'type_notifications' => 'stepPrice',
                    'message' => "There are new messages for <a href=\"{$serverUrls}\">$compaign_title</a>",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        }
        header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        break;

    case 'decline':
        $result = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 0 ORDER BY id DESC LIMIT 1");

        $result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $result2[0]->id_brand;
        $id_dev = $result2[0]->id_dev;

        if ($result2[0]->id_brand == $cur_user_id) {
                $wpdb->update(
                    'ps_price',
                    array(
                        'statusDecline' => 1
                    ),
                    array( 'ID' =>$result[0]->id )
                );
            $user_info = get_userdata($id_brand);
            $compaign_title = $user_info->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_dev,
                    'type_notifications' => 'stepPrice',
                    'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has declined your offer",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
               header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        } elseif ($result2[0]->id_dev == $cur_user_id) {
            $wpdb->update(
                'ps_price',
                array(
                    'statusDecline' => 1
                ),
                array( 'ID' => $result[0]->id )
            );
            $user_info = get_userdata($id_dev);
            $compaign_title = $user_info->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_brand,
                    'type_notifications' => 'stepPrice',
                    'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has declined your offer",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
            header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        }
        break;
}
