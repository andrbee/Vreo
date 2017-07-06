<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package metronic
 */


$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?php language_attributes(); ?>">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #1 for " name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?=get_template_directory_uri()?>/assets/apps/css/inbox.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?=get_template_directory_uri()?>/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/global/plugins/socicon/socicon.css" rel="stylesheet" type="text/css">
    <link href="<?=get_template_directory_uri()?>/assets/css/main.css" rel="stylesheet" type="text/css" />
    <link href="<?=get_template_directory_uri()?>/assets/css/styles.css" rel="stylesheet" type="text/css" />
    <script src="<?=get_template_directory_uri()?>/plugins/ckeditor/ckeditor.js"></script>
    <script src="<?=get_template_directory_uri()?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
    <link href="<?=get_template_directory_uri()?>/js/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />



    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<script>
    var dateVar = new Date();
    var offset = -dateVar.getTimezoneOffset();
    document.cookie = "timezone="+offset;
</script>

<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/category/marketplace/">
                    <img src="<?=get_template_directory_uri()?>/assets/pages/img/logos/vreo_icon_text_light.png" alt="logo" class="logo-default" /> 
                </a>
                <div class="menu-toggler sidebar-toggler"></div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <span class="title-header">Welcome to the beta of vreo!</span>
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                    <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                    <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                    <li class="sidebar-search-wrapper search-top">
                        <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                        <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                        <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                        <form  action="<?=get_site_url()?>/category/marketplace/" method="GET">
                            <div class="input-group input-medium form-serch">
                                        <span class="input-group-btn btn-serch">
                                            <button class="btn btn-color" type="button"><i class="icon-magnifier"></i></button>
                                        </span>
                                <input type="hidden" name="back_url" value="<?=get_site_url().$_SERVER['REQUEST_URI']?>">
                                <input id="tags" type="text" name="hashtag" class="form-control input-color ui-autocomplete-input" autocomplete="off" placeholder="Search...">
                            </div>
                        </form>

                        <!-- END RESPONSIVE QUICK SEARCH FORM -->
                    </li>
                    <?php
                    global $wpdb;
                    $activiticTopStatus = $wpdb->get_results( "SELECT `id_user`,`status` FROM activities WHERE id_user = $cur_user_id");
                    $colTop = 0;
                    foreach ($activiticTopStatus as $key) {
                        if($key->status == false) {
                            $arrayTopStatus[$colTop] = $key->status;
                            $colTop++;
                        }
                    }
                    $outTopStatus = count($arrayTopStatus);
                    ?>
                    <li class="dropdown dropdown-extended dropdown-notification">
                        <a href="/bookmark/" title="Bookmark" class="link-hover">
                            <i class="fa fa-bookmark font-white"></i>
                        </a>
                    </li>
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                            <!-- <i class="icon-bell font-white"></i> -->
                            <span class="dashboard-icons-activites"></span>
                            <?php if($outTopStatus == true): ?>
                                <span class="badge badge-default"><?=$outTopStatus;?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external" style="padding-bottom: 23px;">
                                <a href="/activities/">view all</a>
                            </li>
                            <li>

                                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 325px;">
                                    <ul class="dropdown-menu-list scroller" style="height: 325px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">               <?php
//                                        for ($day = 0;$day <= 7;$day++){
                                            $date_current = new \DateTime();
                                            $dateDay = $date_current->modify("-$day day");
                                            $dateDayDbStart = $dateDay->format("Ymd") . '000000';
                                            $dateDayDbEnd = $dateDay->format("Ymd") . '235959';
                                            $role = '';
                                            if (in_array('brand', $user_info->roles)) $role = 'brand';
                                            if ($role == "brand") {
                                                $header_db = $wpdb->get_results("SELECT * FROM activities WHERE id_user = $cur_user_id AND (categories IN(" . implode(',', (array)$user_info->profile_categore) . ") OR hash_tag REGEXP '" . implode('|', (array)$user_info->profile_hash) . "')");

                                                $header_activitic_users_brand_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'followUser' AND id_user = '$cur_user_id'");
                                                $header_activitic_signed_brand_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'signedUser' AND id_user = '$cur_user_id'");
                                                $header_activitic_message_brand_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'messages' AND id_user = '$cur_user_id'");

                                                $header_profile_db = $wpdb->get_results("SELECT * FROM activities WHERE type_notifications = 'profileAccount' AND id_user = '$cur_user_id'");
                                                $header_admin_db = $wpdb->get_results("SELECT * FROM activities WHERE type_notifications = 'adminMessageAll' AND id_user = '$cur_user_id'");
                                                $header_step_message_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepMessages' AND id_user = '$cur_user_id'");
                                                $header_step_price_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepPrice' AND id_user = '$cur_user_id'");
                                                $header_step_approve_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepApprove' AND id_user = '$cur_user_id'");

                                                $allResultHeader = array_merge($header_activitic_users_brand_db,$header_activitic_signed_brand_db,$header_activitic_message_brand_db,$header_step_message_db,$header_step_price_db,$header_step_approve_db,$header_db, $header_profile_db, $header_admin_db);
                                            } else {
                                                $header_activitic_users_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'followUser' AND id_user = '$cur_user_id'");
                                                $header_activitic_signed_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'signedUser' AND id_user = '$cur_user_id'");
                                                $header_activitic_message_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'messages' AND id_user = '$cur_user_id'");

                                                $header_profile_db = $wpdb->get_results("SELECT * FROM activities WHERE type_notifications = 'profileAccount' AND id_user = '$cur_user_id'");
                                                $header_admin_db = $wpdb->get_results("SELECT * FROM activities WHERE type_notifications = 'adminMessageAll' AND id_user = '$cur_user_id' ");
                                                $header_step_message_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepMessages' AND id_user = '$cur_user_id'");
                                                $header_step_price_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepPrice' AND id_user = '$cur_user_id'");
                                                $header_step_approve_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepApprove' AND id_user = '$cur_user_id'");

                                                $allResultHeader = array_merge($header_activitic_users_db,$header_activitic_signed_db,$header_step_message_db,$header_step_price_db,$header_step_approve_db,$header_profile_db, $header_admin_db);
                                            }

                                            if (!function_exists('headerSort')) {
                                                function headerSort($f1,$f2)
                                                {
                                                    if($f1->data < $f2->data) return -1;
                                                    elseif($f1->data > $f2->data) return 1;
                                                    else return 0;
                                                }
                                            }
                                            uasort($allResultHeader,"headerSort");
                                            $resultHeader = array_reverse($allResultHeader);
                                            $argsHeaderCol = count($resultHeader);
                                            $colNottification = 0;
                                        foreach($resultHeader as $key):
                                            $colNottification++;
                                            if ($colNottification <= 6) {
                                                ?>
                                                <li>
                                                    <a href="javascript:;">
                                                           <span class="time"><?php
                                                               if ($day == 0){
                                                                   ?>
                                                               <time class="timeago" datetime="<?= $key->data ?>">
                                                               <?php } else {
                                                                   $data = new \DateTime($key->data);
                                                                   echo $data->format('h:i:s');
                                                               } ?></span>
                                                        <div class="details">
                                                            <?if($key->type_notifications=='adminMessageAll'){?>
                                                                <div class="label label-sm bg-blue">
                                                                    <span class="dashboard-icons-vreo-white"></span>
                                                                </div>
                                                            <?}elseif($key->type_notifications=='profileAccount'){?>
                                                                <div class="label label-sm bg-yellow-gold">
                                                                    <i class="fa fa-user"></i>
                                                                </div>
                                                            <?} elseif($key->type_notifications=='followUser'){?>
                                                                <div class="label label-sm bg-grey-mint">
                                                                    <i class="fa fa-user-plus"></i>
                                                                </div>
                                                            <?} elseif($key->type_notifications=='signedUser'){?>
                                                                <div class="label label-sm bg-red-mint">
                                                                    <i class="fa fa-user-times"></i>
                                                                </div>
                                                            <?} elseif($key->type_notifications=='messages'){?>
                                                                <div class="label label-sm bg-yellow-gold">
                                                                    <i class="fa fa-envelope"></i>
                                                                </div>
                                                            <?} elseif($key->type_notifications=='stepMessages'){?>
                                                                <div class="label label-sm bg-yellow-gold">
                                                                    <<i class="fa fa-envelope"></i>
                                                                </div>
                                                            <?} elseif($key->type_notifications=='stepPrice'){?>
                                                                <div class="label label-sm bg-red-mint">
                                                                    <i class="fa fa-money"></i>
                                                                </div>
                                                            <?} elseif($key->type_notifications=='stepApprove'){?>
                                                                <div class="label label-sm bg-yellow-gold">
                                                                    <i class="fa fa-flag-checkered"></i>
                                                                </div>
                                                            <?} else {?>
                                                                <div class="label label-sm label-success">
                                                                    <span class="dashboard-icons-marketplace-white"></span>
                                                                </div>
                                                            <?}?>
                                                            <?=$key->message;?>
                                                        </div>
                                                    </a>

                                                </li>
                                            <?php } endforeach; //} ?>
                                    </ul>
                                    <div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div> <?php  ?>
                            </li>
                        </ul>
                    </li>

                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-inbox" >
                        <a href="/edit-profile/" class="link-hover">
                            <i class="fa fa-gear font-white"></i>
                        </a>
                    </li>
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="<?=$user_info->profilePic; ?>" />
                            <span class="username username-hide-on-mobile"> <?php echo $user_info->user_nicename ?></span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="/profile/">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="/messenger/">
                                    <i class="icon-envelope-open"></i> My Inbox
                                    <? if(fep_get_new_message_number()>0){?><span class="badge badge-danger"><?=fep_get_new_message_number();?></span><?}?>
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="<?=wp_logout_url(); ?>">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">


        <!-- BEGIN SIDEBAR -->
        <?php require_once 'template-parts/dashboard-sidebar.php'; ?>
        <!-- END SIDEBAR -->