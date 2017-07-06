<?php
/*
 * Template name: Campaign Marketplace
 */

get_header('dashboard');

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN THEME PANEL -->
        <?php require_once 'inc/campaing-error.php'; ?>
        <div class="profile-title">
            <h2><?php wp_title("", true); ?></h2>
        </div>
        <!-- END THEME PANEL -->
        <!-- BEGIN PAGE BAR -->
        <?php require_once 'template-parts/breadcrumbs.php'; ?>
        <!-- END PAGE BAR -->
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS 1-->
        <!-- Begin button save and public -->

        <form id="campaign-form" action="<?php echo get_stylesheet_directory_uri() ?>/inc/campaign-registration.php" enctype="multipart/form-data" method="POST">
            <div class="button-menu">
                <div class="row">
                    <div class="col-md-3">
                        <span> > Create a new campaign</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <button name="active" value="publish" class="btn green-jungle"><i class="fa fa-chevron-down"></i> Publish campaign </button>
                        <button name="active" value="save" class="btn yellow-gold"><i class="fa fa-chevron-down"></i> Save capaign </button>
                        <a class="btn blue float-right preview" data-toggle="modal" href="#full"> <i class="icon-magnifier"></i> Preview </a>
                    </div>
                </div>
            </div>
            <!-- End button save and public -->
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label><strong>New compaign title</strong></label>
                        <input type="text" name="compaign_title" class="form-control " placeholder="">
                    </div>
                </div>
            </div>
            <!-- BEGIN New campaign header img -->
            <div class="row">
                <div class="campaign">
                    <div class="fileinput fileinput-new campaign-block-setting" data-provides="fileinput">
                        <div class="fileinput-new thumbnail campaign-img">
                            <img src="<?=get_template_directory_uri()?>/assets/no-image.jpg" alt=""> </div>
                        <div class="fileinput-preview fileinput-exists thumbnail campaign-img"> </div>
                        <div>
                                         <span class="btn default btn-file campaign-img-btn">
                                              <span class="fileinput-new"> Select image </span>
                                              <span class="fileinput-exists"> Change </span>
                                             <?php wp_nonce_field( 'campaign-bg-header', 'campaign-bg-header-Upload' ); ?>
                                             <input type="file" name="campaign-bg-header" id="campaign-bg-header" accept="image/jpeg,image/png,image/gif">
                                         </span>
                            <a href="javascript:;" class="btn red fileinput-exists campaign-img-remove" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>
                    <div class="profile-company">
                        <? if($user_info->user_login=='developer4'){?><img src="<?=get_template_directory_uri()?>/assets/pages/img/flag/de.png" width="34" height="34" alt="Сountry flag" class="profile-company__img">
                        <?}else{?><img src="<?=get_template_directory_uri()?>/assets/pages/img/flag/united-states-of-america.png" alt="Сountry flag" class="profile-company__img"><?}?>
                        <h2 class="profile-company__name"><?=$user_info->companyname ?></h2>
                        <p class="profile-company__address"><?=$user_info->address ?>, <?=$user_info->country ?></p>
                    </div>
                    <div class="campaign-age-push">
                        <div class="form-body">
                            <div class="form-group last">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                                                <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <?php wp_nonce_field( 'campaign-age', 'campaign-age-Upload' ); ?>
                                                                    <input type="file" name="campaign-age" id="campaign-age" accept="image/jpeg,image/png,image/gif">
                                                                </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10"></div>

                            </div>
                        </div>
                    </div>
                    <div class="profile-user">
                        <button class="btn green">Connect</button>
                        <img src="<?=$user_info->profilePic; ?>" class="profile-user__img" alt="<?=$user_info->user_nicename ?>">
                        <button class="btn green-haze">Bookmark</button>
                    </div>
                    <!-- Begin andbee Hash tag -->
                    <div class="input__hashtags">
                        <ul class="hashtag__list">
                            <li class="hashtag__input"><input type="text" class="hashtags" placeholder="add a tag"></li>
                        </ul>
                    </div>
                    <!-- End andbee Hash tag -->

                </div>
            </div>
            <!-- END New campaign header img -->

            <!-- Begin main block -->
            <div class="main-compaing">
                <div class="row">
                    <div class="col-md-6">
                        <div cla4ss="compaign-info-form">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><strong>Title description</strong></label>
                                    <input type="text" name="campaign-description" class="form-control " placeholder="">
                                </div>
                            </div>

                        </div>
                                    <textarea name="editor1" id="editor1" rows="10" cols="80">
                                    </textarea>
                        <script>
                            // Replace the <textarea id="editor1"> with a CKEditor
                            // instance, using default configuration.
                            CKEDITOR.replace( 'editor1',{
                              'filebrowserBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                               'filebrowserImageBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                               'filebrowserFlashBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                               'filebrowserUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                               'filebrowserImageUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                               'filebrowserFlashUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                             } );
                        </script>
                    </div>
                    <div class="col-md-6">
                        <div class="compaign-info-form">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><strong>Youtube title</strong></label>
                                    <input type="text" name="campaign-yt-title" class="form-control " placeholder="">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label><strong>Url youtube</strong></label>
                                <input type="text" name="campaign-yt-url" class="form-control">
                            </div>

                        </div>
                        <div class="image-game">
                            <br><label><strong>Image game</strong></label><br>
                            <div class="form-group last compaign-info__photo">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail compaign-info__setting">
                                        <img src="http://www.placehold.it/600x350/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" > </div>
                                    <div>
                                                        <span class="btn default btn-file compaign-info__btn">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <?php wp_nonce_field( 'campaign-image', 'campaign-image-Upload' ); ?>
                                                            <input type="file" name="campaign-image" id="campaign-image" accept="image/jpeg,image/png,image/gif">
                                                        </span>
                                        <a href="javascript:;" class="btn red fileinput-exists compaign-info__reset" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10"></div>
                            </div>
                        </div>
                        <div class="image-game">
                            <label><strong>Background</strong></label><br>
                            <div class="form-group last compaign-info__photo">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail compaign-info__setting">
                                        <img src="http://www.placehold.it/600x350/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" > </div>
                                    <div>
                                                        <span class="btn default btn-file compaign-info__btn">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <?php wp_nonce_field( 'campaign-bg', 'campaign-bg-Upload' ); ?>
                                                            <input type="file" name="campaign-bg" id="campaign-bg" accept="image/jpeg,image/png,image/gif">
                                                        </span>
                                        <a href="javascript:;" class="btn red fileinput-exists compaign-info__reset" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End main block -->


            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <img src="<?=get_template_directory_uri()?>/assets/pages/img/profile/visible-opened-eye-interface-option.png" alt="" >
                        </div>
                        <div class="details">
                            <div class="number"> 12.127.268 </div>
                            <div class="desc"> Total Views </div>
                        </div>
                        <a class="more" href="javascript:;"> More details
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <img src="<?=get_template_directory_uri()?>/assets/pages/img/profile/gamepad-controller.png" alt="" >
                        </div>
                        <div class="details">
                            <div class="number"> 4 </div>
                            <div class="desc"> Games currently available </div>
                        </div>
                        <a class="more" href="javascript:;"> More details
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue-soft">
                        <div class="visual">
                            <img src="<?=get_template_directory_uri()?>/assets/pages/img/profile/vreo_icon_text_light.png" alt="" >
                        </div>
                        <div class="details">
                            <div class="number"> ~0,05  &#8364;</div>
                            <div class="desc"> Cost per view </div>
                        </div>
                        <a class="more" href="javascript:;"> Whats that?
                            <i class="icon-question m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green-jungle">
                        <div class="visual">
                            <img src="<?=get_template_directory_uri()?>/assets/pages/img/profile/check-mark.png" alt="" >
                        </div>
                        <div class="details">
                            <div class="number"> 58 </div>
                            <div class="desc"> Total campaigns </div>
                        </div>
                        <a class="more" href="javascript:;"> More details
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <!-- END DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="compaign-info-form">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label><strong>Title description addition</strong></label>
                                <input type="text" name="campaign-desc-addition" class="form-control " placeholder="">
                            </div>
                        </div>

                    </div>
                                    <textarea name="editor2" id="editor1" rows="10" cols="80">

                                    </textarea>
                    <script>
                        // Replace the <textarea id="editor1"> with a CKEditor
                        // instance, using default configuration.
                        CKEDITOR.replace( 'editor2',{
                          'filebrowserBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                           'filebrowserImageBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                           'filebrowserFlashBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                           'filebrowserUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                           'filebrowserImageUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                           'filebrowserFlashUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                         } );
                    </script>
                </div>
            </div>
            <!-- Begin button save and public -->
            <div class="button-menu__bottom">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button name="active" value="publish" class="btn green-jungle"><i class="fa fa-chevron-down"></i> Publish campaign </button>
                        <button name="active" value="save" class="btn yellow-gold"><i class="fa fa-chevron-down"></i> Save capaign </button>
                      <a class="btn blue float-right preview" data-toggle="modal" href="#full"> <i class="icon-magnifier"></i> Preview </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- End button save and public -->
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
                    <button type="button" class="btn btn-circle green btn-sm">Connect</button>
                    <button type="button" class="btn btn-circle red btn-sm">Message</button>
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
                        <p><?=$user_info->country;?></p>
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
            <div class="tab-content">
                <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                    <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                        <h3 class="list-heading">Staff</h3>
                        <ul class="media-list list-items">
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-success">8</span>
                                </div>
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar3.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Bob Nilson</h4>
                                    <div class="media-heading-sub"> Project Manager </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar1.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Nick Larson</h4>
                                    <div class="media-heading-sub"> Art Director </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-danger">3</span>
                                </div>
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar4.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Deon Hubert</h4>
                                    <div class="media-heading-sub"> CTO </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar2.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Ella Wong</h4>
                                    <div class="media-heading-sub"> CEO </div>
                                </div>
                            </li>
                        </ul>
                        <h3 class="list-heading">Customers</h3>
                        <ul class="media-list list-items">
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-warning">2</span>
                                </div>
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar6.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Lara Kunis</h4>
                                    <div class="media-heading-sub"> CEO, Loop Inc </div>
                                    <div class="media-heading-small"> Last seen 03:10 AM </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="label label-sm label-success">new</span>
                                </div>
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar7.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Ernie Kyllonen</h4>
                                    <div class="media-heading-sub"> Project Manager,
                                        <br> SmartBizz PTL </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar8.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Lisa Stone</h4>
                                    <div class="media-heading-sub"> CTO, Keort Inc </div>
                                    <div class="media-heading-small"> Last seen 13:10 PM </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-success">7</span>
                                </div>
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar9.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Deon Portalatin</h4>
                                    <div class="media-heading-sub"> CFO, H&D LTD </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar10.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Irina Savikova</h4>
                                    <div class="media-heading-sub"> CEO, Tizda Motors Inc </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-danger">4</span>
                                </div>
                                <img class="media-object" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar11.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Maria Gomez</h4>
                                    <div class="media-heading-sub"> Manager, Infomatic Inc </div>
                                    <div class="media-heading-small"> Last seen 03:10 AM </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="page-quick-sidebar-item">
                        <div class="page-quick-sidebar-chat-user">
                            <div class="page-quick-sidebar-nav">
                                <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                    <i class="icon-arrow-left"></i>Back</a>
                            </div>
                            <div class="page-quick-sidebar-chat-user-messages">
                                <div class="post out">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> When could you send me the report ? </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> Its almost done. I will be sending it shortly </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> Alright. Thanks! :) </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:16</span>
                                        <span class="body"> You are most welcome. Sorry for the delay. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> No probs. Just take your time :) </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:40</span>
                                        <span class="body"> Alright. I just emailed it to you. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> Great! Thanks. Will check it right away. </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:40</span>
                                        <span class="body"> Please let me know if you have any comment. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="<?=get_template_directory_uri()?>/assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> Sure. I will check and buzz you if anything needs to be corrected. </span>
                                    </div>
                                </div>
                            </div>
                            <div class="page-quick-sidebar-chat-user-form">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Type a message here...">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn green">
                                            <i class="icon-paper-clip"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                    <div class="page-quick-sidebar-alerts-list">
                        <h3 class="list-heading">General</h3>
                        <ul class="feeds list-items">
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 4 pending tasks.
                                                            <span class="label label-sm label-warning "> Take action
                                                                <i class="fa fa-share"></i>
                                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> Just now </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> Finance Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-danger">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New order received with
                                                <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 30 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-bell-o"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                <span class="label label-sm label-warning"> Overdue </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 2 hours </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-default">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> IPO Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <h3 class="list-heading">System</h3>
                        <ul class="feeds list-items">
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 4 pending tasks.
                                                            <span class="label label-sm label-warning "> Take action
                                                                <i class="fa fa-share"></i>
                                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> Just now </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-danger">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> Finance Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New order received with
                                                <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 30 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-warning">
                                                <i class="fa fa-bell-o"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                <span class="label label-sm label-default "> Overdue </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 2 hours </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> IPO Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                    <div class="page-quick-sidebar-settings-list">
                        <h3 class="list-heading">General Settings</h3>
                        <ul class="list-items borderless">
                            <li> Enable Notifications
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Allow Tracking
                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Log Errors
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Auto Sumbit Issues
                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Enable SMS Alerts
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                        </ul>
                        <h3 class="list-heading">System Settings</h3>
                        <ul class="list-items borderless">
                            <li> Security Level
                                <select class="form-control input-inline input-sm input-small">
                                    <option value="1">Normal</option>
                                    <option value="2" selected>Medium</option>
                                    <option value="e">High</option>
                                </select>
                            </li>
                            <li> Failed Email Attempts
                                <input class="form-control input-inline input-sm input-small" value="5" /> </li>
                            <li> Secondary SMTP Port
                                <input class="form-control input-inline input-sm input-small" value="3560" /> </li>
                            <li> Notify On System Error
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Notify On SMTP Error
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                        </ul>
                        <div class="inner-content">
                            <button class="btn btn-success">
                                <i class="icon-settings"></i> Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END QUICK SIDEBAR -->


<?php
get_footer('dashboard');
