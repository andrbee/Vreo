<?php
$url = explode("?", $_SERVER['HTTP_REFERER']);

require_once(dirname(__FILE__) . '/../../../../wp-load.php');

if (!is_user_logged_in()) exit;

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$user_ID = get_current_user_id();
$user = get_user_by('id', $user_ID);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//echo "<pre>";
//print_r($_GET);
//echo "</pre>";
//exit;
$compaign_title = $_POST['compaign_title'];
$campaign_hash = $_POST['campaign-hash'];
$campaign_description = $_POST['campaign-description'];
$editor1 = $_POST['editor1'];
$campaign_yt_title = $_POST['campaign-yt-title'];
$campaign_yt_url = $_POST['campaign-yt-url'];
$campaign_desc_addition = $_POST['campaign-desc-addition'];
$editor2 = $_POST['editor2'];
$campaign_categs = $_POST['campaign-categ'];
$cost_campaign = $_POST['cost-campaign'];
$pic_number_campaign = $_POST['pic-number-campaign'];
$video_number_campaign = $_POST['video-number-campaign'];
$budget_number_campaign = $_POST['budget-number-campaign'];
$campaignPlatform = $_POST['campaignPlatform'];
$sliderTitle = $_POST['slider-title'];
$postID = $_POST['numberIdPost'];
$timePublish = $_POST['timePublish'];
$countriesCampaign = $_POST['countriesNewCampaign'];
$campaignSlider=array(); //будущий массив метаполя картинок слайдера который будет записываться в wordpress
$sliderCampaign = $_POST['slider'];
//echo "<pre>";
//print_r($sliderCampaign);
//echo "</pre>";
//exit;
$paymentCompanyname = str_replace(" ", "", $user_info->user_email);
$pathSliderServer = $pathSliderServer =$_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/".$paymentCompanyname."/slider/".$postID."/";

//if (!empty($sliderCampaign && file_exists($pathSliderServer))){
//    foreach ($sliderCampaign as $files) {
//        if(file_exists($pathSliderServer.$files['name'])){
//            echo $files['name']."<br>";
//        }
//    }
//}
//exit;


require '../vendor/autoload.php';
$config = require '../inc/config.php';

// Include the AWS SDK using the Composer autoloader.

if (in_array('developer', $user_info->roles)) {
    $rolePath = 'Developers';
} elseif (in_array('brand', $user_info->roles)) {
    $rolePath = 'Brands';
} else {
    $rolePath = 'Guests';
}
$rolePath .= "/";
$postFix=md5(uniqid());
$Path = $rolePath . $user_info->nickname . "/Campaigns/{$compaign_title}__{$postFix}/uploads/";
$amazon_path=$Path;
use Aws\S3\S3Client;


// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);
$profile_use_disk_space=0;
$objects = $s3->getIterator('ListObjects', array(
    'Bucket' => $config['s3']['bucket'],
    'Prefix' => $rolePath . $user_info->nickname
));
foreach ($objects as $object) {
    $profile_use_disk_space += $object['Size'];
}

$max_disk_space=524288000;
//$max_one_campaign_space=104857600; // 100 mb
$max_one_campaign_space=524288000; // 500 mb
if(!empty($_FILES)) {
    $files=$_FILES;
    $size=0;
    foreach ($files as $file){
        if($file['error']==0) {
            $size += $file['size'];
        }
    }
    if (!empty($sliderCampaign && file_exists($pathSliderServer))){
        foreach ($sliderCampaign as $files) {
            if(file_exists($pathSliderServer.$files['name'])){
                $size+=$files['size'];
            }
        }
    }
    if($size>$max_one_campaign_space){
        global $wpdb;

        $timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone'])*60, 0);
        $date=new DateTime("",new DateTimeZone($timezone));
        $date=$date->format('Y-m-d H:i:s');
        $wpdb->insert(
            'activities',
            array(
                'id_user' => $cur_user_id,
                'type_notifications' => 'adminMessageAll',
                'message' => "The maximum amount of space for one company is 500 mb",
                'status' => 0,
                'data' => $date,
                'categories' => '',
                'hash_tag' => ''
            ),
            array('%s', '%s')
        );
        header('location: /activities/');
        exit;
    }
    if(($size+$profile_use_disk_space)>$max_disk_space){ // если занятн. место профилем + новое которое хочет занять больше чем 500 mb, выдает уведомление с редиректом
        global $wpdb;

        $timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone'])*60, 0);
        $date=new DateTime("",new DateTimeZone($timezone));
        $date=$date->format('Y-m-d H:i:s');
        $wpdb->insert(
            'activities',
            array(
                'id_user' => $cur_user_id,
                'type_notifications' => 'adminMessageAll',
                'message' => "You do not have enough space to create a new company",
                'status' => 0,
                'data' => $date,
                'categories' => '',
                'hash_tag' => ''
            ),
            array('%s', '%s')
        );
        header('location: /activities/');
        exit;
    }
//    echo "<pre>";
//    print_r($files);

//    exit;
}
if(isset($_FILES['campaign_video']) and $_FILES['campaign_video']['error']==0){
    if (!function_exists('wp_handle_upload'))
        require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['campaign_video'];

    $name = $file['name']; // имя файла

    $overrides = array('test_form' => false);
    //    $delet_file = $user_info->profilePicFile;
    $movefile = wp_handle_upload($file, $overrides);


    if ($movefile) {
        try {
            $params = [
                'Bucket' => $config['s3']['bucket'],
                'Key' => $Path . $name,
                'Body' => fopen($movefile['file'], "rb"),
                'ACL' => 'public-read'
            ];

            $result = $s3->putObject($params);

            unlink($movefile['file']);
            $campaign_video = $result['ObjectURL'];
            $campaign_video_key = $Path . $name;

        } catch (S3_Exception $message) {
        } catch (S3_Exception $message) {
            die($message);
        }

        //        print_r( $movefile );
        //        update_user_meta($user_ID, 'campaign_bg', $movefile['url']);
//        header('location:' . $url[0] . '?status=campaign-bg');
        //        update_user_meta($user_ID, 'profilePicFile', $movefile[file]);

    } else {
//        header('location:' . $url[0] . '?status=campaign-bg-error');
        echo "Possible attack when you download the file!\n";
    }
}
if (wp_verify_nonce($_POST['campaign-bg-header-Upload'], 'campaign-bg-header')and $_FILES['campaign-bg-header']['error']==0) {
    if (!function_exists('wp_handle_upload'))
        require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['campaign-bg-header'];

    $name = $file['name']; // имя файла

    $overrides = array('test_form' => false);
    //    $delet_file = $user_info->profilePicFile;
    $movefile = wp_handle_upload($file, $overrides);


    if ($movefile) {
        try {
            $params = [
                'Bucket' => $config['s3']['bucket'],
                'Key' => $Path . $name,
                'Body' => fopen($movefile['file'], "rb"),
                'ACL' => 'public-read'
            ];

            $result = $s3->putObject($params);

            unlink($movefile['file']);
            $campaign_bg_header = $result['ObjectURL'];
            $campaign_bg_header_file = $Path . $name;
        } catch (S3_Exception $message) {
            die($message);
        }

        //        print_r( $movefile );
        //        update_user_meta($user_ID, 'campaign_bg', $movefile['url']);
//        header('location:' . $url[0] . '?status=campaign-bg');
        //        update_user_meta($user_ID, 'profilePicFile', $movefile[file]);

    } else {
//        header('location:' . $url[0] . '?status=campaign-bg-error');
        echo "Possible attack when you download the file!\n";
    }
}
if (wp_verify_nonce($_POST['campaign-age-Upload'], 'campaign-age') and $_FILES['campaign-age']['error']==0) {
    if (!function_exists('wp_handle_upload'))
        require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['campaign-age'];
    $name = $file['name']; // имя файла
    $overrides = array('test_form' => false);
    //    $delet_file = $user_info->profilePicFile;
    $movefile = wp_handle_upload($file, $overrides);

    if ($movefile) {
        try {
            $params = [
                'Bucket' => $config['s3']['bucket'],
                'Key' => $Path . $name,
                'Body' => fopen($movefile['file'], "rb"),
                'ACL' => 'public-read'
            ];

            $result = $s3->putObject($params);
            unlink($movefile['file']);

            $campaign_age = $result['ObjectURL'];
            $campaign_age_file = $Path . $name;
        } catch (S3_Exception $message) {
            die($message);
        }

        //        print_r( $movefile );
        //        update_user_meta($user_ID, 'campaign_bg', $movefile['url']);
//        header('location:' . $url[0] . '?status=campaign-bg');
        //        update_user_meta($user_ID, 'profilePicFile', $movefile[file]);

    } else {
//        header('location:' . $url[0] . '?status=campaign-bg-error');
        echo "Possible attack when you download the file!\n";
    }
}
if (wp_verify_nonce($_POST['campaign-image-Upload'], 'campaign-image') and $_FILES['campaign-image']['error']==0) {
    if (!function_exists('wp_handle_upload'))
        require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['campaign-image'];
    $name = $file['name']; // имя файла
    $overrides = array('test_form' => false);
    //    $delet_file = $user_info->profilePicFile;
    $movefile = wp_handle_upload($file, $overrides);

    if ($movefile) {
        try {
            $params = [
                'Bucket' => $config['s3']['bucket'],
                'Key' => $Path . $name,
                'Body' => fopen($movefile['file'], "rb"),
                'ACL' => 'public-read'
            ];

            $result = $s3->putObject($params);
            unlink($movefile['file']);

            $campaign_image = $result['ObjectURL'];
            $campaign_image_file = $Path . $name;
        } catch (S3_Exception $message) {
            die($message);
        }

        //        print_r( $movefile );
        //        update_user_meta($user_ID, 'campaign_bg', $movefile['url']);
//        header('location:' . $url[0] . '?status=campaign-bg');
        //        update_user_meta($user_ID, 'profilePicFile', $movefile[file]);

    } else {
//        header('location:' . $url[0] . '?status=campaign-bg-error');
        echo "Possible attack when you download the file!\n";
    }


}
if (wp_verify_nonce($_POST['campaign-bg-Upload'], 'campaign-bg') and $_FILES['campaign-bg']['error']==0) {
    if (!function_exists('wp_handle_upload'))
        require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['campaign-bg'];
    $name = $file['name']; // имя файла
    $overrides = array('test_form' => false);
    //    $delet_file = $user_info->profilePicFile;
    $movefile = wp_handle_upload($file, $overrides);
    if ($movefile) {
        try {
            $params = [
                'Bucket' => $config['s3']['bucket'],
                'Key' => $Path . $name,
                'Body' => fopen($movefile['file'], "rb"),
                'ACL' => 'public-read'
            ];

            $result = $s3->putObject($params);
            unlink($movefile['file']);

            $campaign_bg = $result['ObjectURL'];
            $campaign_bg_file = $Path . $name;
        } catch (S3_Exception $message) {
            die($message);
        }

        //        print_r( $movefile );
        //        update_user_meta($user_ID, 'campaign_bg', $movefile['url']);
//        header('location:' . $url[0] . '?status=campaign-bg');
        //        update_user_meta($user_ID, 'profilePicFile', $movefile[file]);

    } else {
//        header('location:' . $url[0] . '?status=campaign-bg-error');
        echo "Possible attack when you download the file!\n";
    }


}
if (!empty($sliderCampaign && file_exists($pathSliderServer))){
    foreach ($sliderCampaign as $files) {
        if(file_exists($pathSliderServer.$files['name'])){
            $name=$files['name'];
            try {
                $params = [
                    'Bucket' => $config['s3']['bucket'],
                    'Key' => $Path . "slider/" . $name,
                    'Body' => fopen($pathSliderServer.$files['name'], "rb"),
                    'ACL' => 'public-read'
                ];

                $result = $s3->putObject($params);
                unlink($pathSliderServer.$files['name']);

                $campaignSlider[]=$Path . "slider/" . $name;
            } catch (S3_Exception $message) {
                die($message);
            }

        }
    }
//    if(!disk_total_space($pathSliderServer)>(float)0){unlink($pathSliderServer);}
//    echo "<script>console.log('".disk_free_space($pathSliderServer)."');</script>";
    rmdir($pathSliderServer);
}
if (wp_verify_nonce($_POST['placeholder-plugin-Upload'], 'placeholder-plugin') and $_FILES['placeholder-plugin']['error']==0) {
    if (!function_exists('wp_handle_upload'))
        require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['placeholder-plugin'];
    $name = $file['name']; // имя файла
    $overrides = array('test_form' => false);
    $movefile = wp_handle_upload($file, $overrides);
    if ($movefile) {
        try {
            $params = [
                'Bucket' => $config['s3']['bucket'],
                'Key'    => $Path . $name,
                'Body'   => fopen($movefile['file'], "rb"),
                'ACL'    => 'public-read'
            ];

            $result = $s3->putObject($params);
            unlink($movefile['file']);

            $placeholder_plugin = $result['ObjectURL'];
            $placeholder_plugin_file = $Path . $name;
        } catch (S3_Exception $message) {
            die($message);
        }
    } else {
        echo "Possible attack when you download the file!\n";
    }
}

switch ($_POST['active']) {
    case 'publish': {
        $post_data = array(
            'post_title' => wp_strip_all_tags($compaign_title),
            'post_content' => $campaign_description,
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_author' => $user_ID,
            'tags_input' => $campaign_hash,
            'post_category' => $campaign_categs,
            'meta_input' => array(
                'campaign_editor_1'         => $editor1,
                'campaign_editor_2'         => $editor2,
                'amazon-path'               =>$amazon_path,
                'campaign_video'            =>$campaign_video,
                'campaign_video_key'        =>$campaign_video_key,
                'campaign_yt_title'         => $campaign_yt_title,
                'campaign_yt_url'           => $campaign_yt_url,
                'campaign_bg'               => $campaign_bg,
                'campaign_bg_file'          => $campaign_bg_file,
                'campaign_image'            => $campaign_image,
                'campaign_image_file'       => $campaign_image_file,
                'campaign_age'              => $campaign_age,
                'campaign_age_file'         => $campaign_age_file,
                'campaign_bg_header'        => $campaign_bg_header,
                'campaign_bg_header_file'   => $campaign_bg_header_file,
                'campaign_desc_addition'    => $campaign_desc_addition,
                'cost_campaign'             => $cost_campaign,
                'pic_number_campaign'       => $pic_number_campaign,
                'video_number_campaign'     => $video_number_campaign,
                'budget_number_campaign'    => $budget_number_campaign,
                'campaign_platform'         => $campaignPlatform,
                'slider_title'              => $sliderTitle,
                'campaignSlider'            => $campaignSlider,
                'campaign_countries'        => $countriesCampaign,
                'placeholder_plugin'       => $placeholder_plugin,
                'placeholder_plugin_file'       => $placeholder_plugin_file
            )
        );
        $post_id = wp_insert_post($post_data);
        $tags = (array)get_terms(array('taxonomy' => 'post_tag'));
        $tags_name = array();
        foreach ($tags as $tag) {
            $tags_name[] = $tag->slug;
        }
        $json_file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/metronic/assets/json/colors.json", true);
        $colors = json_decode($json_file, true);
        $i = 0;
        $colors_sort = array();
        foreach ($colors as $k => $value) {
            $colors_sort[$i] = $k;
            $i++;
        }
        $count_colors = count($colors_sort) - 1;
        global $wpdb;
        $colors_tags_db = $wpdb->get_results("SELECT name_tag FROM colors_tags");
        $tags_db = array();

        foreach ($colors_tags_db as $cl_tg) {
            $tags_db[] = $cl_tg->name_tag;
        }
//                                print_r($colors_tags_db);
        $result = array_diff($tags_name, $tags_db);
//        print_r($result);

        if (!empty($result)) {
            foreach ($result as $res) {
                $class_color = rand(0, $count_colors);
                $wpdb->insert(
                    'colors_tags',
                    array('name_tag' => $res, 'color_tag' => $colors_sort[$class_color]),
                    array('%s', '%s'));
            }
        }

        $cCategs = implode(",", $campaign_categs);
        $chash = implode(",", $campaign_hash);
        $serverUrls = $_SERVER['SERVER_NAME'] . "/?p=" . $postID;

        $argsUser = array('role__not_in' => 'administrator');
        $masUser = get_users($argsUser);
        $colUser = 0;
        foreach ($masUser as $item) {
            $bdUserKey[$colUser] = $item->ID;
            $colUser++;
        }
        for ($i = 0; $i < count($bdUserKey); $i++) {
            if ($bdUserKey[$i] == $cur_user_id) {
                $wpdb->insert(
                    'activities',
                    array(
                        'id_user' => $bdUserKey[$i],
                        'type_notifications' => 'newCampaign',
                        'message' => "The new campaign -> <a href=\"{$serverUrls}\">$compaign_title</a> <- is a match for you",
                        'status' => 1,
                        'data' => $timePublish,
                        'categories' => $cCategs,
                        'hash_tag' => $chash
                    ),
                    array('%s', '%s')
                );

            } else {
                $wpdb->insert(
                    'activities',
                    array(
                        'id_user' => $bdUserKey[$i],
                        'type_notifications' => 'newCampaign',
                        'message' => "The new campaign -> <a href=\"{$serverUrls}\">$compaign_title</a> <- is a match for you",
                        'status' => 0,
                        'data' => $timePublish,
                        'categories' => $cCategs,
                        'hash_tag' => $chash
                    ),
                    array('%s', '%s')
                );
            }

        }
        $argsNewCamp = get_user_meta($cur_user_id, 'follow_id', false);
        for ($i = 0; $i < count($argsNewCamp); $i++) {
            $wpdb->insert(
                'activities',
                array(
                    'id_user' => $argsNewCamp[$i],
                    'type_notifications' => 'newCampaignFollow',
                    'message' => "The new campaign -> <a href=\"{$serverUrls}\">$compaign_title</a> <- is a match for you",
                    'status' => 0,
                    'data' => $timePublish,
                    'categories' => $cCategs,
                    'hash_tag' => $chash
                ),
                array('%s', '%s')
            );

        }
        header('location: /category/marketplace/');
        break;
    }
    case 'save': {
        $post_data = array(
            'post_title' => wp_strip_all_tags($compaign_title),
            'post_content' => $campaign_description,
            'post_status' => 'draft',
            'post_type' => 'post',
            'post_author' => $user_ID,
            'tags_input' => $campaign_hash,
            'post_category' => $campaign_categs,
            'meta_input' => array(
                'campaign_editor_1'         => $editor1,
                'campaign_editor_2'         => $editor2,
                'amazon-path'               =>$amazon_path,
                'campaign_video'            =>$campaign_video,
                'campaign_video_key'        =>$campaign_video_key,
                'campaign_yt_title'         => $campaign_yt_title,
                'campaign_yt_url'           => $campaign_yt_url,
                'campaign_bg'               => $campaign_bg,
                'campaign_bg_file'          => $campaign_bg_file,
                'campaign_image'            => $campaign_image,
                'campaign_image_file'       => $campaign_image_file,
                'campaign_age'              => $campaign_age,
                'campaign_age_file'         => $campaign_age_file,
                'campaign_bg_header'        => $campaign_bg_header,
                'campaign_bg_header_file'   => $campaign_bg_header_file,
                'campaign_desc_addition'    => $campaign_desc_addition,
                'cost_campaign'             => $cost_campaign,
                'pic_number_campaign'       => $pic_number_campaign,
                'video_number_campaign'     => $video_number_campaign,
                'budget_number_campaign'    => $budget_number_campaign,
                'campaign_platform'         => $campaignPlatform,
                'slider_title'              => $sliderTitle,
                'campaignSlider'            => $campaignSlider,
                'campaign_countries'        => $countriesCampaign,
                'placeholder_plugin'       => $placeholder_plugin,
                'placeholder_plugin_file'       => $placeholder_plugin_file

            )
        );

        $post_id = wp_insert_post($post_data);
        $tags = (array)get_terms(array('taxonomy' => 'post_tag'));
        $tags_name = array();
        foreach ($tags as $tag) {
            $tags_name[] = $tag->slug;
        }
        $json_file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/metronic/assets/json/colors.json", true);
        $colors = json_decode($json_file, true);
        $i = 0;
        $colors_sort = array();
        foreach ($colors as $k => $value) {
            $colors_sort[$i] = $k;
            $i++;
        }
        $count_colors = count($colors_sort) - 1;
        global $wpdb;
        $colors_tags_db = $wpdb->get_results("SELECT name_tag FROM colors_tags");
        $tags_db = array();

        foreach ($colors_tags_db as $cl_tg) {
            $tags_db[] = $cl_tg->name_tag;
        }
//                                print_r($colors_tags_db);
        $result = array_diff($tags_name, $tags_db);
//        print_r($result);

        if (!empty($result)) {
            foreach ($result as $res) {
                $class_color = rand(0, $count_colors);
                $wpdb->insert(
                    'colors_tags',
                    array('name_tag' => $res, 'color_tag' => $colors_sort[$class_color]),
                    array('%s', '%s'));
            }
        }


        header('location: /edit-campaign/');
        break;
    }
    case 'priview': {

        /*    foreach ($_POST['photos'] as $n => $fileBody) {
                $fileName = md5(time() . $n); // генерируем рандомное название файла

                // определяем формат файла
                preg_match('#data:image\/(png|jpg|jpeg|gif);#', $fileBody, $fileTypeMatch);
                $fileType = $fileTypeMatch[1];

                // декодируем содержимое файла
                $fileBody = preg_replace('#^data.*?base64,#', '', $fileBody);
                $fileBody = base64_decode($fileBody);

                // сохраем файл
                file_put_contents($fileName . '.' . $fileType, $fileBody);

            }*/
        $postID = $_POST['numberIdPost'];
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');


        $paymentCompanyname = str_replace(" ", "", $user_info->user_email);
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $paymentCompanyname;
        $pathNew = $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $paymentCompanyname;
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $paymentCompanyname . "/slider/" . $postID . "/";
        $pathNew2 = $pathNew . "/slider";
        $pathNew3 = $pathNew2 . "/$postID";


        if (file_exists($filename)) {
            mkdir($pathNew3, 0755);

            foreach ($_POST['photos'] as $n => $fileBody) {
                $fileName = md5(time() . $n); // генерируем рандомное название файла

                // определяем формат файла
                preg_match('#data:image\/(png|jpg|jpeg|gif);#', $fileBody, $fileTypeMatch);
                $fileType = $fileTypeMatch[1];
                print_r($fileTypeMatch);
                // декодируем содержимое файла
                $fileBody = preg_replace('#^data.*?base64,#', '', $fileBody);
                $fileBody = base64_decode($fileBody);

                // сохраем файл
                file_put_contents("{$upload_dir}{$fileName}" . '.' . $fileType, $fileBody);

            }
        } else {
            mkdir($pathNew, 0755);
            mkdir($pathNew2, 0755);
            mkdir($pathNew3, 0755);

            foreach ($_POST['photos'] as $n => $fileBody) {
                $fileName = md5(time() . $n); // генерируем рандомное название файла

                // определяем формат файла
                preg_match('#data:image\/(png|jpg|jpeg|gif);#', $fileBody, $fileTypeMatch);
                $fileType = $fileTypeMatch[1];

                // декодируем содержимое файла
                $fileBody = preg_replace('#^data.*?base64,#', '', $fileBody);
                $fileBody = base64_decode($fileBody);

                // сохраем файл
                file_put_contents("{$upload_dir}{$fileName}" . '.' . $fileType, $fileBody);

            }

        }
        header('location: /edit-campaign/');
        break;
    }
}
//$post_id = wp_insert_post( $post_data );
//header('location:' . $url[0] . '?status=title');
