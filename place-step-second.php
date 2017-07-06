<?php
/*
 * Template name: Place second step
 */
//error_reporting(E_ALL);
get_header('dashboard');

global $wpdb;
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);

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

$budget = $post->budget_number_campaign;
$cpv = $post->cost_campaign;
$minRandge = $budget / (1 * $cpv);
$maxRandge = $budget / (0.3 * $cpv);
$minRandge = (floor($minRandge / 100)) * 100;
$maxRandge = (ceil($maxRandge / 100)) * 100;

$result = $wpdb->get_results("SELECT * FROM ps_price WHERE $idDevPlace = $idDevPlace AND postIdPlace = $postIdPlace AND statusPrice=0");

$resultUser = $wpdb->get_results("SELECT * FROM ps_price WHERE curIdPlace = $cur_user_id AND postIdPlace = $postIdPlace AND statusPrice = 0");


$resultBrand = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_dev = $idDevPlace AND id_campaign = $postIdPlace ORDER BY id DESC LIMIT 1");

$messageAll = $wpdb->get_results("SELECT * FROM ps_message WHERE id_dev = $idDevPlace AND id_post = $postIdPlace");

$status = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND curIdPlace = $cur_user_id AND statusPrice = 1 ORDER BY id DESC LIMIT 1");
$idBrand = $resultBrand[0]->id_brand;
if ($user_info->roles[0] == 'developer') {

    $statusDecline = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND curIdPlace = $idBrand AND statusDecline = 1 ORDER BY id DESC LIMIT 1");

} elseif ($user_info->roles[0] == 'brand') {
    $statusDecline = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND curIdPlace = $idDevPlace AND statusDecline = 1 ORDER BY id DESC LIMIT 1");
}

$statusApprove = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND curIdPlace = $cur_user_id AND statusPrice = 1 ORDER BY id DESC LIMIT 1");

$statusAll = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 1  ORDER BY id DESC LIMIT 2");


$statusBrand = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 1 AND curIdPlace = $id_brand ORDER BY id DESC LIMIT 1");

$statusDev = $wpdb->get_results("SELECT * FROM ps_price WHERE postIdPlace = $postIdPlace AND idDevPlace = $idDevPlace AND statusPrice = 1 AND curIdPlace = $id_dev ORDER BY id DESC LIMIT 1");

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

        <!-- Step menu registration advertising -->
        <div class="portlet-body">
            <div class="mt-element-step">
                <div class="row step-thin">
                    <div class="col-lg-4 bg-grey mt-step-col">
                        <div class="mt-step-number first bg-white font-grey">1</div>
                        <div class="mt-step-title uppercase font-grey-cascade">Step</div>
                        <div class="mt-step-content font-grey-cascade">Choose positions</div>
                    </div>
                    <div class="col-lg-4 bg-grey mt-step-col active">
                        <div class="mt-step-number bg-white font-grey">2</div>
                        <div class="mt-step-title uppercase font-grey-cascade">Step</div>
                        <div class="mt-step-content font-grey-cascade">Negotiate payment</div>
                    </div>
                    <div class="col-lg-4 bg-grey mt-step-col">
                        <div class="mt-step-number bg-white font-grey">3</div>
                        <div class="mt-step-title uppercase font-grey-cascade">Step</div>
                        <div class="mt-step-content font-grey-cascade">Finalize ad placement</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End step menu registration advertising -->

        <!-- First step registration advertising -->

        <div class="row">
            <div class="col-md-12">
                <?php
                if ($user_info->roles[0] == 'developer') { ?>
                    <p>
                        Please consider that your offer will be shown to the brand with our commission added on top.
                    </p>
                <? } else { ?>
                    <p>
                        Please consider that your offer will be shown to the developer with our commission subtracted.
                    </p>
                <?
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <ul class="place-block__second">
                    <?php
                    $sliderImages = get_post_meta($postIdPlace, 'campaignSlider', true);
                    if (!empty($sliderImages)) {
                        $colPosition = 0;
                        foreach ($sliderImages as $slide) {
                            $colPosition++;
                            if ($s3->doesObjectExist($config['s3']['bucket'], $slide)) {
                                $imageUrl = $config["s3"]["cdnPath"] . "/" . $slide;
                                ?>
                                <li class="place-list__second">
                                    <a class="image-popup-vertical-fit" href="<?php echo $imageUrl; ?>">
                                        <img src="<?php echo $imageUrl; ?>" style="width: 155px; height: 100px;"/>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                    } ?>
                </ul>

                <div class="dashboard-stat blue-soft">
                    <div class="visual" style="padding-top: 22px;">
                        <img
                            src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/vreo_icon_text_light.png"
                            alt="">
                    </div>
                    <div class="dasborard-campaign" style="margin-left: 10px; margin-right: 10px;padding:0 24px;">
                        <div class="number"><?= $post->pic_number_campaign ?>x</div>
                        <div class="desc"> Picture advertising</div>
                    </div>
                    <div class="dasborard-campaign" style="margin-left: 10px; margin-right: 10px;padding:0 24px;">
                        <div class="number"><?= $post->video_number_campaign ?>x</div>
                        <div class="desc"> Video advertising</div>
                    </div>
                    <div class="dasborard-campaign" style="margin-left: 10px; margin-right: 10px;padding:0 24px;">
                        <div class="number">
                            <?php
                            if ($user_info->roles[0] == 'developer') {
                                echo $post->cost_campaign;
                            } else {
                                echo round($post->cost_campaign * 1.33, 2);
                            }
                            ?> &#8364; </div>
                        <div class="desc"> Cost per view</div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                    <tr>
                        <th style="text-align: center; font-size: 18px;">
                            <i class="fa fa-money" style="margin-right: 5px;"></i> Budget possible
                        </th>
                        <th style="text-align: center; font-size: 18px;">
                            <i class="fa fa-users" style="margin-right: 5px;"></i> Range min
                        </th>
                        <th style="text-align: center; font-size: 18px;">
                            <i class="fa fa-users" style="margin-right: 5px;"></i> Range max
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="highlight" style="text-align: center">
                            <span class="budget-number__number">
                                 <?php
                                 if ($user_info->roles[0] == 'developer') {
                                     echo $post->budget_number_campaign;
                                 } else {
                                     echo round($post->budget_number_campaign * 1.33, 2);
                                 }
                                 ?>&#8364;</span>
                        </td>
                        <td style="text-align: center"><span
                                class="budget-number__number"> <?php echo $minRandge; ?> </span></td>
                        <td style="text-align: center"><span
                                class="budget-number__number"> <?php echo $maxRandge; ?></span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-7">
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                    <tr>
                        <th style="text-align: center; font-size: 18px; width: 23%;">
                            <i class="fa fa-euro" style="margin-right: 5px;"></i> Cost per view
                        </th>
                        <th style="text-align: center; font-size: 18px; width: 23%;">
                            <i class="fa fa-money" style="margin-right: 5px;"></i> Budget possible
                        </th>
                        <th style="text-align: center; font-size: 18px; width: 40%;">
                            <i class="fa fa-user" style="margin-right: 5px;"></i> Name
                        </th>
                        <!--                        <th style="text-align: center; font-size: 18px;"></th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $colPrice = count($result) - 1;
                    $colUp = 0;
                    if ($statusApprove) {
                        $bgAprove = 'rgba(82, 214, 74, 0.44);';
                        $borderAprove = 'rgba(82, 214, 74, 0);';
                    } else {
                        $bgAprove = '';
                    }
                    foreach ($result as $key):

                        ?>
                        <tr style="background-color: <?php if ($colUp == $colPrice) {
                            echo $bgAprove;
                        } ?>">
                            <td class="highlight"
                                style="text-align: center; border-color: <?php if ($colUp == $colPrice) {
                                    echo $borderAprove;
                                } ?>">
                            <span class="budget-number__number">
                                <?php
                                $curId = $key->curIdPlace;
                                //                                echo $curIdPlace;
                                if ($curId == $cur_user_id) {
                                    echo $key->cpv;
                                } else {
                                    $userInfoPartner = get_userdata($curId);
//                                    echo "-".$userInfoPartner->roles[0]."-";
                                    if ($userInfoPartner->roles[0] == 'brand') {
                                        echo round($key->cpv * 0.75, 2);
                                    } else {
                                        echo round($key->cpv * 1.33, 2);
                                    }
                                }

                                ?>
                            </span>
                            </td>
                            <td style="text-align: center; width: 23%;border-color: <?php if ($colUp == $colPrice) {
                                echo $borderAprove;
                            } ?>">
                            <span class="budget-number__number">
                             <?php
                             $curId = $key->curIdPlace;
                             //                                echo $curIdPlace;
                             if ($curId == $cur_user_id) {
                                 echo $key->bp;
                             } else {
                                 $userInfoPartner = get_userdata($curId);
//                                    echo "-".$userInfoPartner->roles[0]."-";
                                 if ($userInfoPartner->roles[0] == 'brand') {
                                     echo round($key->bp * 0.75, 2);
                                 } else {
                                     echo round($key->bp * 1.33, 2);
                                 }
                             }

                             ?>
                            </span>
                            </td>
                            <td style="text-align: center;">
                            <span class="budget-number__number">
                               <?php
                               $infoName = get_userdata($key->curIdPlace); ?>
                                <a href="/profile/?&user_id=<?= $infoName->ID ?>"><?= $infoName->user_nicename ?></a>
                            </span>
                            </td>

                            <?php if ($colUp == $colPrice): ?>
                                <?php
                                $rr=$wpdb->get_results("SELECT * FROM ps_price WHERE $idDevPlace = $idDevPlace AND postIdPlace = $postIdPlace AND statusPrice=1");
                                if ($key->curIdPlace == $cur_user_id && count($rr)<1) {
                                    $userInfoButton = false;
                                }
                            else {
                                    $userInfoButton = true;

                            }
                                if ($userInfoButton):
                                    if (count($statusAll) !== 2):
                                        if (!$statusDecline):
                                            ?>
                                            <td style="text-align: center; width: 200px; display: block;">
                                                <form
                                                    action="<?php echo get_stylesheet_directory_uri() . '/inc/place-step/secondStepPrice.php?formSet=approve'; ?>"
                                                    method="post" style="display: inline-block;">
                                                    <input type="hidden" name="idDevPlace" value="<?= $idDevPlace; ?>">
                                                    <input type="hidden" name="postIdPlace"
                                                           value="<?= $postIdPlace; ?>">
                                                    <input type="hidden" name="curIdPlace" value="<?= $cur_user_id; ?>">
                                                    <?php if ($user_info->roles[0] == 'developer'): ?>
                                                        <button type="submit" class="btn red" <?php if ($status) {
                                                            echo 'disabled';
                                                        } ?>><?php if ($status) {
                                                                echo 'Approved';
                                                            } else {
                                                                echo 'Approve';
                                                            } ?></button>
                                                    <?php elseif ($user_info->roles[0] == 'brand'): ?>
                                                        <button type="submit" class="btn red" <?php if ($status) {
                                                            echo 'disabled';
                                                        } ?>><?php if ($status) {
                                                                echo 'Approved';
                                                            } else {
                                                                echo 'Approve';
                                                            } ?></button>
                                                    <?php endif; ?>
                                                </form>
                                                <?php
                                                if ($user_info->roles[0] == 'developer') {
                                                    $coutPrice = 5;
                                                } else {
                                                    $coutPrice = 4;
                                                }
                                                if (count($resultUser) <= $coutPrice):
                                                    ?>
                                                <form
                                                    action="<?php echo get_stylesheet_directory_uri() . '/inc/place-step/secondStepPrice.php?formSet=decline'; ?>"
                                                    method="post" style="display: inline-block;">
                                                    <input type="hidden" name="idDevPlace" value="<?= $idDevPlace; ?>">
                                                    <input type="hidden" name="postIdPlace"
                                                           value="<?= $postIdPlace; ?>">
                                                    <input type="hidden" name="curIdPlace" value="<?= $cur_user_id; ?>">
                                                    <?php if ($user_info->roles[0] == 'developer'): ?>
                                                    <button type="submit"
                                                            class="btn blue" <?php if (count($statusAll) == 1) {
                                                        echo 'disabled';
                                                    } else {
                                                        echo '';
                                                    } ?>><?php if (!$statusDev) {
                                                            echo 'Declined';
                                                        } else {
                                                            echo 'Decline';
                                                        } ?></button>
                                                <?php elseif ($user_info->roles[0] == 'brand'): ?>
                                                    <button type="submit"
                                                            class="btn blue" <?php if (count($statusAll) == 1) {
                                                        echo 'disabled';
                                                    } else {
                                                        echo '';
                                                    } ?>><?php if ($statusBrand) {
                                                            echo 'Declined';
                                                        } else {
                                                            echo 'Decline';
                                                        } ?></button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                        </tr>
                        <?php $colUp++; endforeach; ?>

                    <?php

                    if (!$status) {
                        if ($user_info->roles[0] == 'developer') {
                            $coutPrice = 5;
                        } else {
                            $coutPrice = 4;
                        }
                        ?>
                        <?php if (count($resultUser) <= $coutPrice) {
                            ?>
                            <?php if (!$statusAll) {
                                if ($statusDecline) {
                                    ?>
                                    <form
                                        action="<?php echo get_stylesheet_directory_uri() . '/inc/place-step/secondStepPrice.php?formSet=price'; ?>"
                                        method="post">
                                        <tr>
                                            <td class="highlight" style="text-align: center;">
                                                <div class="dasborard-campaign">
                                                    <div class="number cost_per_view" style="padding-top: 0;">
                                                        <div class="iter_up" onclick="iterCostPerView(this)"><i
                                                                class="fa fa-caret-up" aria-hidden="true"></i></div>
                                                        <div class="iter_down" onclick="iterCostPerView(this)"><i
                                                                class="fa fa-caret-down" aria-hidden="true"></i></div>
                                                        <label for="cpv"></label>
                                                        <input name="cpv"
                                                               id="cost-campaign" required
                                                               style="width: 85px; color:black;"
                                                               onkeydown="return convertPriceCPV(this,event,'<?= $user_info->roles[0] ?>')">
                                                    </div>
                                                </div>

                                            </td>
                                            <td style="text-align: center; width: 23%;">
                            <span class="budget-number__number">
                                <label for="bp"></label>
                                <input name="bp" style="width: 63%;" type="number" required
                                       onchange="changeConvertPriceBudget(this,'<?= $user_info->roles[0] ?>')"
                                       onkeydown="return convertPriceBudget(this,event,'<?= $user_info->roles[0] ?>')">
                            </span>
                                            </td>
                                            <td style="text-align: center;">
                            <span class="budget-number__number">
                                <?php echo $user_info->user_nicename; ?>
                            </span>
                                            </td>
                                            <td style="text-align: center">
                                                <button type="submit" class="btn blue-madison">Send</button>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="idDevPlace" value="<?= $idDevPlace; ?>">
                                        <input type="hidden" name="postIdPlace" value="<?= $postIdPlace; ?>">
                                        <input type="hidden" name="curIdPlace" value="<?= $cur_user_id; ?>">
                                    </form>
                                <?php } ?>
                            <?php } ?>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php if (count($statusAll) == 2): ?>
                    <a href="/place-third-step/?idDev=<?= $idDevPlace; ?>&pageId=<?= $postIdPlace; ?>"
                       class="btn green ">Next step</a>
                <?php endif; ?>
                <br>
                <br>

                <?php if (count($statusAll) == 2): ?>
                    <div class="alert alert-success">
                        <?php if ($user_info->roles[0] == 'developer'): ?>
                            <strong>Success!</strong> You approved the proposed budget and CPV.
                        <?php elseif ($user_info->roles[0] == 'brand'): ?>
                            <strong>Success!</strong> You agreed upon a budget and CPV, please proceed to step 3.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php if (count($statusAll) !== 2): ?>
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
                                                <span
                                                    class="datetime"> at <?php echo str_replace('-', '.', date('d-m-Y', strtotime($item->date))); ?> </span>
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
                                                <span
                                                    class="datetime"> at <?php echo str_replace('-', '.', date('d-m-Y', strtotime($item->date))); ?> </span>
                                                <span class="body"> <?php echo $item->message; ?></span>
                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <form
                            action="<?php echo get_stylesheet_directory_uri() . '/inc/place-step/secondStepPrice.php?formSet=message'; ?>"
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
        <?php endif; ?>

        <!-- End first step registration advertising -->
        <!-- End button save and public -->
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <script src="<?= get_template_directory_uri() ?>/js/inputOnlyNum.js" type="text/javascript"></script>
    <script src="<?= get_template_directory_uri() ?>/js/convertPrice.js" type="text/javascript"></script>
<?php
require_once(get_template_directory() . '/template-parts/content-previes.php');
get_footer('dashboard');
