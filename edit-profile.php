<?php
/*
 * Template name: Edit Profile
 */

get_header('dashboard');

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$month = $user_info->user_month;
$date = $user_info->user_date;
$year = $user_info->user_year;
$gender= $user_info->user_gender;
$payment = $user_info->payment;
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

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet ">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                        <img src="<?php
                        if(!empty($user_info->profilePic)){
                            echo $user_info->profilePic;
                        } else {
                            echo get_template_directory_uri()."/assets/avatar-4.png";
                        }
                        ?>" class="img-responsive" alt="<?=$user_info->user_nicename ?>">
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div
                                class="profile-usertitle-name"> <?= $user_info->first_name; ?> <?= $user_info->last_name; ?> </div>
                            <div class="profile-usertitle-job"> <?= $user_info->roles[0]; ?> </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->
                        <!--<div class="profile-userbuttons">
                            <button type="button" class="btn btn-circle green btn-sm">Connect</button>
                            <button type="button" class="btn btn-circle red btn-sm">Message</button>
                        </div>-->
                        <!-- END SIDEBAR BUTTONS -->
                    </div>
                    <!-- END PORTLET MAIN -->
                    <!-- PORTLET MAIN -->
                    <div class="portlet light ">
                        <div>
                            <h4 class="profile-desc-title">About <?= $user_info->companyname; ?></h4>
                            <span
                                class="profile-desc-text"> <?=$user_info->about_short;?> </span>
                        </div>
                        <div>
                            <?php
                            if( !$user_ID ) {
                                header('location:' . site_url() . '/');
                                exit;
                            } else {
                                $userdata = get_user_by( 'id', $user_ID );
                            }
                            // после сохранения профиля и смены пароля понадобятся уведомления
                            // если уведомлений больше двух, то оптимальнее их будет вывести через switch
                            if (isset($_GET['status'])) :
                                switch ($_GET['status']) :
                                    case 'ok': {
                                        echo '<div class="success btn btn-sm green-meadow"><i class="fa fa-check"></i>Saved</div>';
                                        break;
                                    }
                                    case 'exist': {
                                        echo '<div class="error">The user with the specified email already exists.</div>';
                                        break;
                                    }
                                    case 'short': {
                                        echo '<div class="error">The password is too short.</div>';
                                        break;
                                    }
                                    case 'mismatch': {
                                        echo '<div class="error">Passwords do not match.</div>';
                                        break;
                                    }
                                    case 'wrong': {
                                        echo '<div class="error">The old password is incorrect.</div>';
                                        break;
                                    }
                                    case 'required': {
                                        echo '<div class="error">Please fill in all required fields.</div>';
                                        break;
                                    }
                                endswitch;
                            endif;
                            ?>


                        </div>
                    </div>
                    <!-- END PORTLET MAIN -->
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span
                                            class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">Personal Information</a>
                                        </li>
<!--                                        <li>-->
<!--                                            <a href="#tab_1_2" data-toggle="tab">Payment information</a>-->
<!--                                        </li>-->
                                        <li>
                                            <a href="#tab_1_3" data-toggle="tab">Customize you account</a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_4" data-toggle="tab">Change Password</a>
                                        </li>
                                         <?php
                                          if ($user_info->roles[0] == 'bran'):
                                         ?>
                                        <li>
                                            <a href="#tab_1_5" data-toggle="tab">Interesting information</a>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">
                                            <form action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-update.php" method="POST">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" placeholder="" name="first_name" pattern="[A-Za-z]{1,50}"
                                                           value="<?=$user_info->first_name;?>" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" placeholder="" name="last_name" pattern="[A-Za-z]{1,50}"
                                                           value="<?=$user_info->last_name;?>" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">E-mail</label>
                                                    <input type="text" placeholder="" name="user_email" value="<?=$user_info->user_email;?>" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                           class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Company name</label>
                                                    <input type="text" placeholder="" name="companyname" value="<?=$user_info->companyname;?>"
                                                           class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Telephone</label>
                                                    <input type="text" placeholder="" name="phone" value="<?=$user_info->phone;?>" pattern="^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){5,20}(\s*)?$"
                                                           class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Fax</label>
                                                    <input type="text" placeholder="" name="fax" value="<?=$user_info->fax;?>"  pattern="^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){5,20}(\s*)?$"
                                                           class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Address</label>
                                                    <input type="text" placeholder="" name="address" value="<?=$user_info->address;?>"
                                                           class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Country</label>
                                                    <?php
                                                        require_once('template-parts/countries.php');
                                                    ?>
<!--                                                    <input type="text" placeholder="" name="country" value="--><?//=$user_info->country;?><!--"-->
<!--                                                           class="form-control"/>-->
                                                    <select class="form-control" name="country" required>
                                                        <? foreach ($countries as $key => $value):?>
                                                            <?php
                                                                if ($user_info->country == $key) {
                                                                    echo "<option value=\"{$key}\" selected>$value</option>";
                                                            } else {
                                                                    echo "<option value=\"{$key}\">$value</option>";
                                                                }
                                                            ?>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Date of birth</label><br>
                                                    <label> <b>Month</b><br>
                                                        <select name="user_month" id="user_month" >
                                                            <option value="January" <?=($month=='January') ? 'selected="selected"':''?> >January</option>
                                                            <option value="February" <?=($month=='February') ? 'selected="selected"':''?> >February</option>
                                                            <option value="March" <?=($month=='March') ? 'selected="selected"':''?> >March</option>
                                                            <option value="April" <?=($month=='April') ? 'selected="selected"':''?> >April</option>
                                                            <option value="May" <?=($month=='May') ? 'selected="selected"':''?> >May</option>
                                                            <option value="June" <?=($month=='June') ? 'selected="selected"':''?> >June</option>
                                                            <option value="July" <?=($month=='July') ? 'selected="selected"':''?> >July</option>
                                                            <option value="August" <?=($month=='August') ? 'selected="selected"':''?> >August</option>
                                                            <option value="September" <?=($month=='September') ? 'selected="selected"':''?> >September</option>
                                                            <option value="October" <?=($month=='October') ? 'selected="selected"':''?> >October</option>
                                                            <option value="November" <?=($month=='November') ? 'selected="selected"':''?> >November</option>
                                                            <option value="December" <?=($month=='December') ? 'selected="selected"':''?> >December</option>
                                                        </select>
                                                    </label>
                                                    <label> <b>Date</b><br>
                                                        <input type="text" name="user_date" id="user_date" value="<?=$date ?>" pattern="^[0-9]{2,2}" class="regular-date">
                                                    </label>
                                                    <label> <b>Year</b><br>
                                                        <input type="text" name="user_year" id="user_year" value="<?=$year ?>" class="regular-year">
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Gender</label><br>
                                                    <input type="radio" name="user_gender" value="Male" <?=($gender=='Male') ? 'checked="checked"':''?> > Male
                                                    <input type="radio" name="user_gender" style="margin-left: 10px;" value="Female" <?=($gender=='Female') ? 'checked="checked"':''?> > Female
                                                    <input type="radio" name="user_gender" style="margin-left: 10px;" value="Non-binary" <?=($gender=='Non-binary') ? 'checked="checked"':''?> > Non-binary
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">About</label>
                                                    <textarea class="form-control" rows="3" id="editor3" name="description" placeholder="">
                                                      <?=$user_info->description;?>
                                                    </textarea>
                                                    <script>
                                                    
                                                       // Replace the <textarea id="editor1"> with a CKEditor
                                                       // instance, using default configuration.
                                                       CKEDITOR.replace( 'editor3',{
                                                         'filebrowserBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                                                          'filebrowserImageBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                                                          'filebrowserFlashBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                                                          'filebrowserUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                                                          'filebrowserImageUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                                                          'filebrowserFlashUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                                                        });
                                                   </script>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">About short</label>
                                                    <textarea  class="form-control" rows="3" id="editor4" name="editor4">
                                                      <?=$user_info->about_short;?>
                                                    </textarea>
                                                    <script>
                                                       // Replace the <textarea id="editor1"> with a CKEditor
                                                       // instance, using default configuration.
                                                       CKEDITOR.replace( 'editor4', {
                                                           'customConfig': 'config_about_short.js'
                                                       });
                                                   </script>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Social network </label><br>
                                                    <b>Web site: </b><input type="text" placeholder="" name="web-site" value="<?=$user_info->web_site;?>" class="form-control"/>
                                                    <b>Twitter: </b><input type="text" placeholder="" name="link-twitter" value="<?=$user_info->link_twitter;?>" class="form-control"/>
                                                    <b>Facebook: </b><input type="text" placeholder="" name="link-facebook" value="<?=$user_info->link_facebook;?>" class="form-control"/>
                                                    <b>Instagram: </b><input type="text" placeholder="" name="link-instagram" value="<?=$user_info->link_instagram;?>" class="form-control"/>
                                                </div>
                                                <? if ($user_info->roles[0] == 'brand'): ?>
                                                <div class="form-group">
                                                    <p>If you don't want your profile to appear on the marketplace, check the box below. You can change this setting any time.</p>
                                                    <div class="mt-checkbox-list">
                                                        <label class="mt-checkbox"> Make me invisible
                                                            <input type="checkbox" id="brandsCheckbox" value="invisible" <?=($user_info->visible_brands=='invisible') ? 'checked':''?> name="visible_brand">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <? endif; ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label class="control-label">Additional information</label>
                                                          <textarea name="editor5" class="form-control" rows="3" id="editor5">
                                                            <?=$user_info->text_left;?>
                                                          </textarea>
                                                          <script>
                                                             // Replace the <textarea id="editor1"> with a CKEditor
                                                             // instance, using default configuration.
                                                             CKEDITOR.replace( 'editor5',{
                                                                'customConfig': '',
                                                               'filebrowserBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                                                                'filebrowserImageBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                                                                'filebrowserFlashBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                                                                'filebrowserUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                                                                'filebrowserImageUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                                                                'filebrowserFlashUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                                                              });
                                                         </script>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label class="control-label">Additional information</label>
                                                          <textarea name="editor6" class="form-control" rows="3" id="editor6">
                                                            <?=$user_info->text_right;?>
                                                          </textarea>
                                                          <script>
                                                             // Replace the <textarea id="editor1"> with a CKEditor
                                                             // instance, using default configuration.
                                                             CKEDITOR.replace( 'editor6',{
                                                                 'customConfig': '',
                                                               'filebrowserBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                                                                'filebrowserImageBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                                                                'filebrowserFlashBrowseUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                                                                'filebrowserUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                                                                'filebrowserImageUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                                                                'filebrowserFlashUploadUrl':'<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                                                              });
                                                         </script>
                                                      </div>

                                                    </div>
                                            </div>
                                                <div class="margiv-top-10">
                                                    <button class="btn green" onclick="timeTab1();">Save Changes</button>
                                                </div>
                                                <div id="timeProfileTab1"></div>
                                            </form>
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->
                                        <!-- PRIVACY SETTINGS TAB -->
<!--                                        <div class="tab-pane" id="tab_1_2">-->
<!--                                            <form action="--><?php //echo get_stylesheet_directory_uri() ?><!--/inc/profile-payment-update.php" method="POST">-->
<!--                                                <div class="form-group">-->
<!--                                                    <label class="control-label">Surname</label>-->
<!--                                                    <input type="text" placeholder="" name="paymentSurname" value="--><?//=$user_info->paymentSurname;?><!--" pattern="[A-Za-z]{1,50}"-->
<!--                                                           class="form-control"/>-->
<!--                                                </div>-->
<!--                                                <div class="form-group">-->
<!--                                                    <label class="control-label">Company name</label>-->
<!--                                                    <input type="text" placeholder="" name="paymentCompanyname" value="--><?//=$user_info->paymentCompanyname;?><!--"-->
<!--                                                           class="form-control"/>-->
<!--                                                </div>-->
<!--                                                <div class="form-group">-->
<!--                                                    <label class="control-label">Address</label>-->
<!--                                                    <input type="text" placeholder="" name="paymentAddress" value="--><?//=$user_info->paymentAddress;?><!--"-->
<!--                                                           class="form-control"/>-->
<!--                                                </div>-->
<!--                                                <div class="form-group">-->
<!--                                                    <label class="control-label">Country</label>-->
<!--<!--                                                    <input type="text" placeholder="" name="paymentCountry" value="--><?////=$user_info->paymentCountry;?><!--<!--"-->
<!--<!--                                                           class="form-control"/>-->
<!--                                                    <select class="form-control" name="paymentCountry" required>-->
<!--                                                        --><?// foreach ($countries as $key => $value):?>
<!--                                                            --><?php
//                                                            if ($user_info->paymentCountry == $key) {
//                                                                echo "<option value=\"{$key}\" selected>$value</option>";
//                                                            } else {
//                                                                echo "<option value=\"{$key}\">$value</option>";
//                                                            }
//                                                            ?>
<!--                                                        --><?// endforeach; ?>
<!--                                                    </select>-->
<!--                                                </div>-->
<!--                                                <div class="form-group">-->
<!--                                                    <label class="control-label">Choose payment method</label><br>-->
<!--                                                    <input type="radio" name="payment" value="Visa" --><?//=($payment=='Visa') ? 'checked="checked"':''?><!-- > Visa-->
<!--                                                    <input type="radio" name="payment" style="margin-left: 10px;" value="Amex" --><?//=($payment=='Amex') ? 'checked="checked"':''?><!-- > Amex-->
<!--                                                    <input type="radio" name="payment" style="margin-left: 10px;" value="Amazon" --><?//=($payment=='Amazon') ? 'checked="checked"':''?><!-- > Amazon-->
<!--                                                    <input type="radio" name="payment" style="margin-left: 10px;" value="PayPal" --><?//=($payment=='PayPal') ? 'checked="checked"':''?><!-- > PayPal-->
<!--                                                    <input type="radio" name="payment" style="margin-left: 10px;" value="Stripe" --><?//=($payment=='Stripe') ? 'checked="checked"':''?><!-- > Stripe-->
<!--                                                </div>-->
<!--                                                <div class="margin-top-10">-->
<!--                                                    <button class="btn red" onclick="timeTab2();">Save Changes</button>-->
<!--                                                </div>-->
<!--                                                <div id2="timeProfileTab2"></div>-->
<!--                                            </form>-->
<!--                                        </div>-->
                                        <!-- END PRIVACY SETTINGS TAB -->
                                        <!-- CHANGE AVATAR TAB -->
                                        <div class="tab-pane" id="tab_1_3">

                                            <form action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-image-update.php" enctype="multipart/form-data" method="POST">
                                                <div class="form-group last col-md-5 form-profile-image">

                                                    <label class="control-label">Add profile pic
                                                        <!-- <div class="col-md-9">-->
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail fileinput-cover">
                                                                <div class="fileinput-image">
                                                                    <div class="image-desc">add pic</div>
                                                                </div>
                                                                <!--<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>-->
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                            <div>
                                                                <p>Picture needs to be at least 512x512px</p>
													<span class="btn default btn-file">
                                                        <span class="fileinput-new"> Upload image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <?php wp_nonce_field( 'profilePic', 'profilePicUpload' ); ?>
                                                        <input type="file" name="profilePic" id="profilePic2" accept="image/jpeg,image/png,image/gif">
                                                    </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix margin-top-10">
                                                            <span class="label label-danger"></span>
                                                        </div>
                                                        <!-- </div>-->
                                                    </label>
                                                </div>
                                                <div class="form-group last col-md-5 form-header-image">
                                                    <label class="control-label ">Add header profile pic
                                                        <!--<div class="col-md-9">-->
                                                        <div class="fileinput fileinput-new " data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail fileinput-cover-header" >
                                                                <div class="fileinput-header-image">
                                                                    <div class="image-desc">add pic</div>
                                                                </div>
                                                                <!--<img src="http://www.placehold.it/300x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>--></div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 150px;"></div>
                                                            <div>
                                                                <p>Picture needs to have a size of 1400x450px</p>
													<span class="btn default btn-file">
                                                        <span class="fileinput-new"> Upload image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <?php wp_nonce_field( 'profileHeaderPic', 'profileHeaderPicUpload' ); ?>
                                                        <input type="file" name="profileHeaderPic" id="profileHeaderPic2" accept="image/jpeg,image/png,image/gif">
                                                    </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix margin-top-10">
                                                            <span class="label label-danger"></span>
                                                        </div>
                                                        <!--</div>-->
                                                    </label>
                                                </div>
                                                <div class="clearfix margin-top-10">
                                                    <button class="btn green" onclick="timeTab3();">Update Images</button>
                                                </div>
                                                <div id="timeProfileTab3"></div>
                                            </form>
                                        </div>
                                        <!-- END CHANGE AVATAR TAB -->
                                        <!-- CHANGE PASSWORD TAB -->
                                        <div class="tab-pane" id="tab_1_4">
                                            <form action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-pdw-update.php" method="POST">
                                                <div class="form-group">
                                                    <label class="control-label">Current Password</label>
                                                    <input type="password" name="pwd1" class="form-control"/></div>
                                                <div class="form-group">
                                                    <label class="control-label">New Password</label>
                                                    <input type="password" name="pwd2" class="form-control"/></div>
                                                <div class="form-group">
                                                    <label class="control-label">Re-type New Password</label>
                                                    <input type="password" name="pwd3" class="form-control"/></div>
                                                <div class="margin-top-10">
                                                    <button class="btn green">Change Password</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END CHANGE PASSWORD TAB -->
                                        <div class="tab-pane" id="tab_1_5" style="min-height: 486px;">
                                            <form action="<?php echo get_stylesheet_directory_uri() ?>/inc/profile-interesting-update.php" method="POST">
                                                <div class="col-md-4">
                                                        <h4 style="font-weight: 700;">Categories</h4>
                                                        <select id="profile-categore"  class="mt-multiselect btn btn-success" name="profile-categore[]" data-max-options="2" multiple="multiple" data-width="100%">
                                                            <?php
                                                            $categs2 = get_categories();
                                                            foreach ($categs2 as $key ) {
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
                                                            $categs=(array)get_categories($args); // получаем все категории
                                                            foreach ($categs as $categ) {
                                                                echo "<option value=\"".$categ->cat_ID."\">".$categ->cat_name."</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                </div>
                                                <div class="col-md-4">
                                                        <h4 style="font-weight: 700;">Hash tags</h4>
                                                        <select id="profile-hash"  class="mt-multiselect btn btn-success" name="profile-hash[]" data-max-options="2" multiple="multiple" data-width="100%">
                                                            <?php
                                                            global $post;
                                                            $tags = wp_get_post_tags( $post->ID);

                                                            $tags = get_tags();
                                                            foreach ( $tags as $tag ) {
                                                                echo "<option value=\"".$tag->slug."\">".$tag->name."</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4 style="font-weight: 700;">Category brands</h4>
                                                    <select id="categoriesBrandsExp" name="categoriesBrands[]" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true" data-action-onchange="true">
                                                        <?
                                                        $args= array(
                                                          'child_of'     => get_category_by_slug( 'brands' )->term_id,
                                                          'hide_empty'   => 0,
                                                          'hierarchical' => true,
                                                          'orderby' => 'ID'
                                                        );
                                                        $categories = get_categories($args);
                                                        foreach ($categories as $key):?>
                                                            <option value="<?=$key->slug?>"><?=$key->name?></option>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="margin-top-10">
                                                        <button class="btn green" onclick="timeTab4();">Change save</button>
                                                    </div>
                                                </div>
                                                <div id="timeProfileTab4"></div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#categoriesBrandsExp').multiselect({
                                                            enableFiltering: true,
                                                            includeSelectAllOption: true,
                                                            selectAllJustVisible: false
                                                        });
                                                        $('#profile-hash').multiselect({
                                                            buttonClass: 'btn red'
                                                        });
                                                        $('#profile-categore').multiselect({
                                                            buttonClass: 'btn btn-success'
                                                        });
                                                    });
                                                </script>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->

    <script>
        function timeTab1() {
            Data = new Date();
            var Year = Data.getFullYear();
            var Month = Data.getMonth() + 1;
            var Day = Data.getDate();
            var Hour = Data.getHours();
            var Minutes = Data.getMinutes();
            var Seconds = Data.getSeconds();
            var out = Year+'-'+Month+'-'+Day+' '+Hour+':'+Minutes+':'+Seconds;
            var timePublish = document.getElementById('timeProfileTab1');
            timePublish.outerHTML = '<input type="hidden" name="timeProfile" value="'+out+'">'
        }
        function timeTab2() {
            Data = new Date();
            var Year = Data.getFullYear();
            var Month = Data.getMonth() + 1;
            var Day = Data.getDate();
            var Hour = Data.getHours();
            var Minutes = Data.getMinutes();
            var Seconds = Data.getSeconds();
            var out = Year+'-'+Month+'-'+Day+' '+Hour+':'+Minutes+':'+Seconds;
            var timePublish = document.getElementById('timeProfileTab2');
            timePublish.outerHTML = '<input type="hidden" name="timeProfile" value="'+out+'">'
        }
        function timeTab3() {
            Data = new Date();
            var Year = Data.getFullYear();
            var Month = Data.getMonth() + 1;
            var Day = Data.getDate();
            var Hour = Data.getHours();
            var Minutes = Data.getMinutes();
            var Seconds = Data.getSeconds();
            var out = Year+'-'+Month+'-'+Day+' '+Hour+':'+Minutes+':'+Seconds;
            var timePublish = document.getElementById('timeProfileTab3');
            timePublish.outerHTML = '<input type="hidden" name="timeProfile" value="'+out+'">'
        }
        function timeTab4() {
            Data = new Date();
            var Year = Data.getFullYear();
            var Month = Data.getMonth() + 1;
            var Day = Data.getDate();
            var Hour = Data.getHours();
            var Minutes = Data.getMinutes();
            var Seconds = Data.getSeconds();
            var out = Year+'-'+Month+'-'+Day+' '+Hour+':'+Minutes+':'+Seconds;
            var timePublish = document.getElementById('timeProfileTab4');
            timePublish.outerHTML = '<input type="hidden" name="timeProfile" value="'+out+'">'
        }
    </script>

<?php
get_footer('dashboard');
