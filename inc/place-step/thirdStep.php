<?php
global $wpdb;
require_once(dirname(__FILE__) . '/../../../../../wp-load.php');
$config = require TEMPLATEPATH . '/inc/config.php';
$idDevPlace = filter_input(INPUT_POST, 'idDevPlace', FILTER_SANITIZE_NUMBER_INT);
$postIdPlace = filter_input(INPUT_POST, 'postIdPlace', FILTER_SANITIZE_NUMBER_INT);
$cur_user_id = filter_input(INPUT_POST, 'curIdPlace', FILTER_SANITIZE_NUMBER_INT);
$messageUser = filter_input(INPUT_POST, 'messageUser', FILTER_SANITIZE_SPECIAL_CHARS);
$id = get_current_user_id();

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$role = $user_info->roles;
$role = $role[0];

$timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone']) * 60, 0);
$date = new DateTime("", new DateTimeZone($timezone));
$date = $date->format('Y-m-d H:i:s');
$result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
$id_brand = $result2[0]->id_brand;
$id_dev = $result2[0]->id_dev;


switch ($_GET['formSet']) {
    case 'message':
        $result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $result2[0]->id_brand;
        $id_dev = $result2[0]->id_dev;
        $post_title = get_the_title( $postIdPlace );
        $wpdb->insert(
            'ps_message_finish',
            array(
                'id_post' => $postIdPlace,
                'id_dev' => $idDevPlace,
                'user_message_id' => $cur_user_id,
                'message' => $messageUser,
                'date' => $date
            ),
            array('%s', '%f')
        );

        if ($result2[0]->id_brand == $cur_user_id) {

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
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

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_info = get_userdata($id_brand);
            $compaign_title = $user_info->display_name;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_brand,
                    'type_notifications' => 'stepPrice',
                    'message' => "There are new messages for <a href=\"{$serverUrls}\">$post_title</a>",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        }
        header("location: /place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}");

        break;
    case 'delete':

        $idFile = $_POST['delet'];
        $resultSt = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $resultSt[0]->id_brand;
        $id_dev = $resultSt[0]->id_dev;
        $user_brand = get_userdata($id_brand);
        $path = __DIR__ . '/../../../uploads/' . $user_brand->user_login . '/';
        $resultID = $wpdb->get_results("SELECT * FROM pl_step_files WHERE id = $idFile");

        $del = unlink(__DIR__ . '/../../../../uploads/' . $user_brand->user_login . '/' . $resultID[0]->path_file);

        if ($del) {
            $wpdb->delete('pl_step_files',
                array('id' => $idFile, 'id_post' => $postIdPlace)
            );
        }

        if ($result2[0]->id_brand == $cur_user_id) {

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_dev = get_userdata($id_dev);
            $compaign_title = $user_dev->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_dev,
                    'type_notifications' => 'stepPrice',
                    'message' => "Step 3 -> <a href=\"{$serverUrls}\">$compaign_title</a> <-  Brand delet file",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        } elseif ($result2[0]->id_dev == $cur_user_id) {

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_brand = get_userdata($id_brand);
            $compaign_title = $user_brand->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_brand,
                    'type_notifications' => 'stepPrice',
                    'message' => "Step 3 -> <a href=\"{$serverUrls}\">$compaign_title</a> <-  Developer delete file",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        }

        header("location: /place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        break;
    case 'approve':

        $idFile = $_POST['approveId'];

        $resultID = $wpdb->get_results("SELECT * FROM pl_step_files WHERE id = $idFile id_post = $postIdPlace");

        if ($role == 'brand') {
            $wpdb->update('pl_step_files',
                array('approve_brand' => 1),
                array('ID' => $idFile)
            );
        } else {

            $wpdb->update('pl_step_files',
                array('approve' => 1),
                array('ID' => $idFile)
            );
        }

        $result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $result2[0]->id_brand;
        $id_dev = $result2[0]->id_dev;


        if ($result2[0]->id_brand == $cur_user_id) {

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_dev = get_userdata($id_dev);
            $compaign_title = $user_dev->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_dev,
                    'type_notifications' => 'stepPrice',
                    'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has accepted an ad",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        } elseif ($result2[0]->id_dev == $cur_user_id) {

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_brand = get_userdata($id_brand);
            $compaign_title = $user_brand->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_brand,
                    'type_notifications' => 'stepPrice',
                    'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has accepted an ad",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        }
        header("location: /place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        break;
    case 'decline':

        $idFile = $_POST['approveId'];

        $resultID = $wpdb->get_results("SELECT * FROM pl_step_files WHERE id = $idFile id_post = $postIdPlace");
        if ($role == 'brand') {
            $wpdb->update('pl_step_files',
                array('approve_brand' => -1),
                array('ID' => $idFile)
            );
        } else {

            $wpdb->update('pl_step_files',
                array('approve' => -1),
                array('ID' => $idFile)
            );
        }
        $result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $result2[0]->id_brand;
        $id_dev = $result2[0]->id_dev;


        if ($result2[0]->id_brand == $cur_user_id) {

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_dev = get_userdata($id_dev);
            $compaign_title = $user_dev->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_dev,
                    'type_notifications' => 'stepPrice',
                    'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has declined an ad",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        } elseif ($result2[0]->id_dev == $cur_user_id) {

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_brand = get_userdata($id_brand);
            $compaign_title = $user_brand->user_nicename;

            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $id_brand,
                    'type_notifications' => 'stepPrice',
                    'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has declined an ad",
                    'status' => 0,
                    'data' => $date,
                    'categories' => '',
                    'hash_tag' => ''
                ),
                array('%s', '%s')
            );
        }
        header("location: /place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        break;
    case 'finish':
        $result2 = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $result2[0]->id_brand;
        $id_dev = $result2[0]->id_dev;

        if ($result2[0]->id_brand == $cur_user_id) {
            if (!$statusBrand) {
                $wpdb->insert(
                    'ps_finish',
                    array(
                        'postIdPlace' => $postIdPlace,
                        'idDevPlace' => $idDevPlace,
                        'curIdPlace' => $cur_user_id,
                        'status' => 1
                    ),
                    array('%s', '%f')
                );
                $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
                $user_info = get_userdata($id_brand);
                $compaign_title = $user_info->display_name;


                $statusBrand = $wpdb->get_results("SELECT * FROM ps_finish WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND status = 1 AND curIdPlace = $id_brand ORDER BY id DESC LIMIT 1");

                $statusDev = $wpdb->get_results("SELECT * FROM ps_finish WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND status = 1 AND curIdPlace = $id_dev ORDER BY id DESC LIMIT 1");

                if ($statusBrand && $statusDev) {
                    $resultStep = $wpdb->get_results("SELECT * FROM pl_step_files WHERE id_dev = $idDevPlace AND id_post = $postIdPlace AND approve = 1 AND approve_brand = 1");
                    $wpdb->insert(
                        'activities',
                        array(
                            'id_user' => $id_dev,
                            'type_notifications' => 'stepPrice',
                            'message' => "Your campaign is running and the ad will be shown soon.",
                            'status' => 0,
                            'data' => $date,
                            'categories' => '',
                            'hash_tag' => ''
                        ),
                        array('%s', '%s')
                    );
                    $wpdb->insert(
                        'activities',
                        array(
                            'id_user' => $id_brand,
                            'type_notifications' => 'stepPrice',
                            'message' => "Your campaign is running and the ad will be shown soon.",
                            'status' => 0,
                            'data' => $date,
                            'categories' => '',
                            'hash_tag' => ''
                        ),
                        array('%s', '%s')
                    );
                    foreach ($resultStep as $key => $value) {
                        $user_inf = get_userdata($id_brand);
                        $user_key = get_userdata($resultStep[$key]->id_dev);
                        $wpdb->insert(
                            'pl_get_random_advertiser',
                            array(
                                'developer_id' => $resultStep[$key]->id_dev,
                                'developer_access_token' => $user_key->token_id,
                                'developer_game_id' => $resultStep[$key]->id_post,
                                'type_media_id' => $resultStep[$key]->typeFormat,
                                'advertiser_ad_id' => $id_brand,
                                'media_url' => $config['s3']['cdnPath']."/".$resultStep[$key]->url_file
                            ),
                            array('%s', '%s')
                        );

                    }
                    $post_data = array(
                        'ID' => $postIdPlace,
                        'post_status' => 'completed',
                        'post_type' => 'post'
                    );
                    wp_update_post($post_data);

                }
            }
            header("location: /analytics/");
        } elseif ($result2[0]->id_dev == $cur_user_id) {
            $wpdb->insert(
                'ps_finish',
                array(
                    'postIdPlace' => $postIdPlace,
                    'idDevPlace' => $idDevPlace,
                    'curIdPlace' => $cur_user_id,
                    'status' => 1
                ),
                array('%s', '%f')
            );

            $serverUrls = "/place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}";
            $user_info = get_userdata($id_dev);
            $compaign_title = $user_info->display_name;

            $statusBrand = $wpdb->get_results("SELECT * FROM ps_finish WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND status = 1 AND curIdPlace = $id_brand ORDER BY id DESC LIMIT 1");

            $statusDev = $wpdb->get_results("SELECT * FROM ps_finish WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND status = 1 AND curIdPlace = $id_dev ORDER BY id DESC LIMIT 1");

            if ($statusBrand && $statusDev) {
                $wpdb->insert(
                    'activities',
                    array(
                        'id_user' => $id_dev,
                        'type_notifications' => 'stepPrice',
                        'message' => "Your campaign is running and the ad will be shown soon.",
                        'status' => 0,
                        'data' => $date,
                        'categories' => '',
                        'hash_tag' => ''
                    ),
                    array('%s', '%s')
                );
                $wpdb->insert(
                    'activities',
                    array(
                        'id_user' => $id_brand,
                        'type_notifications' => 'stepPrice',
                        'message' => "Your campaign is running and the ad will be shown soon.",
                        'status' => 0,
                        'data' => $date,
                        'categories' => '',
                        'hash_tag' => ''
                    ),
                    array('%s', '%s')
                );
                $resultStep = $wpdb->get_results("SELECT * FROM pl_step_files WHERE id_dev = $idDevPlace AND id_post = $postIdPlace AND approve = 1 AND approve_brand = 1");
                foreach ($resultStep as $key => $value) {
                    $user_inf = get_userdata($id_brand);
                    $user_key = get_userdata($resultStep[$key]->id_dev);
                    $wpdb->insert(
                        'pl_get_random_advertiser',
                        array(
                            'developer_id' => $resultStep[$key]->id_dev,
                            'developer_access_token' => $user_key->token_id,
                            'developer_game_id' => $resultStep[$key]->id_post,
                            'type_media_id' => $resultStep[$key]->typeFormat,
                            'advertiser_ad_id' => $id_brand,
                            'media_url' => $config['s3']['cdnPath']."/".$resultStep[$key]->url_file
                        ),
                        array('%s', '%s')
                    );

                }
                $post_data = array(
                    'ID' => $postIdPlace,
                    'post_status' => 'completed',
                    'post_type' => 'post'
                );
                wp_update_post($post_data);
            }
            header("location: /edit-campaign/");
        }
        break;
}
