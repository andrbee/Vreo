<?php
/*
 * Template name: Edit Campaign
 */
get_header('dashboard');
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$postID = $_POST['edit'];
$postList = query_posts(array('p' => $postID, 'author' => $cur_user_id, 'post_status' => array('publish ', 'draft', 'completed')));
require 'vendor/autoload.php';
$config = require "inc/config.php";

use Aws\S3\S3Client;

// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);
?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN THEME PANEL -->
        <?php require_once 'inc/campaing-error.php'; ?>
        <div class="profile-title">
            <h2>Edit
                <?php wp_title("", true); ?>
            </h2>
        </div>
        <!-- END THEME PANEL -->
        <!-- BEGIN PAGE BAR -->
        <?php require_once 'template-parts/breadcrumbs.php'; ?>
        <!-- END PAGE BAR -->
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS 1-->
        <!-- Begin button save and public -->
        <?php
        foreach ($postList as $post):
            ?>
            <form id="campaign-form" action="<?php echo get_stylesheet_directory_uri() ?>/inc/campaign-update.php"
                  enctype="multipart/form-data"
                  method="POST">
                <div class="button-menu new-campaign">
                    <div class="row">
                        <div class="col-md-3">
                            <i class="fa fa-wrench"></i>
                            <span>Edit campaign</span>

                        </div>
                        <div class="col-md-9 text-right">
                            <button name="active" value="publish" class="btn green-jungle"><i
                                    class="fa fa-chevron-down"></i> Publish campaign
                            </button>
                            <button name="active" value="save" class="btn yellow-gold"><i
                                    class="fa fa-chevron-down"></i> Save campaign
                            </button>
                            <a class="btn blue float-right preview" data-toggle="modal" href="#full"> <i
                                    class="icon-magnifier"></i> Preview </a>
                        </div>
                    </div>
                </div>
                <!-- End button save and public -->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group form-md-line-input form-md-floating-label has-success">
                            <input type="text" name="compaign_title" class="form-control"
                                   value="<?= $post->post_title; ?>" placeholder="" required>
                            <label>New campaign title
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <input type="hidden" id="numberIdPost" name="post-id" value="<?= $postID ?>">

                        </div>
                    </div>
                </div>
                <? /*  get_template_directory_uri()?>/assets/no-image.jpg */
                ?>
                <!-- BEGIN New campaign header img -->
                <div class="row">
                    <div class="campaign">
                        <div class="fileinput fileinput-new campaign-block-setting" data-provides="fileinput">
                            <div class="fileinput-new thumbnail campaign-img">
                                <img
                                    src="<?= $config['s3']['cdnPath'] . "/" . urlencode($post->campaign_bg_header_file) ?>"
                                    id="imgHeaderBg" alt=""></div>
                            <div id="imgHeaderNew" class="fileinput-preview fileinput-exists thumbnail campaign-img"
                                 style="height: 450px;"></div>
                            <div>
                                        <span class="btn default btn-file campaign-img-btn">
                                              <span class="fileinput-new"> Select image <span class="required"
                                                                                              style="color:red;"
                                                                                              aria-required="true">*</span></span>
                                        <span class="fileinput-exists"> Change </span>
                                            <?php wp_nonce_field('campaign-bg-header', 'campaign-bg-header-Upload'); ?>
                                            <input type="file" name="campaign-bg-header" id="campaign-bg-header"
                                                   accept="image/jpeg,image/png,image/gif">
                                        </span>
                                <a href="javascript:;" class="btn red fileinput-exists campaign-img-remove"
                                   data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                        <div class="profile-company">
                            <? if ($user_info->user_login == 'developer4') { ?><img
                                src="<?= get_template_directory_uri() ?>/assets/pages/img/flag/de.png" width="34"
                                height="34" alt="Сountry flag" class="profile-company__img">
                            <? } else { ?><img
                                src="<?= get_template_directory_uri() ?>/assets/img/flags/<?= strtolower($user_info->country); ?>.png"
                                width="34" height="34" alt="Сountry flag" class="profile-company__img"><? } ?>
                            <h2 class="profile-company__name">
                                <?= $user_info->companyname ?>
                            </h2>
                            <?php
                            require_once('template-parts/countries.php');
                            foreach ($countries as $key => $value) {
                                if ($user_info->country == $key) {
                                    $countriProfile = $value;
                                    break;
                                }
                            }
                            ?>
                            <p class="profile-company__address">
                                <?= $user_info->address ?>,
                                <?= $countriProfile ?>
                            </p>
                        </div>
                        <div class="campaign-age-push">
                            <div class="form-body">
                                <div class="form-group last">
                                    <!-- http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image -->
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <? if (!empty($post->campaign_age_file)) {
                                                ?><img
                                                src="<?= $config['s3']['cdnPath'] . "/" . urlencode($post->campaign_age_file) ?>"
                                                id="imgAgeBg" alt=""><? } ?></div>
                                        <div id="imgAgeNew" class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                                    <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                        <?php wp_nonce_field('campaign-age', 'campaign-age-Upload'); ?>
                                                        <input type="file" name="campaign-age" id="campaign-age"
                                                               accept="image/jpeg,image/png,image/gif">
                                                    </span>
                                            <a href="javascript:;" class="btn red fileinput-exists"
                                               data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                    <div class="clearfix margin-top-10"></div>

                                </div>
                            </div>
                        </div>
                        <div class="profile-user">
                            <!-- <button class="btn green">Connect</button> -->
                            <img id="profilePhoto" src="<?php
                            if (!empty($user_info->profilePic)) {
                                echo $user_info->profilePic;
                            } else {
                                echo get_template_directory_uri() . "/assets/avatar-5.png";
                            }
                            ?>
                                    ?>" class="profile-user__img" alt="<?= $user_info->user_nicename ?>">
                            <!-- <button class="btn green-haze">Bookmark</button> -->
                        </div>

                        <!-- Begin andbee Hash tag -->
                        <div class="select__categ" style="width: 250px;position: absolute;right: 20px;bottom: 210px;">
                            <h4 style="font-weight: 700;">Platform <span class="required" style="color:red;"
                                                                         aria-required="true">*</span></h4>
                            <select id="campaign-platform" name="campaignPlatform[]"
                                    class="form-control mt-multiselect btn red" multiple="multiple"
                                    data-width="100%" required>

                                <optgroup label="PC" class="group-1">
                                    <option
                                        value="windows" <?= (in_array("windows", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        Windows
                                    </option>
                                    <option
                                        value="mac" <?= (in_array("mac", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        Mac OS
                                    </option>
                                </optgroup>
                                <optgroup label="Console" class="group-2">
                                    <option
                                        value="nintendo" <?= (in_array("nintendo", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        Nintendo
                                    </option>
                                    <option
                                        value="ps" <?= (in_array("ps", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        PS
                                    </option>
                                    <option
                                        value="xbox" <?= (in_array("xbox", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        Xbox
                                    </option>
                                    <option
                                        value="handheld" <?= (in_array("handheld", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        Handheld
                                    </option>
                                </optgroup>
                                <optgroup label="Smartphones, tablets" class="group-3">
                                    <option
                                        value="windowsphone" <?= (in_array("windowsphone", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        Windows
                                    </option>
                                    <option
                                        value="android" <?= (in_array("android", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        Android
                                    </option>
                                    <option
                                        value="ios" <?= (in_array("ios", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        ios
                                    </option>
                                </optgroup>
                                <optgroup label="Multiplatform" class="group-4">
                                    <option
                                        value="virtualReality" <?= (in_array("virtualReality", $post->campaign_platform)) ? 'selected="selected"' : '' ?> >
                                        Virtual reality
                                    </option>
                                </optgroup>
                            </select>

                        </div>
                        <div class="select__categ" style="width: 250px;position: absolute;right: 20px;bottom: 140px;">
                            <h4 style="font-weight:800;">Categories <span class="required" style="color:red;"
                                                                          aria-required="true">*</span></h4>
                            <select id="new-campaigns-multiselect" class="mt-multiselect btn btn-success"
                                    name="campaign-categ[]" multiple="multiple" data-width="100%" required>
                                <?php
                                $categs2 = get_categories();
                                foreach ($categs2 as $key) {
                                    if ($key->slug == 'marketplace') {
                                        $categsID = $key->term_id;
                                        break;
                                    }
                                }
                                $args = array(
                                    'parent' => 8,
                                    'hide_empty' => false
                                    // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
                                );
                                $categs = (array)get_categories($args); // получаем все категории
                                foreach ($categs as $categ) {
                                    if (in_category($categ->cat_ID, $post->ID)) {
                                        echo "<option value=\"" . $categ->cat_ID . "\" selected=\"selected\">" . $categ->cat_name . "</option>";
                                    } else {
                                        echo "<option value=\"" . $categ->cat_ID . "\">" . $categ->cat_name . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="select__categ" style="width: 250px;position: absolute;right: 20px;bottom: 70px;">
                            <h4 style="font-weight: 700;">Worldwide<span class="required" style="color:red;"
                                                                         aria-required="true">*</span></h4>
                            <?php
                            require_once('template-parts/countries.php');
                            ?>
                            <select id="new-campaign-countries" name="countriesNewCampaign[]"
                                    class="mt-multiselect btn btn-default" multiple="multiple" data-label="left"
                                    data-select-all="true" data-width="100%" data-filter="true"
                                    data-action-onchange="true">
                                <? foreach ($countries as $key => $value): ?>
                                    <? if (in_array($key, $post->campaign_countries)): ?>
                                        <option value="<?= $key ?>" selected="selected"><?= $value ?></option>
                                    <? else: ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <? endif; ?>

                                <? endforeach; ?>
                            </select>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#campaign-platform').multiselect({
                                    buttonClass: 'btn red'
                                });
                                $('#new-campaign-countries').multiselect({
                                    enableFiltering: true,
                                    includeSelectAllOption: true,
                                    selectAllJustVisible: false
                                });
                                var orderCount = 0;
                                $('#new-campaigns-multiselect').multiselect({
                                    buttonClass: 'btn btn-success',
                                    onChange: function (option, checked, select) {
                                        if (checked) {
                                            orderCount++;
                                            $(option).data('order', orderCount);
                                        }
                                        else {

                                            $(option).data('order', '');
                                        }
                                        var selected = [];
                                        $('#new-campaigns-multiselect option:selected').each(function () {
                                            selected.push([$(this).text(), $(this).data('order')]);
                                        });

                                        selected.sort(function (a, b) {
                                            return a[1] - b[1];
                                        });

                                        var text = '';
                                        for (var i = 0; i < selected.length; i++) {
                                            text += selected[i][0] + ',';
                                        }
                                        var temp = text.split(',');
                                        text = text.substring(0, text.length - 2);
                                        //  console.log(text);
                                        //   alert(text);
                                        // console.log(temp);
                                        var selectedOptions = $('#new-campaigns-multiselect option:selected');
                                        if (selectedOptions.length >= 2) {
                                            // var temp = text.split(',');

                                            var nonSelectedOptions = $('#new-campaigns-multiselect option').filter(function () {
                                                return !$(this).is(':selected');
                                            });
                                            //  var dropdown = $('#new-campaigns-multiselect').siblings('.multiselect-container');
                                            nonSelectedOptions.each(function () {
                                                var input = $('input[value="' + $(this).val() + '"]');
                                                input.prop('disabled', true);
                                                input.parent('li').addClass('disabled');
                                            });


                                        } else {
                                            //  var dropdown = $('#new-campaigns-multiselect').siblings('.multiselect-container');
                                            $('#new-campaigns-multiselect option').each(function () {
                                                var input = $('input[value="' + $(this).val() + '"]');
                                                input.prop('disabled', false);
                                                input.parent('li').addClass('disabled');

                                            });
                                        }
                                    },
                                    buttonText: function (options) {
                                        if (options.length === 0) {
                                            return 'None selected';
                                        }
                                        else if (options.length > 3) {
                                            return options.length + ' selected';
                                        }
                                        else {
                                            var selected = [];
                                            options.each(function () {
                                                selected.push([$(this).text(), $(this).data('order')]);
                                            });

                                            selected.sort(function (a, b) {
                                                return a[1] - b[1];
                                            });

                                            var text = '';
                                            for (var i = 0; i < selected.length; i++) {
                                                text += selected[i][0] + ', ';
                                            }

                                            return text.substr(0, text.length - 2);
                                        }
                                    }
                                });

                            });

                        </script>
                        <div class="input__hashtags">
                            <ul class="hashtag__list">
                                <?php
                                $tags = (array)get_the_tags();
                                foreach ($tags as $tag):
                                    ?>
                                    <li class='hashtag__item'><input type='hidden' class='hashtag-text'
                                                                     name='campaign-hash[]' value="#<?= $tag->slug; ?>">
                                        <?= $tag->slug; ?><span class='hashtag-close'>˟</span></li>
                                <? endforeach; ?>
                                <li class="hashtag__input"><input type="text" class="hashtags"
                                                                  placeholder="add a tag *"></li>
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
                            <div class="compaign-info-form">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Intro text</strong> <span class="required"
                                                                                 aria-required="true">*</span></label>
                                                        <textarea name="campaign-description" id="editor7" rows="10"
                                                                  cols="80" required>
                                                          <?= $post->post_content; ?>
                                                        </textarea>

                                        <script>
                                            // Replace the <textarea id="editor1"> with a CKEditor
                                            // instance, using default configuration.
                                            CKEDITOR.replace('editor7', {
                                                'customConfig': 'config_introtext.js',
                                                'filebrowserBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                                                'filebrowserImageBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                                                'filebrowserFlashBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                                                'filebrowserUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                                                'filebrowserImageUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                                                'filebrowserFlashUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label><strong>Content</strong></label>
                                            <textarea name="editor1" id="editor1" rows="10" cols="80">
                                          <?= $post->campaign_editor_1; ?>
                                      </textarea>
                                    <script>
                                        // Replace the <textarea id="editor1"> with a CKEditor
                                        // instance, using default configuration.
                                        CKEDITOR.replace('editor1', {
                                            'filebrowserBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                                            'filebrowserImageBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                                            'filebrowserFlashBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                                            'filebrowserUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                                            'filebrowserImageUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                                            'filebrowserFlashUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="compaign-info-form">
                                <label class="control-label col-md-12">Upload video</label>
                                <div class="col-md-11">
                                    <div class="form-group form-md-line-input form-md-floating-label has-success">
                                        <input type="text" name="campaign-yt-title"
                                               value="<?= $post->campaign_yt_title; ?>" class="form-control "
                                               placeholder="">
                                        <label>Video title</label>
                                    </div>
                                </div>
                                <div class="compaign-info-form--wrap">
                                    <div class="col-md-5">
                                        <div class="form-group form-md-line-input form-md-floating-label has-success">
                                            <input type="text" name="campaign-yt-url"
                                                   value="<?= $post->campaign_yt_url; ?>" class="form-control">
                                            <label>Video url</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">OR</div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="input-group input-large">
                                                    <div class="form-control uneditable-input input-fixed input-medium"
                                                         data-trigger="fileinput">
                                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                        <span class="fileinput-filename"> </span>
                                                    </div>
                                                                <span class="input-group-addon btn default btn-file">
                                                                    <span class="fileinput-new"> Select file </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input type="hidden">
                                                                    <input type="file" name="campaign_video"
                                                                           accept="video/mp4,video/x-m4v,video/*">
                                                                </span>
                                                    <a href="javascript:;"
                                                       class="input-group-addon btn red fileinput-exists"
                                                       data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 youtube-wrap">
                                <div id="player-youtube"></div>
                            </div>
                            <script>
                                $(window).load(function () {
                                    var value = $("input[name='campaign-yt-url']").val();
                                    var getvalue = value.split("v=")[1];
                                    var player =
                                        '<iframe width="560" height="315" src="https://www.youtube.com/embed/' +
                                        getvalue + '" frameborder="0" allowfullscreen></iframe>';
                                    $('#player-youtube').html(player);
                                    $("input[name='campaign-yt-url']").keyup(function () {
                                        var value = $("input[name='campaign-yt-url']").val();
                                        var getvalue = value.split("v=")[1];
                                        var player =
                                            '<iframe width="" height="315" src="https://www.youtube.com/embed/' +
                                            getvalue +
                                            '" frameborder="0" allowfullscreen></iframe>';
                                        $('#player-youtube').html(player);
                                    });
                                });
                            </script>
                            <div class="row image-game__form">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                    <div class="image-game">
                                        <br><label><strong>Image game</strong></label><br>
                                        <div class="form-group last compaign-info__photo">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail compaign-info__setting">
                                                    <? if (!empty($post->campaign_image_file)) {
                                                        ?><img id="imgImageBg"
                                                               src="<?= $config['s3']['cdnPath'] . "/" . urlencode($post->campaign_image_file) ?>"
                                                               alt=""><? } ?>

                                                </div>
                                                <div id="imgImageNew"
                                                     class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                            <span class="btn default btn-file compaign-info__btn">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                                <?php wp_nonce_field('campaign-image', 'campaign-image-Upload'); ?>
                                                                <input type="file" name="campaign-image"
                                                                       id="campaign-image"
                                                                       accept="image/jpeg,image/png,image/gif">
                                                            </span>
                                                    <a href="javascript:;"
                                                       class="btn red fileinput-exists compaign-info__reset"
                                                       data-dismiss="fileinput"> Remove </a>

                                                </div>
                                                <? if (!empty($post->campaign_image_file)) { ?>
                                                    <button type="button" class="btn red"
                                                            onclick="deleteFile(this,'<?= $post->campaign_image_file ?>','<?= $post->ID ?>','campaign_image_file')">
                                                        Delete
                                                    </button>
                                                <? } ?>
                                            </div>
                                            <div class="clearfix margin-top-10"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="image-game">
                                        <label><strong>Background</strong></label><br>
                                        <div class="form-group last compaign-info__photo">

                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail compaign-info__setting">
                                                    <? if (!empty($post->campaign_bg_file)) {
                                                        ?><img id="imgBg"
                                                               src="<?= $config['s3']['cdnPath'] . "/" . urlencode($post->campaign_bg_file) ?>"
                                                               alt=""><? } ?></div>

                                                <div id="imgBgNew"
                                                     class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                            <span class="btn default btn-file compaign-info__btn">
                                                                <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                                <?php wp_nonce_field('campaign-bg', 'campaign-bg-Upload'); ?>
                                                                <input type="file" name="campaign-bg" id="campaign-bg"
                                                                       accept="image/jpeg,image/png,image/gif">
                                                            </span>
                                                    <a href="javascript:;"
                                                       class="btn red fileinput-exists compaign-info__reset"
                                                       data-dismiss="fileinput"> Remove </a>
                                                </div>
                                                <? if (!empty($post->campaign_bg_file)) { ?>
                                                    <button type="button" class="btn red"
                                                            onclick="deleteFile(this,'<?= $post->campaign_bg_file ?>','<?= $post->ID ?>','campaign_bg_file')">
                                                        Delete
                                                    </button>
                                                <? } ?>
                                            </div>
                                            <div class="clearfix margin-top-10"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row image-game__form">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                    <div class="image-game">
                                        <br><label><strong>Placeholder game plugin</strong></label><br>
                                        <div class="form-group last compaign-info__photo">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail compaign-info__setting">
                                                    <? if (!empty($post->placeholder_plugin_file)) {
                                                        ?><img id="imgImageBg"
                                                               src="<?= $config['s3']['cdnPath'] . "/" . urlencode($post->placeholder_plugin_file) ?>"
                                                               alt=""><? } ?>
                                                </div>
                                                <div id="imgImageNew"
                                                     class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>

                                                            <span class="btn default btn-file compaign-info__btn">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                                <?php wp_nonce_field('placeholder-plugin', 'placeholder-plugin-Upload'); ?>
                                                                <input type="file" name="placeholder-plugin"
                                                                       id="placeholder-plugin"
                                                                       accept="image/jpeg,image/png,image/gif">
                                                            </span>
                                                    <a href="javascript:;"
                                                       class="btn red fileinput-exists compaign-info__reset"
                                                       data-dismiss="fileinput"> Remove </a>

                                                </div>
                                                <? if (!empty($post->placeholder_plugin_file)) { ?>
                                                    <button type="button" class="btn red"
                                                            onclick="deleteFile(this,'<?= $post->placeholder_plugin_file ?>','<?= $post->ID ?>','placeholder_plugin_file')">
                                                        Delete
                                                    </button>
                                                <? } ?>

                                            </div>
                                            <div class="clearfix margin-top-10"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- End main block -->


                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="dashboard-stat blue-soft">
                            <div class="visual">
                                <img
                                    src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/vreo_icon_text_light.png"
                                    alt="">
                            </div>
                            <div class="dasborard-campaign">
                                <div class="number cost_per_view">
                                    <div class="iter_up" onclick="iterCostPerView(this)"><i class="fa fa-caret-up"
                                                                                            aria-hidden="true"></i>
                                    </div>
                                    <div class="iter_down" onclick="iterCostPerView(this)"><i class="fa fa-caret-down"
                                                                                              aria-hidden="true"></i>
                                    </div>
                                    <input name="cost-campaign"
                                           id="cost-campaign" value="<?= $post->cost_campaign ?>" required
                                           style="width: 85px; color:black;"
                                           onkeypress="return inputOnlyNum(this,event)"></div>
                                <!-- <input type="text" name="cost-campaign"  value="" required style="width: 100px; color:black;">&#8364;</div> -->
                                <div class="desc"> Cost per view<span class="required" style="color:red;"
                                                                      aria-required="true">*</span></div>
                            </div>
                            <div class="dasborard-campaign">
                                <div class="number"><input type="number" min="0" name="pic-number-campaign"
                                                           id="pic-number-campaign"
                                                           value="<?= $post->pic_number_campaign ?>" required
                                                           style="width: 70px; color:black;"
                                                           onkeypress="return inputOnlyInteger(this,event)">x
                                </div>
                                <div class="desc"> Picture advertising <span class="required" style="color:red;"
                                                                             aria-required="true">*</span></div>
                            </div>
                            <div class="dasborard-campaign">
                                <div class="number"><input type="number" min="0" name="video-number-campaign"
                                                           id="video-number-campaign"
                                                           value="<?= $post->video_number_campaign ?>" required
                                                           style="width: 70px; color:black;"
                                                           onkeypress="return inputOnlyInteger(this,event)">x
                                </div>
                                <div class="desc"> Video advertising <span class="required" style="color:red;"
                                                                           aria-required="true">*</span></div>
                            </div>
                            <script type="text/javascript">
                                $('#pic-number-campaign').keyup(function (e) {
                                    var number1 = this.value;
                                    $('#video-number-campaign').keyup(function (e) {
                                        var number2 = this.value;
                                        if (number2 == 0 && number1 == 0) {
                                            alert(
                                                "Picture advertising and Video advertising not contain two input zeros. Enter accurate data."
                                            );
                                        }
                                    });
                                });
                            </script>
                            <div class="dasborard-campaign">
                                <div class="number">
                                    <?php
                                    $tags = (array)get_the_tags($key->ID);
                                    global $wpdb;
                                    if (!empty($tags)) {
                                        foreach ($tags as $tag) {
//										$class_color=rand(0,$count_colors);
                                            $colors_tags_db = $wpdb->get_results("SELECT DISTINCT color_tag FROM colors_tags WHERE name_tag='" . $tag->slug . "'");
//										print_r($colors_tags_db);
                                            echo "<button style='margin-right: 2px' class=\"btn btn-circle ";
                                            foreach ($colors_tags_db as $clr_tg) {
                                                echo $clr_tg->color_tag;
                                            }
                                            echo "\">$tag->name</button>";
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="desc"> are matching hashtags for <?= $post->post_title; ?></div>
                            </div>
                            <div class="dasborard-campaign">
                                <div class="number"><input type="number" min="1" step="any"
                                                           name="budget-number-campaign" step="any"
                                                           value="<?= $post->budget_number_campaign ?>" required
                                                           style="width: 100px; color:black;"> &#8364;</div>
                                <div class="desc"> Minimum budget <span class="required" style="color:red;"
                                                                        aria-required="true">*</span></div>
                            </div>
                            <a class="more text-right" href="javascript:;"> Whats that?
                                <i class="icon-question m-icon-white" style="margin-left: 5px;"></i>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>
                <!-- END DASHBOARD STATS 1-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="compaign-info-form">
                            <div class="col-md-5">
                                <div class="form-group form-md-line-input form-md-floating-label has-success">
                                    <input type="text" name="campaign-desc-addition" class="form-control "
                                           value="<?= $post->campaign_desc_addition; ?>" placeholder="">
                                    <label>Title description addition</label>
                                </div>
                            </div>

                        </div>
                        <br>
                                <textarea name="editor2" id="editor2" rows="10" cols="80">
                                         <?= $post->campaign_editor_2; ?>
                                    </textarea>
                        <script>
                            // Replace the <textarea id="editor1"> with a CKEditor
                            // instance, using default configuration.
                            CKEDITOR.replace('editor2', {
                                'filebrowserBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                                'filebrowserImageBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                                'filebrowserFlashBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                                'filebrowserUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                                'filebrowserImageUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                                'filebrowserFlashUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                            });
                        </script>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-md-line-input form-md-floating-label has-success">
                                    <input type="text" value="<?= $post->slider_title; ?>" name="slider-title"
                                           class="form-control " placeholder="">
                                    <label>Title slider</label>
                                </div>
                            </div>
                        </div>
                        <?php
                        $sliderImages = get_post_meta(get_the_ID(), "campaignSlider", true);
                        
                        $doesExistFiles = false;
                        if (!empty($sliderImages)) {
                            foreach ($sliderImages as $slide) {
                                if ($s3->doesObjectExist($config['s3']['bucket'], $slide)) {
                                    $doesExistFiles = true;
                                    break;
                                }
                            }
                        }
//                        if ($doesExistFiles) {
                            ?>
                            <div class="row">
                                <div id="dropbox">
                                    <span class="message">Drop files here</span>
                                    <?php
                                    if (!empty($sliderImages)) {
                                        foreach ($sliderImages as $slide) {
                                            if ($s3->doesObjectExist($config['s3']['bucket'], $slide)) {
                                                $imageUrl = $config["s3"]["cdnPath"] . "/" . $slide;
                                                echo "<div class=\"preview done\">";
                                                echo "<span class=\"imageHolder\">";
                                                echo "<img src=\"$imageUrl\">";
                                                echo "<span class=\"uploaded\"></span></span>";
                                                echo '<input type="hidden" class="slideName" name="" value="">';
                                                echo '<input type="hidden" class="slideSize" name="" value="">';
                                                echo '<input type="hidden" class="idPost" name="id" value="' . $postID . '">';
                                                echo '<button class="btn deleteEdit" name="Key" value="' . $slide . '">Delete</button>';
                                                echo "</div>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        <?
//                        }
                        ?>
                    </div>
                </div>

                <!-- Begin button save and public -->
                <div class="button-menu__bottom">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button name="active" value="publish" class="btn green-jungle"><i
                                    class="fa fa-chevron-down"></i> Publish campaign
                            </button>
                            <button name="active" value="save" class="btn yellow-gold"><i
                                    class="fa fa-chevron-down"></i> Save campaign
                            </button>
                            <a class="btn blue float-right preview" data-toggle="modal" href="#full"> <i
                                    class="icon-magnifier"></i> Preview </a>
                        </div>
                    </div>
                </div>
            </form>
        <?php endforeach; ?>

        <!-- End button save and public -->
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
                    <div class="profile-usertitle-name">
                        <?= $user_info->first_name; ?>
                        <?= $user_info->last_name; ?>
                    </div>
                    <div class="profile-usertitle-job">
                        <?= $user_info->roles[0]; ?>
                    </div>
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
                    <h4 class="profile-desc-title">About
                        <?= $user_info->companyname; ?>
                    </h4>
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
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 8
                            });
                            var geocoder = new google.maps.Geocoder;
                            geocoder.geocode({
                                'address': '<?=$user_info->address;?>'
                            }, function (results, status) {
                                if (status === google.maps.GeocoderStatus.OK) {
                                    map.setCenter(results[0].geometry.location);
                                    new google.maps.Marker({
                                        map: map,
                                        position: results[0].geometry.location
                                    });
                                } else {
                                    window.alert(
                                        'Geocode was not successful for the following reason: ' +
                                        status);
                                }
                            });
                        }
                    </script>
                    <div class="profile-map__block">
                        <h2>
                            <?= $user_info->companyname; ?>
                        </h2>
                        <span class="bg-blue font-white uppercase">address</span>
                        <p>
                            <?= $user_info->address; ?>
                        </p>
                        <p>
                            <?= $countriProfile; ?>
                        </p>
                        <span class="bg-blue font-white uppercase">Contacts</span>
                        <p><span class="bold uppercase">T </span>
                            <?= $user_info->phone; ?>
                        </p>
                        <p><span class="bold uppercase">F </span>
                            <?= $user_info->fax; ?>
                        </p>
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
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <script>

        function deleteFile(obj, Key, id, nameMeta) {
            var Key = Key;
            var idPost = id;
            var nameMeta = nameMeta;
            var deleteBut = obj;
            var thumb = deleteBut.closest('.fileinput').firstElementChild;
            console.log(thumb);
            thumb.classList.add("pulse");
            $.get('<?=get_template_directory_uri()?>/inc/deleteFilePostMeta.php', {
                Key: Key,
                postMeta: nameMeta,
                idPost: idPost
            }, function (data) // отправляем GET запрос на href, указанный в ссылке
            {
                var response = Boolean(data);
//                console.log(response);

                if (response == true) {
                    console.log("Response " + response);
                    thumb.firstElementChild.remove();
                    deleteBut.remove();
                } else {
                    console.log("Response " + response);
                    thumb.classList.remove('pulse');
                }
            });
        }
    </script>
    <script src="<?= get_template_directory_uri() ?>/js/inputOnlyNum.js" type="text/javascript"></script>
<?php
require_once(get_template_directory() . '/template-parts/content-previes.php');
get_footer('dashboard');