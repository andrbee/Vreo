<?php
require_once(dirname(__FILE__) . '/../../../../wp-load.php');
$plMessage = null;
global $wpdb;
require TEMPLATEPATH . '/vendor/autoload.php';
$config = require TEMPLATEPATH . '/inc/config.php';
use Aws\S3\S3Client;
$cur_user_id=get_current_user_id();
$user_info=get_userdata($cur_user_id);
$role=$user_info->roles;
$role=$role[0];
$timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone']) * 60, 0);
$date = new DateTime("", new DateTimeZone($timezone));
$date = $date->format('Y-m-d H:i:s');

// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);


if (isset($_FILES['placeBrandVideo'])) {
    if (0 == $_FILES['placeBrandVideo']['error']) {

        if (!empty($_POST['postIdPlace'])) {
            $postIdPlace = $_POST['postIdPlace'];
        } else {
            $postIdPlace = null;
        }
        $resultID = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");
        $id_brand = $resultID[0]->id_brand;
        $user_info=get_userdata($id_brand);

        if (!empty($_POST['idDevPlace'])) {
            $user_info = get_userdata($id_brand);
            $idDevPlace = $_POST['idDevPlace'];
        } else {
            $user_info = null;
        }
//        print_r($_POST);

        $tmpFile = $_FILES['placeBrandVideo']['tmp_name'];
        $FileSize = $_FILES['placeBrandVideo']['size'];
        $tmpFileName = $_FILES['placeBrandVideo']['name'];
        $extTmpFileName = new SplFileInfo($tmpFileName);
        $extTmpFileName = $extTmpFileName->getExtension();
        $newFileName = md5(uniqid());
        $newFileName .= "." . $extTmpFileName;
        $compaign_title = explode("/", get_post_meta($_POST['postIdPlace'], 'amazon-path', true));//берем название папки такое
        // же как у рекл. кампании девелопера, так будет проще искать папки на амазон

        $compaign_title = $compaign_title[3];
        $fileType = explode('/', $_FILES['placeBrandVideo']['type']);

        $Path = "Brands/".$user_info->nickname."/CampaignsPlaced/" . $compaign_title . "/";


        $path .= $nameFile;
        $urlFile .= $nameFile;

        switch ($fileType[0]) {
            case 'image' :
                $idTypeMedia = 1;
                $msgType = 'image';
                break;
            case 'audio' :
                $idTypeMedia = 3;
                $msgType = 'audio';
                break;
            case 'video' :
                $idTypeMedia = 2;
                $msgType = 'video';
                break;
            default:
                echo 'Not format media type.';
        }

        $findeRes = $wpdb->get_results("SELECT * FROM pl_get_random_advertiser WHERE developer_id = $idDevPlace AND developer_game_id = $postIdPlace AND type_media_id = $idTypeMedia AND advertiser_ad_id = $cur_user_id ");

        $res = false;
        try {
            $params = [
                'Bucket' => $config['s3']['bucket'],
                'Key' => $Path . $newFileName,
                'Body' => fopen($tmpFile, "rb"),
                'ACL' => 'public-read'
            ];

            $result = $s3->putObject($params);
            if ($s3->doesObjectExist($config['s3']['bucket'], $Path . $newFileName)) {
                $res = true;
            }

        } catch (S3_Exception $message) {
            die($message);
        }
        if (is_bool($res)) {
            $cur_user_id = get_current_user_id();
            $wpdb->insert(
                'pl_step_files',
                array(
                    'id_dev' => $idDevPlace,
                    'id_brand' => $id_brand,
                    'id_post' => $resultID[0]->id_campaign,
                    'url_file' => $Path . $newFileName,
                    'path_file' => $newFileName,
                    'typeFormat' => $idTypeMedia,
                    'approve' => 0,
                    'file_size' => $FileSize,
                    "approve_brand"=>0
                ),
                array('%s', '%s')
            );

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
                        'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has uploaded a new ad",
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
                        'message' => "<a href=\"{$serverUrls}\">$compaign_title</a> has uploaded a new ad",
                        'status' => 0,
                        'data' => $date,
                        'categories' => '',
                        'hash_tag' => ''
                    ),
                    array('%s', '%s')
                );
            }
            header("location: /place-third-step/?idDev={$idDevPlace}&pageId={$postIdPlace}");
        }


    } else {
        $plMessage = 'Error! You did not select a file!';
    }
}