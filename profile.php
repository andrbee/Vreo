<?php
/*
 * Template name: Profile
 */

get_header('dashboard');
$cur_user_id = empty($_GET['user_id'])? get_current_user_id():$_GET['user_id'];
$user_info = get_userdata($cur_user_id);
$tags=(array)get_the_tags();
if(!empty($tags)){
    foreach($tags as $tag) {
        $masiv[] = $tag->slug;
    }
}


$args = array(
    'author' => $user_info->ID,
    'post_status' => 'publish ',
    'tag' => $masiv
);
$posts3 = get_posts( $args );
//add_user_meta( '69', 'id_follow', "14", false );
$userIdProfile = get_current_user_id();
?>

<!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->

                        <div class="profile-title">
                        	<h2><?php wp_title("", true); ?></h2>
                        </div>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
						            <?php require_once 'template-parts/breadcrumbs.php'; ?>
                        <!-- END PAGE BAR -->
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        <!-- BEGIN PROFILE IMG -->
                        <div class="row">
                        	<div class="profile">
                        		<img src="<?=$user_info->profileHeaderPic; ?>" class="profile-img" alt="profile background users">
                        		<div class="profile-company">
                                    <? if($user_info->user_login=='developer4'){?><img src="<?=get_template_directory_uri()?>/assets/pages/img/flag/de.png" width="34" height="34" alt="Сountry flag" class="profile-company__img">
                                    <?}else{?><img src="<?=get_template_directory_uri()?>/assets/img/flags/<?=strtolower($user_info->country);?>.png" width="34" height="34" alt="Сountry flag" class="profile-company__img"><?}?>
                        			<h2 class="profile-company__name"><?=$user_info->companyname ?></h2>
                              <?php
                                require_once('template-parts/countries.php');
                                foreach ($countries as $key => $value) {
                                    if ($user_info->country == $key) {
                                      $countriProfile = $value;
                                      break;
                                    }
                                  }
                              ?>
                        			<p class="profile-company__address"><?=$user_info->address ?>, <?=$countriProfile;?></p>
                        		</div>
                        		<div class="profile-user">
                                    <?
                                    $argsProfile =  get_user_meta( $cur_user_id, 'follow_id', false );
                                    for ($i = 0; $i<count($argsProfile); $i++) {
                                        if ($argsProfile[$i] == $userIdProfile){
                                          $existingId = $userIdProfile;
                                          break;
                                        }
                                    }
                                    if ($cur_user_id != $userIdProfile){
                                    if (!empty($existingId)) { ?>
                                      <form method="post" id="profileSigned" class="profile-signed" action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                                        <button type="submit" id="profileBtn" class="btn green" name="profileBtn" value="signed">Signed</button>
                                      </form>
                                      <?php
                                    } else {
                                      ?>
                                      <form method="post" id="profileSigned" class="profile-signed" action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                                        <button type="submit" id="profileBtn" class="btn green" name="profileBtn" value="follow">Connect</button>
                                      </form>
                                      <?php
                                    } }
                                    ?>
                        			<img src="<?php
                                    if(!empty($user_info->profilePic)){
                                        echo $user_info->profilePic;
                                    } else {
                                        echo get_template_directory_uri()."/assets/avatar-4.png";
                                    }
                                    ?>" class="profile-user__img" alt="<?=$user_info->user_nicename ?>">
                              <?php
                                 global $wpdb;
                                $bookmarkProfile_db = $wpdb->get_results( "SELECT * FROM bookmark WHERE id_users = $userIdProfile AND id_post = $cur_user_id");
                                if ($cur_user_id != $userIdProfile) {
                                if (!empty($bookmarkProfile_db)) { ?>
                                  <form method="post" id="profileBookmark" class="profile-signed" action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                                    <button type="submit" id="profileBtnMark" class="btn green-haze" name="profileBtn" value="signedMark">Signed Mark</button>
                                  </form>
                                  <?php
                                } else {
                                  ?>
                                  <form method="post" id="profileBookmark" class="profile-signed" action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                                    <button type="submit" id="profileBtnMark" class="btn green-haze" name="profileBtn" value="bookmark">Bookmark</button>
                                  </form>
                                  <?php
                                } }
                              ?>
                        		</div>
                        	</div>
                        </div>
                      <script>
                        $('#profileSigned').submit(function(e) {
                          var $form = $(this);
                          var idProfile = <?=$userIdProfile;?>;
                          var devIdProfile = <?=$cur_user_id?>;
                          var btnClick = document.getElementById('profileBtn').value;
                          Data = new Date();
                          var Year = Data.getFullYear();
                          var Month = Data.getMonth() + 1;
                          var Day = Data.getDate();
                          var Hour = Data.getHours();
                          var Minutes = Data.getMinutes();
                          var Seconds = Data.getSeconds();
                          var out = Year+'-'+Month+'-'+Day+' '+Hour+':'+Minutes+':'+Seconds;
                          $.ajax({
                            type: $form.attr('method'),
                            url: $form.attr('action'),
                            data: 'id_user='+idProfile+'&dev_user='+devIdProfile+'&profileBtn='+btnClick+'&timeOut='+out,
                            success: function (data) {
                              window.location.reload();
                            },
                          });
                          e.preventDefault();
                        });
                        $('#profileBookmark').submit(function(e) {
                          var $form = $(this);
                          var idProfile = <?=$userIdProfile;?>;
                          var devIdProfile = <?=$cur_user_id?>;
                          var btnClick = document.getElementById('profileBtnMark').value;
                          Data = new Date();
                          var Year = Data.getFullYear();
                          var Month = Data.getMonth() + 1;
                          var Day = Data.getDate();
                          var Hour = Data.getHours();
                          var Minutes = Data.getMinutes();
                          var Seconds = Data.getSeconds();
                          var out = Year+'-'+Month+'-'+Day+' '+Hour+':'+Minutes+':'+Seconds;
                          $.ajax({
                            type: $form.attr('method'),
                            url: $form.attr('action'),
                            data: 'id_user='+idProfile+'&dev_user='+devIdProfile+'&profileBtn='+btnClick+'&timeOut='+out,
                            success: function (data) {
                              window.location.reload();
                            },
                          });
                          e.preventDefault();
                        });
                      </script>
                        <!-- END PROFILE IMG -->
                      <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
                                <div class="dashboard-stat blue">
                                    <div class="visual">
                                       <img src="<?=get_template_directory_uri()?>/assets/pages/img/profile/visible-opened-eye-interface-option.png" alt="" >
                                    </div>
                                    <div class="details">
                                        <div class="number"> <?=count_user_posts( $cur_user_id ); ?>  </div>
                                        <div class="desc"> Total campaign views </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="dashboard-stat blue-soft">
                                    <div class="visual">
                                        <img src="<?=get_template_directory_uri()?>/assets/pages/img/profile/vreo_icon_text_light.png" alt="" >
                                    </div>
                                    <div class="details">
                                        <div class="number"> 0 </div>
                                        <div class="desc"> Cooperating brands </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="dashboard-stat green-jungle">
                                    <div class="visual">
                                         <img src="<?=get_template_directory_uri()?>/assets/pages/img/profile/check-mark.png" alt="" >
                                    </div>
                                    <?php
                                      $postList =query_posts(array('author'   => $cur_user_id, 'post_status' =>  'completed'));
                                    ?>
                                    <div class="details">
                                        <div class="number"> <?=count($postList);?> </div>
                                        <div class="desc"> Total campaigns </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="dashboard-stat red">
                                    <div class="visual">
                                       <img src="<?=get_template_directory_uri()?>/assets/pages/img/profile/gamepad-controller.png" alt="" >
                                    </div>
                                    <div class="details">
                                        <div class="number"> <?=count_user_posts($cur_user_id ); ?> </div>
                                        <div class="desc"> Campaigns currently available </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <!-- END DASHBOARD STATS 1-->
                        <div class="row">
                            <!-- BEGIN INTERACTIVE CHART PORTLET-->
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title bg-blue-soft bg-font-blue-soft">
                                        <div class="caption ">
                                            <span class="caption-subject  sbold uppercase font-white">About</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <?=$user_info->description;?>
                                    </div>
                                </div>
                                <!-- END INTERACTIVE CHART PORTLET-->
                        </div>
                        <div class="row profile-social">
                            <!-- <div class="col-md-3 bg-grey-mint bg-font-grey-mint"> -->

                            <div class="col-md-3">
                                <div class=" profile-social__title">Social media</div>

                                <div class="mt-step-content font-grey-cascade">Join <strong><?=$user_info->companyname;?></strong> on<br>
                                instagram, facebook and twitter

                                </div>
                            </div>
<!--                            <a href="https://www.instagram.com/--><?//=$user_info->link_instagram;?><!--" target="_blank" class="socicon-btn socicon-btn-circle socicon-solid bg-green font-white bg-hover-grey-salsa socicon-instagram tooltips">-->
<!--                            </a> -->
<!--                              <a href="https://www.facebook.com/--><?//=$user_info->link_facebook;?><!--" target="_blank" class="socicon-btn socicon-btn-circle socicon-solid bg-yellow font-white bg-hover-grey-salsa socicon-facebook tooltips">-->
<!--                              </a>-->
<!--                            <a href="https://twitter.com/--><?//=$user_info->link_twitter;?><!--" target="_blank" class="socicon-btn socicon-btn-circle socicon-solid bg-blue font-white bg-hover-grey-salsa socicon-twitter tooltips">-->
<!--                            </a>-->
                            <a href="https://www.facebook.com/<?=$user_info->link_facebook;?>" target="_blank" class="socicon-btn-facebook">
                                </a>
                                <a href="https://twitter.com/<?=$user_info->link_twitter;?>" target="_blank" class="socicon-btn-twitter">
                                </a>
                        </div>
                        <div class="row profile-banner">
                            <div class="col-md-6">
                                <?=$user_info->text_left;?>
                            </div>
                            <div class="col-md-6">
                                <?=$user_info->text_right;?>
                            </div>
                        </div>
                        <?if(!empty($posts3)){?>
                        <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-heading" style="background-color: #e74c3c;">
                                    <h3 style="display: inline-block;"><span aria-hidden="true" class="icon-pin"></span> <?=$user_info->companyname;?> current campaign</h3>
                                </div>

                                <div class="panel-body">

                                    <?php foreach ($posts3 as $key){
                                        $cur_id = $key->post_author;
                                        $all_user_info = get_userdata($cur_id);
                                        ?>
                                        <div class="col-md-3">
                                            <div class="mt-widget-2">
                                                <div class="mt-head" style="position: relative;">
                                                    <a class="img_cart_cmpgns" style="background-image: url(<?=$key->campaign_bg_header;?>);" href="<?=$key->guid?>"></a>
                                                    <div class="categ_list_campaign" style="padding-left: 20px; padding-right: 5px; padding-bottom: 10px; padding-top: 10px; position: absolute; bottom: 0; left: 0;  background: rgba(0,0,0,0.7); width: 100%;">
                                                        <?
                                                        $list_categ=get_the_category($key->ID);
                                                        foreach ($list_categ as $categ){?>
                                                            <img data-toggle="tooltip" data-placement="top" title="<?=$categ->name?>" style="width:20px; margin: 0px 5px;" src="<?=get_template_directory_uri()."/assets/img/categ_icons/".strtolower($categ->name)?>.png" alt="">
                                                        <?}?>
                                                    </div>
                                                    <div class="categ_list_platform" style="width: 114px;padding-left: 5px;padding-right: 10px;padding-bottom: 10px; position: absolute;bottom: 0;right: 0;">

                                                        <?
                                                        $list_platforms=get_post_meta( $key->ID, 'campaign_platform');
                                                        if(!empty($list_platforms)){
                                                            foreach ($list_platforms[0] as $platform){?>
                                                                <img data-toggle="tooltip" data-placement="top" title="<?=ucfirst($platform) ?>" style="width:20px;" src="<?=get_template_directory_uri()."/assets/img/platforms_icon/".strtolower($platform)?>.png" alt="">
                                                            <?}}?>
                                                    </div>
                                                    <div class="age_campaign" style="display: block;position: absolute;right: 0px;top: 0px;width: 50px;height: 50px;padding-top: 10px;padding-right: 10px;">
                                                        <?if(!empty($key->campaign_age)){?><img style="width: 100%" src="<?=$key->campaign_age?>" alt=""><?} else{echo "<h4 style='margin: 0;vertical-align: top;text-align: right;color: greenyellow'>0+</h4>>";}?>
                                                    </div>
                                                    <div class="mt-head-user">
                                                        <div class="mt-head-user-img">
                                                            <a href="/profile/?&user_id=<?=$user_info->ID?>" class="link_cart_cmpg_prf-pic" style="background-image: url(<?=$user_info->profilePic; ?>);"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-body">
                                                    <a href="<?=$key->guid?>" class="cart_link_title_cmpgns"><h3 class="mt-body-title"> <?=$key->post_title;?> </h3></a>
                                                    <p class="mt-body-description"> <?=$key->post_content;?> </p>
                                                    <ul class="mt-body-stats">
                                                        <?php
                                                        $tags=(array)get_the_tags($key->ID);
                                                        global $wpdb;
                                                        if(!empty($tags)){
                                                            foreach($tags as $tag) {
                                                                $colors_tags_db = $wpdb->get_results( "SELECT DISTINCT color_tag FROM colors_tags WHERE name_tag='".$tag->slug."'" );
                                                                echo "<button style='margin-right: 2px' class=\"btn btn-circle ";
                                                                foreach ($colors_tags_db as $clr_tg){
                                                                    echo $clr_tg->color_tag;
                                                                }
                                                                echo "\">$tag->name</button>";
                                                            }
                                                        }


                                                        ?>
                                                    </ul>
                                                    <div class="mt-body-actions">
                                                        <div class="btn-group btn-group btn-group-justified">
                                                            <a href="<?=$key->guid?>" class="btn">
                                                                <i class="fa fa-file-text-o"></i> More details </a>
                                                          <?php
                                                          $bookmarkCard_db = $wpdb->get_results( "SELECT * FROM bookmark WHERE id_users = $userIdProfile AND id_post = $key->ID");

                                                          if (!empty($bookmarkCard_db)) { ?>
                                                            <a href="javascript:;" onclick="bookMarkCard(<?=$key->ID;?>,<?=$userIdProfile?>,'signedCardMark')" class="btn profileBtnMark">
                                                              <i class="fa fa-bookmark"></i> Signed Mark </a>
                                                            <?php
                                                          } else {
                                                            ?>
                                                            <a href="javascript:;" onclick="bookMarkCard(<?=$key->ID;?>,<?=$userIdProfile?>,'bookmarkCard')" class="btn profileBtnMark" >
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
                                                              var out = Year+'-'+Month+'-'+Day+' '+Hour+':'+Minutes+':'+Seconds;
                                                              $.ajax({
                                                                type: 'post',
                                                                url: "<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php",
                                                                data: 'id_user='+idProfile+'&dev_user='+devIdProfile+'&profileBtn='+btnType+'&timeOut='+out,
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
                        <?}?>
                        <div class="row">
                                    <!-- PORTLET MAIN -->
                                    <div class="col-md-2 portlet light profile-sidebar-portlet ">
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                            <img src="<?=$user_info->profilePic; ?>" class="img-responsive" alt=""> </div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> <?=$user_info->first_name;?> <?=$user_info->last_name;?> </div>
                                            <div class="profile-usertitle-job"> <?=$user_info->roles[0];?> </div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                        <!-- SIDEBAR BUTTONS -->

                                        <div class="profile-userbuttons">
                                          <?
                                          $argsProfile =  get_user_meta( $cur_user_id, 'follow_id', false );
                                          for ($i = 0; $i<count($argsProfile); $i++) {
                                            if ($argsProfile[$i] == $userIdProfile){
                                              $existingId = $userIdProfile;
                                              break;
                                            }
                                          }
                                          if ($cur_user_id != $userIdProfile){
                                            if (!empty($existingId)) { ?>
                                              <form method="post" id="profileSigned" class="profile-signed" action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                                                <button type="button" id="profileBtn" class="btn btn-circle green btn-sm" name="profileBtn" value="signed">Signed</button>
                                              </form>
                                              <?php
                                            } else {
                                              ?>
                                              <form method="post" id="profileSigned" class="profile-signed" action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-signed.php">
                                                           <button type="button" id="profileBtn" class="btn btn-circle green btn-sm" name="profileBtn" value="follow">Connect</button>
                                              </form>
                                              <?php
                                            } }
                                          ?>
                                        </div>

                                        <!-- END SIDEBAR BUTTONS -->
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                    <!-- PORTLET MAIN -->
                                    <div class="col-md-4 portlet light ">
                                        <div>
                                            <h4 class="profile-desc-title">About <?=$user_info->companyname;?></h4>
                                            <span class="profile-desc-text"> <?=$user_info->about_short;?></span>

                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-globe"></i>
                                                <a href="http://<?=$user_info->web_site;?>" target="_blank"><?=$user_info->web_site;?></a>
                                            </div>
                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-twitter"></i>
                                                <a href="https://twitter.com/<?=$user_info->link_twitter;?>" target="_blank"><?=$user_info->link_twitter;?></a>
                                            </div>
                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-facebook"></i>
                                                <a href="https://www.facebook.com/<?=$user_info->link_facebook;?>" target="_blank"><?=$user_info->link_facebook;?></a>
                                            </div>
                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-instagram"></i>
                                                <a href="https://www.instagram.com/<?=$user_info->link_instagram;?>" target="_blank"><?=$user_info->link_instagram;?></a>
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
                                                  geocoder.geocode({'address': '<?=$user_info->address;?>'}, function(results, status) {
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
                                            <h2><?=$user_info->companyname;?></h2>
                                            <span class="bg-blue font-white uppercase">address</span>
                                            <p><?=$user_info->address;?></p>
                                            <p><?=$countriProfile;?></p>
                                            <span class="bg-blue font-white uppercase">Contacts</span>
                                            <p><span class="bold uppercase">T </span><?=$user_info->phone;?></p>
                                            <p><span class="bold uppercase">F </span><?=$user_info->fax;?></p>
                                            <span class="bg-blue font-white uppercase">Social</span>
                                            <div>
                                                <a href="#" class="socicon-btn socicon-twitter tooltips font-blue bg-default" data-original-title="Twitter"></a>
                                                <a href="#" class="socicon-btn socicon-facebook tooltips font-blue bg-default" data-original-title="Facebook"></a>
                                                <a href="#" class="socicon-btn socicon-youtube tooltips font-blue bg-default" data-original-title="Youtube"></a>
                                                <a href="#" class="socicon-btn socicon-linkedin tooltips font-blue bg-default" data-original-title="Linkedin"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END BASIC PORTLET-->
                                </div>


                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                    <div class="page-quick-sidebar">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                                    <span class="badge badge-danger">2</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alerts
                                    <span class="badge badge-success">7</span>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> More
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-bell"></i> Alerts </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-info"></i> Notifications </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-speech"></i> Activities </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-settings"></i> Settings </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                </div>
                <!-- END QUICK SIDEBAR -->

    <script> $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
<?php
get_footer('dashboard');
