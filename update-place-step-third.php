<?php
/*
 * Template name: Place third step update
 */
//error_reporting(E_ALL);

get_header('dashboard');


global $wpdb;
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);

//require_once 'inc/place-brand.php';
require 'vendor/autoload.php';
$config = require "inc/config.php";

if (isset($_GET['pageId'])) {
    $postIdPlace = $_GET['pageId'];
    $post = get_post($postIdPlace);
} else {
    $postIdPlace = null;
    $post = null;
}
if (isset($_GET['idDev'])) {
    $idDevPlace = $_GET['idDev'];
} else {
    $idDevPlace = null;
}

use Aws\S3\S3Client;

// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);


$result = $wpdb->get_results("SELECT * FROM ps_price WHERE $idDevPlace = $idDevPlace AND postIdPlace = $postIdPlace AND statusPrice = 0");

$resultUser = $wpdb->get_results("SELECT * FROM ps_price WHERE curIdPlace = $cur_user_id AND postIdPlace = $postIdPlace AND statusPrice = 0");

$messageAll = $wpdb->get_results("SELECT * FROM ps_message_update WHERE id_dev = $idDevPlace AND id_post = $postIdPlace");

$status = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND curIdPlace = $cur_user_id AND statusPrice = 1 ORDER BY id DESC LIMIT 1");
$statusAll = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 1  ORDER BY id DESC LIMIT 2");

$idCurUser = get_current_user_id();
$status = $wpdb->get_results("SELECT * FROM ps_finish_update WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND curIdPlace = $idCurUser AND status = 1 ORDER BY id DESC LIMIT 1");

$approveDeveloper = $wpdb->get_results("SELECT * FROM pl_step_files_update WHERE id_dev = $idDevPlace AND id_post = $postIdPlace");
$approvedDeveloper = $wpdb->get_results("SELECT * FROM pl_step_files_update WHERE id_dev = $idDevPlace AND id_post = $postIdPlace AND approve = 1 AND approve_brand = 1");


?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN THEME PANEL -->
        <?php require_once 'inc/campaing-error.php'; ?>
        <div class="profile-title">
            <h2><?php wp_title("", true); ?> </h2>
        </div>
        <!-- END THEME PANEL -->

        <!-- BEGIN PAGE BAR -->

        <?php require_once 'template-parts/breadcrumbs.php'; ?>
        <!-- END PAGE BAR -->
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS 1-->
        <!-- Begin button save and public -->
        <h2 class="brand-pl-message"><?= $plMessage; ?></h2>

        
        <?php require_once get_template_directory() . "/template-parts/stepThirdUpdate.php"; ?>
        <!-- First step registration advertising -->
        <br>
        <?php if(!$status){?>
        <div class="row">
            <!-- BEGIN PORTLET-->
            <h2 style="margin-left: 15px;">If you wish to write a message, please do so below.</h2>
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="scroller" style="height: 525px;" data-always-visible="1" data-rail-visible1="1">
                        <ul class="chats">
                            <?php foreach ($messageAll as $item): ?>
                                <?php if ($item->user_message_id != $cur_user_id) {
                                    $informationIdUser = get_userdata($item->user_message_id);
                                    ?>
                                    <li class="in">
                                        <img class="avatar" src="<?php echo $informationIdUser->profilePic; ?>"/>
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;"
                                               class="name"> <?php echo $informationIdUser->display_name; ?> </a>
                                            <span class="datetime"> at <?php echo str_replace('-', '/',$item->date); ?> </span>
                                            <span class="body"> <?php echo $item->message; ?>  </span>
                                        </div>
                                    </li>
                                <?php } else {
                                    $informationIdUser = get_userdata($item->user_message_id);
                                    ?>

                                    <li class="out">
                                        <img class="avatar" src="<?php echo $informationIdUser->profilePic; ?>"/>
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;"
                                               class="name"> <?php echo $informationIdUser->display_name; ?> </a>
                                            <span class="datetime"> at <?php echo str_replace('-', '/',$item->date); ?> </span>
                                            <span class="body"> <?php echo $item->message; ?></span>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <form
                        action="<?php echo get_stylesheet_directory_uri() . '/inc/place-step/thirdStepUpdate.php?formSet=message'; ?>"
                        method="post">
                        <div class="chat-form">
                            <div class="input-cont">
                                <input class="form-control" type="text" name="messageUser"
                                       placeholder="Type a message here..."/></div>
                            <div class="btn-cont">
                                <span class="arrow"> </span>
                                <input type="hidden" name="idDevPlace" value="<?= $idDevPlace; ?>">
                                <input type="hidden" name="postIdPlace" value="<?= $postIdPlace; ?>">
                                <input type="hidden" name="curIdPlace" value="<?= $cur_user_id; ?>">
                                <button type="submit" class="btn blue icn-only">
                                    <i class="fa fa-check icon-white"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
        <?}?>

        <!-- End first step registration advertising -->
        <!-- End button save and public -->
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

<?php
require_once(get_template_directory() . '/template-parts/content-previes.php');
get_footer('dashboard');
