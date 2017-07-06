<?php
$cur_user_id = get_current_user_id();
$user_info = get_userdata(get_the_author_meta('id'));
$userIdProfile = get_current_user_id();
$meta = new stdClass;
$tags = (array)get_the_tags();
require TEMPLATEPATH . '/vendor/autoload.php';
$config = require TEMPLATEPATH . "/inc/config.php";
use Aws\S3\S3Client;

// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);

if (!empty($tags)) {
    foreach ($tags as $tag) {
        $masiv[] = $tag->slug;
    }
}


$args = array(
    'post_status' => 'publish ',
    'tag' => $masiv
);
$posts3 = get_posts($args);
foreach (get_post_meta($post->ID) as $k => $v)
    $meta->$k = $v[0];
?>

<div class="row">

    <div class="profile"
         style="display: block;min-height: 450px;background-image: url(<?= $config['s3']['cdnPath'] . "/" . urlencode($meta->campaign_bg_header_file) ?>);background-size: cover!important;    background-repeat: no-repeat;    background-position: 90% center; ">
        <div class="categ_and_pltfrm_campgn clearfix">
            <div class="categ_campgn"><?
                $list_categ = get_the_category($k->ID);
                foreach ($list_categ as $categ) {
                    ?>
                    <img data-toggle="tooltip" data-placement="top" title="<?= $categ->name ?>"
                         style="width:30px; margin-right: 5px;margin-bottom: 10px;"
                         src="<?= get_template_directory_uri() . "/assets/img/categ_icons/" . strtolower($categ->name) ?>.png"
                         alt="">
                <? } ?></div>
            <div class="platform_cmpgn">
                <?
                $list_platforms = get_post_meta($post->ID, 'campaign_platform');
                if (!empty($list_platforms)) {
                    foreach ($list_platforms[0] as $platform) {
                        ?>
                        <img data-toggle="tooltip" data-placement="top" title="<?= ucfirst($platform) ?>"
                             style="width:30px; margin-right: 5px;margin-bottom: 10px;"
                             src="<?= get_template_directory_uri() . "/assets/img/platforms_icon/" . strtolower($platform) ?>.png"
                             alt="">
                    <? }
                } ?>
            </div>
        </div>
        <div class="age"
             style="position: absolute; width: 80px;height: 80px; border-radius: 10px; right: 20px;top: 20px;"><? if (!empty($meta->campaign_age_file)) { ?>
                <img
                style="width: 100%; max-width: 76px;max-height: 76px;"
                src="<?= $config['s3']['cdnPath'] . "/" . urlencode($meta->campaign_age_file) ?>"><? } ?></div>
        <!--        <img style="max-height: 450px" src="-->
        <? //=$meta->campaign_bg_header;?><!--" class="profile-img" alt="profile background users">-->
        <div class="profile-company">
            <? if ($user_info->user_login == 'developer4') { ?><img
                src="<?= get_template_directory_uri() ?>/assets/pages/img/flag/de.png" width="34" height="34"
                alt="Сountry flag" class="profile-company__img">
            <? } else { ?><img
                src="<?= get_template_directory_uri() ?>/assets/img/flags/<?= strtolower($user_info->country); ?>.png"
                width="34" height="34" alt="Сountry flag" class="profile-company__img"><? } ?>
            <h2 class="profile-company__name"><?= $user_info->companyname ?></h2>
            <?php
            require_once('countries.php');
            foreach ($countries as $key => $value) {
                if ($user_info->country == $key) {
                    $countriProfile = $value;
                    break;
                }
            }
            ?>
            <p class="profile-company__address"><?= $user_info->address ?>, <?= $countriProfile; ?></p>
        </div>
        <div class="profile-user">
            <?
            $argsProfile = get_user_meta($cur_user_id, 'follow_id', false);
            for ($i = 0; $i < count($argsProfile); $i++) {
                if ($argsProfile[$i] == $userIdProfile) {
                    $existingId = $userIdProfile;
                    break;
                }
            }
            if ($cur_user_id != $userIdProfile) {
                if ($existingId == $userIdProfile) { ?>
                    <form method="post" id="profileSigned" class="profile-signed"
                          action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                        <button type="submit" id="profileBtn" class="btn green" value="signed">Signed</button>
                    </form>
                    <?php
                } else {
                    ?>
                    <form method="post" id="profileSigned" class="profile-signed"
                          action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                        <button type="submit" id="profileBtn" class="btn green" value="follow">Connect</button>
                    </form>
                    <?php
                }
            }
            ?>
            <img src="<?php
            if (!empty($user_info->profilePic)) {
                echo $user_info->profilePic;
            } else {
                echo get_template_directory_uri() . "/assets/avatar-4.png";
            }
            ?>" class="profile-user__img" alt="<?= $user_info->user_nicename ?>">
            <?php
            global $wpdb;
            $bookmark_db = $wpdb->get_results("SELECT * FROM bookmark WHERE id_users = $cur_user_id AND id_post = $post->ID");
            if ($cur_user_id != $userIdProfile) {
                if (!empty($bookmark_db)) { ?>
                    <form method="post" id="profileBookmark" class="profile-signed"
                          action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                        <button type="submit" id="profileBtnMark" class="btn green-haze" value="signedCardMark">Signed
                            Mark
                        </button>
                    </form>
                    <?php
                } else {
                    ?>
                    <form method="post" id="profileBookmark" class="profile-signed"
                          action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                        <button type="submit" id="profileBtnMark" class="btn green-haze" value="bookmarkCard">Bookmark
                        </button>
                    </form>
                    <?php
                }
            }
            ?>
        </div>
        <script>
            $('#profileSigned').submit(function (e) {
                var $form = $(this);
                var idProfile = <?=$userIdProfile;?>;
                var devIdProfile = <?=$cur_user_id?>;
                var btnClick = document.getElementById('profileBtn').value;
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: 'id_user=' + idProfile + '&dev_user=' + devIdProfile + '&profileBtn=' + btnClick,
                    success: function (data) {
                        window.location.reload();
                    },
                });
                e.preventDefault();
            });
            $('#profileBookmark').submit(function (e) {
                var $form = $(this);
                var idProfile = <?=$post->ID?>;
                var devIdProfile = <?=$cur_user_id?>;
                var btnClick = document.getElementById('profileBtnMark').value;
                Data = new Date();
                var Year = Data.getFullYear();
                var Month = Data.getMonth() + 1;
                var Day = Data.getDate();
                var Hour = Data.getHours();
                var Minutes = Data.getMinutes();
                var Seconds = Data.getSeconds();
                var out = Year + '-' + Month + '-' + Day + ' ' + Hour + ':' + Minutes + ':' + Seconds;
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: 'id_user=' + idProfile + '&dev_user=' + devIdProfile + '&profileBtn=' + btnClick + '&timeOut=' + out,
                    success: function (data) {
                        window.location.reload();
                    },
                });
                e.preventDefault();
            });
        </script>
        <div class="profile-hash">
            <?php

            $json_file = file_get_contents(get_template_directory_uri() . "/assets/json/colors.json");
            $colors = json_decode($json_file, true);
            //            echo count($colors);
            $i = 0;
            $colors_sort = array();
            foreach ($colors as $key => $value) {
                $colors_sort[$i] = $key;
                $i++;
            }
            //print_r($colors_sort);
            $count_colors = count($colors_sort) - 1;
            //            echo $count_colors;
            $tags = (array)get_the_tags();
            // print_r($tags);
            global $wpdb;
            if (!empty($tags)) {
                foreach ($tags as $tag) {
                    $colors_tags_db = $wpdb->get_results("SELECT DISTINCT color_tag FROM colors_tags WHERE name_tag='" . $tag->slug . "'");
                    echo "<button style='margin-right: 2px' class=\"btn btn-circle ";
                    foreach ($colors_tags_db as $clr_tg) {
                        echo $clr_tg->color_tag;
                    }
                    echo "\">$tag->name</button>";
                }
            }

            ?>

        </div>
    </div>


</div>
<div class="row">
    <div class="content__campaign"
         style="background-image: url(<?= $config['s3']['cdnPath'] . "/" . urlencode($meta->campaign_bg_file) ?>);background-repeat: no-repeat;background-size:cover;padding-top: 20px;padding-bottom: 20px;margin-bottom: 20px;">
        <div class="row">

            <div class="col-md-6 editor-campaing">
                <!--<h2><?php the_content() ?></h2>-->
                <p><?= $meta->campaign_editor_1; ?></p>
            </div>
            <div class="col-md-6">
                <? if (!empty($meta->campaign_yt_url)) { ?>
                    <h2><?= $meta->campaign_yt_title; ?></h2>
                    <div style="position:relative;height:0;padding-bottom:56.25%">
                        <div id="player-youtube"></div>
                    </div>

                    <script>
                        $(window).load(function () {
                            var value = "<?=$meta->campaign_yt_url;?>";
                            var getvalue = value.split("v=")[1];
                            var player = '<iframe width="100%" height="360" style="position:absolute;width:100%;height:100%;left:0"  src="https://www.youtube.com/embed/' + getvalue + '" frameborder="0" allowfullscreen></iframe>';
                            $('#player-youtube').html(player);

                        });
                    </script>
                <? } else{
                if (!empty($meta->campaign_video_key)){
                ?>
                    <video class="campaign_video" controls="controls" poster="">
                        <source src="<?= $config['s3']['cdnPath'] . "/" . urlencode($meta->campaign_video_key) ?>"
                                type='video/ogg; codecs="theora, vorbis"'>
                        <source src="<?= $config['s3']['cdnPath'] . "/" . urlencode($meta->campaign_video_key) ?>"
                                type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                        <source src="<?= $config['s3']['cdnPath'] . "/" . urlencode($meta->campaign_video_key) ?>"
                                type='video/webm; codecs="vp8, vorbis"'>
                        The video tag is not supported by your browser
                        <a href="<?= $config['s3']['cdnPath'] . "/" . urlencode($meta->campaign_video_key) ?>">Download</a>.
                    </video>
                    <?
                }
                } ?>
                <?php if (!empty($meta->campaign_image_file)) { ?><img
                    style="width:100%;margin-top: 20px;max-height: 650px"
                    src="<?= $config['s3']['cdnPath'] . "/" . urlencode($meta->campaign_image_file) ?>" alt=""><? } ?>
            </div>
        </div>

        <?php
        $cur_user_id = get_current_user_id();
        $user_info = get_userdata($cur_user_id);
        if ($user_info->roles[0] == 'brand'):
            ?>
            <a href="/place-step-first/?idDev=<?= $post->post_author; ?>&pageId=<?= $post->ID; ?>"
               class="btn btn-primary marketplace-btn__bottom" target="_blank" ><span
                    class="glyphicon glyphicon-flag" > </span> Place your brand
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard-stat blue-soft">
            <div class="visual">
                <img
                    src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/vreo_icon_text_light.png"
                    alt="">
            </div>
            <div class="dasborard-campaign">
                <div class="number"> <?php
                    if($user_info->roles[0]=='developer'){
                        echo $post->cost_campaign;
                    } else {
                        echo round($post->cost_campaign*1.33,2);
                    }
                    ?> &#8364; </div>
                <!--  <? /* $post->cost_campaign */ ?> &#8364;</div> -->
                <div class="desc"> Cost per view</div>
            </div>
            <div class="dasborard-campaign">
                <div class="number"><?= $post->pic_number_campaign ?>x</div>
                <div class="desc"> Picture advertising</div>
            </div>
            <div class="dasborard-campaign">
                <div class="number"><?= $post->video_number_campaign ?>x</div>
                <div class="desc"> Video advertising</div>
            </div>
            <div class="dasborard-campaign">
                <div class="number">
                    <?
                    global $wpdb;
                    if (!empty($tags)) {
                        foreach ($tags as $tag) {
                            $colors_tags_db = $wpdb->get_results("SELECT DISTINCT color_tag FROM colors_tags WHERE name_tag='" . $tag->slug . "'");
                            echo "<button style='margin-right: 2px' class=\"btn btn-circle ";
                            foreach ($colors_tags_db as $clr_tg) {
                                echo $clr_tg->color_tag;
                            }
                            echo "\">$tag->name</button>";
                        }
                    }

                    ?>
                    <!--                  <button class="btn btn-circle red-flamingo"> #hitech </button>-->
                    <!--                  <button class="btn btn-circle red-flamingo"> #beer </button>-->
                    <!--                  <button class="btn btn-circle red-flamingo"> #clothing </button>-->
                </div>
                <div class="desc"> are matching partners for <?= $post->post_title; ?></div>
            </div>
            <div class="dasborard-campaign">
                <div class="number">
                    <?php
                    if($user_info->roles[0]=='developer'){
                        echo $post->budget_number_campaign;
                    } else {
                        echo round($post->budget_number_campaign*1.33,2);
                    }
                    ?>
                    &#8364;</div>
                <div class="desc"> Minimum budget</div>
            </div>
            <a class="more text-right" href="#what_that" role="button" data-toggle="modal"> <span>Whats that?
                            <i class="icon-question m-icon-white" style="margin-left: 5px;"></i></span>
            </a>
            <div id="what_that" class="modal fade-in" style="padding: 20px 30px 20px 30px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <div style="margin-top: 30px;"> This is your first offer your campaign partner will relate to. The final terms can be negotiated later on after a brands takes interest in your campaign.</div>
                <div style="margin-bottom: 10px;">Cost per view: set the maximum value per unique hit. <br> Picture advertising: number of available picture ads within your software <br>Video advertising: number of available video ads within your software. <br>Minimum budget: set the value of the minimum anticipated budget per campaign partner</div>
                <button type="button" class="btn dark btn-outline" style="float: right;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn btn-circle btn-icon-only btn-default complaint pull-right" style="margin-bottom: 20px;" data-toggle="tooltip" data-placement="top"
           data-original-title="<?= __('Complaint'); ?>">!</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
<!--        --><?// if (!empty($meta->campaign_desc_addition) and !empty($meta->campaign_editor_2)) { ?>
            <div class="panel panel-primary">
                <div class="panel-heading" style="background-color: #f1d00f;">
                    <h3><i class="fa fa-check"></i> <?= $meta->campaign_desc_addition; ?></h3>

                </div>
                <div class="panel-body"
                     style="background-image: url(<?= get_template_directory_uri() ?>/assets/img/mar_bg.jpg);background-repeat: no-repeat; background-size: cover;
                         color: #fff;"><p><?= $meta->campaign_editor_2; ?></p></div>
            </div>
<!--        --><?// } ?>
    </div>
    <div class="col-md-6">
        <?php
        $sliderImages = get_post_meta(get_the_ID(), 'campaignSlider', true);
        //          echo "<pre>";
        //          print_r($sliderImages);
        if (!empty($sliderImages)) {
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2><?= $meta->slider_title; ?></h2>
                </div>
                <div class="panel-body">
                    <div class="sliderPreview">
                        <?php

                        foreach ($sliderImages as $slide) {
                            if ($s3->doesObjectExist($config['s3']['bucket'], $slide)) {
                                $imageUrl = $config["s3"]["cdnPath"] . "/" . $slide;
                                echo '<div><img  src="' . $imageUrl . '" alt="" style="width: 100%;"/></div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
</div>

<div class="row">
    <div class="panel panel-primary cnt_cmpgn_marketplace">
        <div class="panel-heading" style="background-color: #e74c3c;">

            <h3 style="display: inline-block;"><span aria-hidden="true" class="icon-pin"></span> Marketplace
                recommendations</h3>

        </div>

        <div class="panel-body">

            <?php foreach ($posts3 as $key) {
                $cur_id = $key->post_author;
                $all_user_info = get_userdata($cur_id);
                ?>
                <div class="col-md-3">
                    <div class="mt-widget-2">
                        <div class="mt-head" style="position: relative;">
                            <a class="img_cart_cmpgns"
                               style="background-image: url(<?= $config['s3']['cdnPath'] . "/" . urlencode($key->campaign_bg_header_file) ?>);"
                               href="<?= $key->guid ?>"></a>
                            <div class="categ_list_campaign"
                                 style="padding-left: 20px; padding-right: 5px; padding-bottom: 10px; padding-top: 10px; position: absolute; bottom: 0; left: 0;  background: rgba(0,0,0,0.7); width: 100%;">
                                <?
                                $list_categ = get_the_category($key->ID);
                                foreach ($list_categ as $categ) {
                                    ?>
                                    <img data-toggle="tooltip" data-placement="top" title="<?= $categ->name ?>"
                                         style="width:20px; margin: 0px 5px;"
                                         src="<?= get_template_directory_uri() . "/assets/img/categ_icons/" . strtolower($categ->name) ?>.png"
                                         alt="">
                                <? } ?>
                            </div>
                            <div class="categ_list_platform"
                                 style="width: 114px;padding-left: 5px;padding-right: 10px;padding-bottom: 10px; position: absolute;bottom: 0;right: 0;">

                                <?
                                $list_platforms = get_post_meta($key->ID, 'campaign_platform');
                                if (!empty($list_platforms)) {
                                    foreach ($list_platforms[0] as $platform) {
                                        ?>
                                        <img data-toggle="tooltip" data-placement="top"
                                             title="<?= ucfirst($platform) ?>" style="width:20px;"
                                             src="<?= get_template_directory_uri() . "/assets/img/platforms_icon/" . strtolower($platform) ?>.png"
                                             alt="">
                                    <? }
                                } ?>
                            </div>
                            <div class="age_campaign"
                                 style="display: block;position: absolute;right: 0px;top: 0px;width: 50px;height: 50px;padding-top: 10px;padding-right: 10px;">
                                <? if (!empty($key->campaign_age_file)) { ?><img style="width: 100%"
                                                                                 src="<?= $config['s3']['cdnPath'] . "/" . urlencode($key->campaign_age_file) ?>"
                                                                                 alt=""><? } else {
                                    echo "<h4 style='margin: 0;vertical-align: top;text-align: right;color: greenyellow'>0+</h4>>";
                                } ?>
                            </div>
                            <div class="mt-head-user">
                                <div class="mt-head-user-img">
                                    <a href="/profile/?&user_id=<?= $user_info->ID ?>" class="link_cart_cmpg_prf-pic"
                                       style="background-image: url(<?php
                                       if (!empty($user_info->profilePic)) {
                                           echo $user_info->profilePic;
                                       } else {
                                           echo get_template_directory_uri() . "/assets/avatar-4.png";
                                       }
                                       ?>);"></a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-body">
                            <a href="<?= $key->guid ?>" class="cart_link_title_cmpgns"><h3
                                    class="mt-body-title"> <?= $key->post_title; ?> </h3></a>
                            <p class="mt-body-description"> <?= $key->post_content; ?> </p>
                            <ul class="mt-body-stats">
                                <?php
                                $tags = (array)get_the_tags($key->ID);
                                global $wpdb;
                                if (!empty($tags)) {
                                    foreach ($tags as $tag) {
                                        $colors_tags_db = $wpdb->get_results("SELECT DISTINCT color_tag FROM colors_tags WHERE name_tag='" . $tag->slug . "'");
                                        echo "<button style='margin-right: 2px' class=\"btn btn-circle ";
                                        foreach ($colors_tags_db as $clr_tg) {
                                            echo $clr_tg->color_tag;
                                        }
                                        echo "\">$tag->name</button>";
                                    }
                                }


                                ?>
                            </ul>
                            <div class="mt-body-actions">
                                <div class="btn-group btn-group btn-group-justified">
                                    <a href="<?= $key->guid ?>" class="btn">
                                        <i class="fa fa-file-text-o"></i> More details </a>
                                    <?php
                                    $bookmarkCard_db = $wpdb->get_results("SELECT * FROM bookmark WHERE id_users = $cur_user_id AND id_post = $key->ID");

                                    if (!empty($bookmarkCard_db)) { ?>
                                        <a href="javascript:;"
                                           onclick="bookMarkCard(<?= $key->ID; ?>,<?= $cur_user_id ?>,'signedCardMark')"
                                           class="btn profileBtnMark">
                                            <i class="fa fa-bookmark"></i> Signed Mark </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="javascript:;"
                                           onclick="bookMarkCard(<?= $key->ID; ?>,<?= $cur_user_id ?>,'bookmarkCard')"
                                           class="btn profileBtnMark">
                                            <i class="fa fa-bookmark"></i> Bookmark </a>
                                        <?php
                                    }
                                    ?>
                                    <script>
                                        function bookMarkCard(idCart, idUser, typeBtn) {
                                            var idProfile = idCart;
                                            var devIdProfile = idUser;
                                            var btnType = typeBtn;
                                            Data = new Date();
                                            var Year = Data.getFullYear();
                                            var Month = Data.getMonth() + 1;
                                            var Day = Data.getDate();
                                            var Hour = Data.getHours();
                                            var Minutes = Data.getMinutes();
                                            var Seconds = Data.getSeconds();
                                            var out = Year + '-' + Month + '-' + Day + ' ' + Hour + ':' + Minutes + ':' + Seconds;
                                            $.ajax({
                                                type: 'post',
                                                url: "<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php",
                                                data: 'id_user=' + idProfile + '&dev_user=' + devIdProfile + '&profileBtn=' + btnType + '&timeOut=' + out,
                                                success: function (data) {
                                                    window.location.reload();
                                                },
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>
<div class="row">
    <!-- PORTLET MAIN -->
    <div class="col-md-2 portlet light profile-sidebar-portlet ">
        <!-- SIDEBAR USERPIC -->
        <div class="profile-userpic">
            <img src="<?php
            if (!empty($user_info->profilePic)) {
                echo $user_info->profilePic;
            } else {
                echo get_template_directory_uri() . "/assets/avatar-4.png";
            }
            ?>" class="img-responsive" alt=""></div>
        <!-- END SIDEBAR USERPIC -->
        <!-- SIDEBAR USER TITLE -->
        <div class="profile-usertitle">
            <div class="profile-usertitle-name"> <?= $user_info->first_name; ?> <?= $user_info->last_name; ?> </div>
            <div class="profile-usertitle-job"> <?= $user_info->roles[0]; ?> </div>
        </div>
        <!-- END SIDEBAR USER TITLE -->
        <!-- SIDEBAR BUTTONS -->
        <div class="profile-userbuttons">
            <?
            $argsProfile = get_user_meta($cur_user_id, 'follow_id', false);
            for ($i = 0; $i < count($argsProfile); $i++) {
                if ($argsProfile[$i] == $userIdProfile) {
                    $existingId = $userIdProfile;
                    break;
                }
            }
            if ($cur_user_id != $userIdProfile) {
                if (!empty($existingId)) { ?>
                    <form method="post" id="profileSigned" class="profile-signed"
                          action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                        <button type="button" id="profileBtn" class="btn btn-circle green btn-sm" name="profileBtn"
                                value="signed">Signed
                        </button>
                    </form>
                    <?php
                } else {
                    ?>
                    <form method="post" id="profileSigned" class="profile-signed"
                          action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                        <button type="button" id="profileBtn" class="btn btn-circle green btn-sm" name="profileBtn"
                                value="follow">Follow
                        </button>
                    </form>
                    <?php
                }
            }
            ?>
        </div>
        <!-- END SIDEBAR BUTTONS -->
    </div>
    <!-- END PORTLET MAIN -->
    <!-- PORTLET MAIN -->
    <div class="col-md-4 portlet light ">
        <div>
            <h4 class="profile-desc-title">About <?= $user_info->companyname; ?></h4>
            <span class="profile-desc-text"> <?= $user_info->about_short; ?></span>

            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-globe"></i>
                <a href="http://<?= $user_info->web_site; ?>" target="_blank"><?= $user_info->web_site; ?></a>
            </div>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-twitter"></i>
                <a href="https://twitter.com/<?= $user_info->link_twitter; ?>"
                   target="_blank"><?= $user_info->link_twitter; ?></a>
            </div>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-facebook"></i>
                <a href="https://www.facebook.com/<?= $user_info->link_facebook; ?>"
                   target="_blank"><?= $user_info->link_facebook; ?></a>
            </div>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-instagram"></i>
                <a href="https://www.instagram.com/<?= $user_info->link_instagram; ?>"
                   target="_blank"><?= $user_info->link_instagram; ?></a>
            </div>
        </div>
    </div>

    <!-- END PORTLET MAIN -->
    <div class="col-md-6">
        <!-- BEGIN BASIC PORTLET-->
        <div class="portlet light portlet-fit bordered profile-map">
            <div id="map"></div>
            <script>
                function initMap() {
                    var map = new google.maps.Map(document.getElementById('map'), {zoom: 8});
                    var geocoder = new google.maps.Geocoder;
                    geocoder.geocode({'address': '<?=$user_info->address;?>'}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            map.setCenter(results[0].geometry.location);
                            new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location
                            });
                        } else {
                            window.alert('Geocode was not successful for the following reason: ' +
                                status);
                        }
                    });
                }
            </script>
            <div class="profile-map__block">
                <h2><?= $user_info->companyname; ?></h2>
                <span class="bg-blue font-white uppercase">address</span>
                <p><?= $user_info->address; ?></p>
                <p><?= $countriProfile; ?></p>
                <span class="bg-blue font-white uppercase">Contacts</span>
                <p><span class="bold uppercase">T </span><?= $user_info->phone; ?></p>
                <p><span class="bold uppercase">F </span><?= $user_info->fax; ?></p>
                <span class="bg-blue font-white uppercase">Social</span>
                <div>
                    <a href="#" class="socicon-btn socicon-twitter tooltips font-blue bg-default"
                       data-original-title="Twitter"></a>
                    <a href="#" class="socicon-btn socicon-facebook tooltips font-blue bg-default"
                       data-original-title="Facebook"></a>
                    <a href="#" class="socicon-btn socicon-youtube tooltips font-blue bg-default"
                       data-original-title="Youtube"></a>
                    <a href="#" class="socicon-btn socicon-linkedin tooltips font-blue bg-default"
                       data-original-title="Linkedin"></a>
                </div>
            </div>
        </div>
        <!-- END BASIC PORTLET-->
    </div>


</div>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('body').on('click', 'a.complaint', function (event) // вешаем обработчик на все ссылки, даже созданные после загрузки страницы
        {
            var complaint = $(this);
            complaint.removeClass('btn-circle, btn-icon-only').addClass('yellow-lemon');
            complaint.html('Sending')
            event.preventDefault(); // предотвращаем штатное действие, то есть переход по ссылке
            $.post('<?=get_template_directory_uri()?>/inc/send-complain.php', {
                idCampaign: "<?=the_ID()?>",
                nameCampaign: "<?=the_title()?>",
                linkCampaign: "<?=the_permalink()?>",
                idDeveloper: "<?=$user_info->ID?>",
                nameDeveloper: "<?=$user_info->companyname?>",
                linkDeveloper: "<?=get_site_url()?>/profile/?&user_id=<?=$user_info->ID?>"
            }, function (data) // отправляем GET запрос на href, указанный в ссылке
            {
                complaint.removeClass('yellow-lemon').addClass('green-jungle');
                complaint.html('<i class="fa fa-check"></i>&nbsp;' + data); // выводим полученные данные в консоль.
            })
        });
    })

</script>
