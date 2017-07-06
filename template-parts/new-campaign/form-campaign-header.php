<div class="row">
    <div class="col-md-5">
        <div class="form-group form-md-line-input form-md-floating-label has-success">
            <input type="text" name="compaign_title" id="campaign-name" class="form-control" placeholder=""
                   required>
            <label>New campaign title
                <span class="required" aria-required="true">*</span>
            </label>
            <?php
            $numberIdDb = $wpdb->get_results("SELECT ID FROM `wp_posts`  ORDER BY `ID` DESC LIMIT 0,1");
            $args = array(
                'numberposts' => 1
            , 'post_status'   => 'draft,publish'
            );
            $numberId = $numberIdDb[0]->ID;
            $numberId++;

            ?>

            <input type="hidden" name="numberIdPost" id="numberIdPost" value="<?= $numberId; ?>">
        </div>
    </div>
</div>

<div class="row">
    <div class="campaign">
        <div class="fileinput fileinput-new campaign-block-setting" data-provides="fileinput">
            <div class="fileinput-new thumbnail campaign-img">
                <img src="<?= get_template_directory_uri() ?>/assets/no-image.jpg" id="imgHeaderBg" alt="">
            </div>
            <div id="imgHeaderNew"
                 class="fileinput-preview fileinput-exists thumbnail campaign-img campaign-img--header"></div>
            <div>
                                         <span class="btn default btn-file campaign-img-btn">
                                              <span class="fileinput-new"> Select image <span class="required"
                                                                                              style="color:red;"
                                                                                              aria-required="true">*</span></span>
                                              <span class="fileinput-exists"> Change </span>
                                             <?php wp_nonce_field('campaign-bg-header', 'campaign-bg-header-Upload'); ?>
                                             <input type="file" name="campaign-bg-header" id="campaign-bg-header"
                                                    onchange="uploadFilesSize()"
                                                    accept="image/jpeg,image/png,image/gif" required>
                                         </span>
                <a href="javascript:;" class="btn red fileinput-exists campaign-img-remove"
                   data-dismiss="fileinput"> Remove </a>
            </div>
        </div>
        <div class="profile-company">
            <? if ($user_info->user_login == 'developer4') { ?><img
                src="<?= get_template_directory_uri() ?>/assets/pages/img/flag/de.png" width="34"
                height="34" alt="Сountry flag" class="profile-company__img">
                <?
            } else { ?><img
                src="<?= get_template_directory_uri() ?>/assets/img/flags/<?= strtolower($user_info->country); ?>.png"
                width="34" height="34" alt="Сountry flag" class="profile-company__img"><?
            } ?>

            <h2 class="profile-company__name"><?= $user_info->companyname ?></h2>
            <?php
            require_once __DIR__ . '/../countries.php';
            foreach ($countries as $key => $value) {
                if ($user_info->country == $key) {
                    $countriProfile = $value;
                    break;
                }
            }
            ?>
            <p class="profile-company__address"><?= $user_info->address ?>, <?= $countriProfile; ?></p>
        </div>
        <div class="campaign-age-push">
            <div class="form-body">
                <div class="form-group last">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                            <img id="imgAgeBg"
                                 src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                 alt=""></div>
                        <div id="imgAgeNew" class="fileinput-preview fileinput-exists thumbnail"
                             style="max-width: 200px; max-height: 150px;"></div>
                        <div>
                                                                <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <?php wp_nonce_field('campaign-age', 'campaign-age-Upload'); ?>
                                                                    <input type="file" name="campaign-age"
                                                                           id="campaign-age"
                                                                           onchange="uploadFilesSize()"
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

            <img id="profilePhoto" src="<?php
            if (!empty($user_info->profilePic)) {
                echo $user_info->profilePic;
            } else {
                echo get_template_directory_uri() . "/assets/avatar-4.png";
            }
            ?>" class="profile-user__img"
                 alt="<?= $user_info->user_nicename ?>">

        </div>

        <!-- Begin andbee Hash tag -->
        <div class="select__categ" style="width: 250px;position: absolute;right: 20px;bottom: 210px;">
            <h4 style="font-weight: 700;">Platform <span class="required" style="color:red;"
                                                         aria-required="true">*</span></h4>
            <select id="campaign-platform" name="campaignPlatform[]"
                    class="form-control mt-multiselect btn red" multiple="multiple" data-width="100%"
                    required>
                <!-- <optgroup label="PC" class="group-1"> -->
                <option value="windows" selected>Windows</option>
                <!-- <option value="mac">Mac OS</option> -->
                <!-- </optgroup> -->
                <!-- <optgroup label="Console" class="group-2"> -->
                <!-- <option value="nintendo">Nintendo</option> -->
                <!-- <option value="ps">PS</option> -->
                <!-- <option value="xbox">Xbox</option> -->
                <!-- <option value="handheld">Handheld</option> -->
                <!-- </optgroup> -->
                <!-- <optgroup label="Smartphones, tablets" class="group-3"> -->
                <!-- <option value="windowsphone">Windows</option> -->
                <!-- <option value="android">Android</option> -->
                <!-- <option value="ios">ios</option> -->
                <!-- </optgroup> -->
                <!-- <optgroup label="Multiplatform" class="group-4"> -->
                <!-- <option value="virtualReality">Virtual reality</option> -->
                <!-- </optgroup> -->
            </select>
        </div>
        <div class="select__categ" style="width: 250px;position: absolute;right: 20px;bottom: 140px;">
            <h4 style="font-weight: 700;">Categories <span class="required" style="color:red;"
                                                           aria-required="true">*</span></h4>
            <select id="new-campaigns-multiselect" class="mt-multiselect btn btn-success"
                    name="campaign-categ[]" data-max-options="2" multiple="multiple" data-width="100%"
                    required>
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
                    echo "<option value=\"" . $categ->cat_ID . "\">" . $categ->cat_name . "</option>";
                }
                ?>
            </select>

        </div>
        <div class="select__categ" style="width: 250px;position: absolute;right: 20px;bottom: 70px;">

            <h4 style="font-weight: 700;">Countries<span class="required" style="color:red;" aria-required="true">*</span></h4>
            <?php
            require_once __DIR__ . '/../countries.php';
            ?>
            <select id="new-campaign-countries" name="countriesNewCampaign[]"
                    class="mt-multiselect btn btn-default" multiple="multiple" data-label="left"
                    data-select-all="true" data-width="100%" data-filter="true" data-action-onchange="true">
                <? foreach ($countries as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
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
                <li class="hashtag__input"><input type="text" class="hashtags" placeholder="add a tag *"
                                                  required>
                </li>
            </ul>
        </div>
        <!-- End andbee Hash tag -->

    </div>
</div>