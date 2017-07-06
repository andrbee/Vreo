<div class="login-content normal-registration">
    <div class="col-md-12">
        <div class="portlet light" id="form_wizard_1">
            <div class="portlet-body form">
                <form class="form-horizontal" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" id="submit_form" name="resetpassform" method="post" enctype="multipart/form-data">


                    <div class="form-wizard">
                        <div class="form-body">
                            <ul class="nav nav-pills nav-justified steps" id="stepsMenu">
                                <li class="active">
                                    <a href="#tab1" data-toggle="tab" class="step" aria-expanded="true">
                                        <span class="number"> 1 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Developer or Brand?
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab2" data-toggle="tab" class="step">
                                        <span class="number"> 2 </span>
                                         <span class="desc">
                                            <i class="fa fa-check"></i> Account information
                                         </span>
                                    </a>
                                </li>
                                <li id="stepTab3">
                                    <a href="#tab3" data-toggle="tab" class="step active">
                                        <span class="number"> 3 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Company verification
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab4" data-toggle="tab" class="step">
                                        <span class="number"> 4 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Customize you account
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab5" data-toggle="tab" class="step">
                                        <span class="number"> 5 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> General Terms and Conditions
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab6" data-toggle="tab" class="step">
                                        <span class="number"> 6 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Summary of the account information
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <div id="bar" class="progress progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-success" style="width: 25%;"></div>
                            </div>
                            <div class="tab-content">
                                <div class="alert alert-success display-none" style="display: none;">
                                    <button class="close" data-dismiss="alert"></button>
                                    Your form validation is successful!
                                </div>
                                <div class="tab-pane active" id="tab1">
                                    <h3 class="block">Step 1/6 Developer or Brand?</h3>
                                    <p>Please choose an account type – as a developer, you can start campaigns showcasing your software, as a brand, you can place your ads within this software. </p>
                                    <div class="form-group form-md-radios">
                                        <div class="md-radio-inline">
                                            <div class="md-radio role-registration" onclick="check(this, 'developer');">
                                                <input  type="radio" id="checkbox9_8"  name="wp_rar_user_role"
                                                       value="developer" class="md-radiobtn" required>
                                                <label for="checkbox9_8" class="radio-registration">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                                <div class="role-registration--desc">
                                                    <div>Developer/Publisher</div>
                                                    <span>Do you want to offer spots for ad-placement within your software? Please register as developer.</span>
                                                </div>
                                            </div>
                                            <div class="role-registration--choice">or</div>
                                            <div class="md-radio role-registration" onclick="check(this, 'brand');">
                                                <input type="radio" id="checkbox9_9" name="wp_rar_user_role"
                                                       value="brand" class="md-radiobtn" >
                                                <label for="checkbox9_9" class="radio-registration">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                                <div class="role-registration--desc">
                                                    <div>Brand/Agency/Marketeer</div>
                                                    <span>Are you planning on placing ads? Please register as brand.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <h3 class="block">Step 2/6 Account information</h3>
                                    <p>Please enter your account information below.</p>

                                    <!-- First name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">First name
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
                                                      <span class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                      </span>
                                                    <input type="text" class="form-control" name="first_name" id="userName" onKeyUp="javascript:document.getElementById('req_userName').innerHTML = this.value;" autocomplete="off">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- End first name -->

                                    <!-- Surname name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Surname
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="fa fa-user"></i>
                                                  </span>
                                                    <input type="text" class="form-control" name="last_name" id="userSurname" onKeyUp="javascript:document.getElementById('req_userSurname').innerHTML = this.value;" autocomplete="off">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- End surname name -->

                                    <!-- Nickname name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Nickname
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group" style="position: relative;">
                                                  <span class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                  </span>
                                                    <input type="text" class="form-control" name="user_login" id="userNick" onKeyUp="javascript:document.getElementById('req_userNick').innerHTML = this.value;" autocomplete="off">
                                                    <span id="validLoginNormal"></span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- End nickname name -->

                                    <!-- Company name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Company name
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-institution"></i>
													</span>
                                                    <input type="text" class="form-control" name="companyname" id="companyname" onKeyUp="javascript:document.getElementById('req_companyname').innerHTML = this.value;" autocomplete="off">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- End company name -->

                                    <!-- Telephone  -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Telephone
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-phone"></i>
													</span>
                                                    <input type="tel" class="form-control" name="phone" id="userPhone" onKeyUp="javascript:document.getElementById('req_userPhone').innerHTML = this.value;" pattern="^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){5,20}(\s*)?$" autocomplete="off">
                                                </div>
                                        </div>
                                    </div>
                                    <!-- End telephone  -->

                                    <!-- E-mail address -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">E-mail address
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group" style="position: relative;">
                                                  <span class="input-group-addon">
                                                    <i class="fa fa-envelope-o"></i>
                                                  </span>
                                                    <input type="email" class="form-control" name="user_email" id="userEmail" onKeyUp="javascript:document.getElementById('req_userEmail').innerHTML = this.value;" autocomplete="off">
                                                    <span id="validEmailNormal"></span>
                                                </div>
                                        </div>
                                    </div>
                                    <!-- End e-mail address -->

                                    <!-- Address -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Address
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-home"></i>
													</span>
                                                    <input type="text" class="form-control" name="address" id="address" onKeyUp="javascript:document.getElementById('req_address').innerHTML = this.value;" autocomplete="off">
                                                </div>
                                        </div>
                                    </div>
                                    <!-- End address -->

                                    <!-- Zipcode and City -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Zipcode and City
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-home"></i>
													</span>
                                                    <input type="text" class="form-control" name="zipcode" id="fax" onKeyUp="javascript:document.getElementById('req_fax').innerHTML = this.value;">
                                                </div>
                                        </div>
                                    </div>
                                    <!-- End zipcode and City -->

                                    <!-- Country -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Country
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
                                                  <span class="input-group-addon">
                                                    <i class="fa fa-globe"></i>
                                                  </span>
                                                    <?php
                                                    require_once('countries.php');
                                                    ?>
                                                    <select class="form-control" name="user_country" id="country" onchange="javascript:document.getElementById('req_country').innerHTML = this.options[this.selectedIndex].innerHTML;" required>
                                                        <? foreach ($countries as $key=>$value):?>
                                                            <option value="<?=$key?>"><?=$value?></option>
                                                        <? endforeach; ?>
                                                    </select>
<!--                                                    <input type="text" class="form-control" name="country" id="country" onKeyUp="javascript:document.getElementById('req_country').innerHTML = this.value;">-->
                                                </div>
                                        </div>
                                    </div>
                                    <!-- End country -->

                                    <!-- Category -->
                                    <div class="col-md-6" id="categoriesBrandsNormDiv">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Category
                                                <span class="required" aria-required="true"> * </span>
                                                  
                                                    <select id="categoriesBrandsNorm" name="categoriesBrands[]" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true" data-action-onchange="true">
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
                                    </div>
                                    <!-- End category -->

                                    <div id="brands-invisible" class="col-md-6">
                                        <div class="form-group">
                                            <p>If you don't want your profile to appear on the marketplace, check the box below. You can change this setting any time.</p>
                                            <div class="mt-checkbox-list">
                                                <label class="mt-checkbox"> Make me invisible
                                                    <input type="checkbox" id="brandsCheckbox" value="invisible" name="visible_brand">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12"><p>Fields marked with an asterisk <sup>*</sup> are required</p></div>

                                </div>
                                <div class="tab-pane" id="tab3">
                                    <h3 class="block">Step 3/6: Company verification</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam autem eaque
                                        iure molestias similique. Dicta doloremque earum excepturi, in libero nemo nisi
                                        obcaecati omnis, perferendis </p>
                                    <!--<div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Surname
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
                                                    <input type="text" class="form-control" name="paymentSurname" id="paymentSurname" onKeyUp="javascript:document.getElementById('req_paymentSurname').innerHTML = this.value;" autocomplete="off">
                                                </div>
                                            </label>
                                        </div>
                                    </div>-->
                                   <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Company name
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-institution"></i>
													</span>
                                                    <input type="text" class="form-control" name="paymentCompanyname" id="paymentCompanyname" onKeyUp="javascript:document.getElementById('req_paymentCompanyname').innerHTML = this.value;" autocomplete="off">
                                                </div>
                                            </label>
                                        </div>
                                    </div>-->
                                    <!--<div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Address
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
													<span class="input-group-addon">
                                                        <i class="fa fa-home"></i>
													</span>
                                                    <input type="text" class="form-control" name="paymentAddress" id="paymentAddress" onKeyUp="javascript:document.getElementById('req_paymentAddress').innerHTML = this.value;" autocomplete="off">
                                                </div>
                                        </div>
                                    </div>-->
                                  <!--  <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-11">Country
                                                <span class="required" aria-required="true"> * </span>
                                                <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-globe"></i>
                                              </span>
                                                    <select class="form-control" name="paymentCountry" id="paymentCountry" onchange="javascript:document.getElementById('req_paymentCountry').innerHTML = this.options[this.selectedIndex].innerHTML;" required>
                                                        <?/* foreach ($countries as $key=>$value):*/?>
                                                            <option value="<?/*=$key*/?>"><?/*=$value*/?></option>
                                                        <?/* endforeach; */?>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label for="exampleInputFile1">Upload verification documents</label>
                                        <?php wp_nonce_field( 'verificationDoc', 'verificationDocUpload' ); ?>
                                        <input type="file" name="verificationDoc" id="verificationDoc2">                                      
                                        <p class="help-block">Copy of ID card of CEO and trade register excerpt</p>
                                    </div>
                                    <!--<div class="form-group form-md-radios">
                                        <div class="md-radio-inline">
                                            <h4>Choose payment method:</h4>
                                            <div class="md-radio payment-selector">
                                                <input type="radio" id="checkbox10_1" name="payment" value="Visa"
                                                       class="md-radiobtn ">
                                                <label for="checkbox10_1" class="radio-payment">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span></label>
                                            </div>
                                            <div class="md-radio payment-selector">
                                                <input type="radio" id="checkbox10_2" name="payment" value="Amex"
                                                       class="md-radiobtn ">
                                                <label for="checkbox10_2" class="radio-payment">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span></label>
                                            </div>
                                            <div class="md-radio payment-selector">
                                                <input type="radio" id="checkbox10_3" name="payment" value="Amazon"
                                                       class="md-radiobtn ">
                                                <label for="checkbox10_3" class="radio-payment">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span></label>
                                            </div>
                                            <div class="md-radio payment-selector">
                                                <input type="radio" id="checkbox10_4" name="payment" value="PayPal"
                                                       class="md-radiobtn ">
                                                <label for="checkbox10_4" class="radio-payment">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span></label>
                                            </div>
                                            <div class="md-radio payment-selector">
                                                <input type="radio" id="checkbox10_5" name="payment" value="Stripe"
                                                       class="md-radiobtn ">
                                                <label for="checkbox10_5" class="radio-payment">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span></label>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="col-md-12"><p>Fields marked with an asterisk <sup>*</sup> are required</p></div>
                                </div>
                                <div class="tab-pane" id="tab4">
                                    <h3 class="block">Step 4/6: Customize you account </h3>
                                    <p>To customize your account, you can add a profile pic and a header pic. You can also skip this step and customize your account later on.</p>
                                    <div class="row">
                                        <div class="form-group last col-md-5 col-xs-12 col-sm-6 col-lg-5 form-profile-image">

                                            <label class="control-label">
                                                <div class="form-header-image__title">Add profile pic</div>
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

                                        <div class="form-group last col-md-5 col-xs-12 col-sm-6 col-lg-5 form-header-image">
                                            <label class="control-label ">
                                                <div class="form-header-image__title">Add header profile pic</div>
                                            <!--<div class="col-md-9">-->
                                                <div class="fileinput fileinput-new " data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail fileinput-cover-header" >
                                                        <div class="fileinput-header-image">
                                                            <div class="image-desc">add pic</div>
                                                        </div>
<!--                                                        <img src="http://www.placehold.it/300x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>-->
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                    <div>
                                                        <p>Picture needs to have a size of 1280x450px</p>
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
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab5">
                                    <h3 class="block">Step 5/6:  General Terms and Conditions  </h3>
                                    <p>With your registration with vreo you accept our General Terms and Conditions.</p>
                                    <div class="form-group last">
                                        <div class="col-md-9">
                                            <p>

                                            </p>
                                            <div class="mt-checkbox-list">
                                                <label class="mt-checkbox mt-checkbox-outline">
                                                    <input type="checkbox" name="checkboxAgree" required> I agree with the terms <a href="<?=content_url('/uploads/docs/Advertiser_AGB.PDF')?>" id="stepFiveBrand">Advertiser AGB</a>, <a href="<?=content_url('/uploads/docs/Publisher_AGB.PDF')?>" id="stepFiveDev">Publisher AGB</a>&nbsp;
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="mt-checkbox-list">
                                                <label class="mt-checkbox mt-checkbox-outline">
                                                    <input type="checkbox" name="checkboxNotification"> I agree to receive weekly notifications &nbsp;
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tab6">
                                    <h3 class="block">Step 6/6:  Summary of the account information</h3>
                                    <p>To finalize your registration, please check if the information you entered is correct.</p>
                                    <div class="form-group last">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-5 col-xs-12 col-sm-6 col-lg-5">
                                                    <h4>Account information</h4>
                                                    <p>
                                                        <strong>First name: </strong><br>
                                                        <span id="req_userName"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Surname: </strong><br>
                                                        <span id="req_userSurname"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Nickname: </strong><br>
                                                        <span id="req_userNick"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Company name: </strong><br>
                                                        <span id="req_companyname"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Telephone: </strong><br>
                                                        <span id="req_userPhone"></span>
                                                    </p>
                                                    <p>
                                                        <strong>E-mail address: </strong><br>
                                                        <span id="req_userEmail"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Address: </strong><br>
                                                        <span id="req_address"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Zipcode and City: </strong><br>
                                                        <span id="req_fax"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Country: </strong><br>
                                                        <span id="req_country"></span>
                                                    </p>
                                                </div>
                                               <!-- <div class="col-md-5 col-xs-12 col-sm-6 col-lg-5">
                                                    <h4>Payment information</h4>
                                                    <p>
                                                        <strong>Surname: </strong>
                                                        <span id="req_paymentSurname"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Company name: </strong>
                                                        <span id="req_paymentCompanyname"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Address: </strong>
                                                        <span id="req_paymentAddress"></span>
                                                    </p>
                                                    <p>
                                                        <strong>Country: </strong>
                                                        <span id="req_paymentCountry"></span>
                                                    </p>
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="javascript:;" class="btn default button-previous disabled"
                                       style="display: none;">
                                        <i class="fa fa-angle-left"></i> Back </a>
                                    <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <button type="submit" class="btn green button-submit" id="wp-submit" style="display: none;">
                                        Sing Up
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  /*  function hide(obj) {
        var el = document.getElementById(obj);
        el.parentNode.removeChild(el);
    }
 */
      var brandsInvisible = document.getElementById('brands-invisible');
      var stepFiveDev = document.getElementById('stepFiveDev');
      var stepFiveBrand = document.getElementById('stepFiveBrand');
      var categoriesBrandsNormDiv = document.getElementById('categoriesBrandsNormDiv');
      brandsInvisible.style.display='none';
      categoriesBrandsNormDiv.style.display = 'none';
    function check(e, checkboxActive) {
        let elem = document.getElementsByClassName("role-registration");
        var brandsChecbox = document.getElementById('brandsCheckbox');
//        console.log(elem);

        let target = e;
        for (let i=0; i<elem.length; i++) {
            if(elem[i]==(target)) {
               elem[i].firstElementChild.setAttribute("checked", "checked");
               elem[i].classList.add("active");
           }
            else {
                elem[i].firstElementChild.removeAttribute("checked", "checked");
                elem[i].classList.remove("active");
            }
        }
        if(checkboxActive == 'brand') {
            brandsInvisible.style.display = 'inline-block';
            stepFiveBrand.style.display = 'inline-block';
            stepFiveDev.style.display = 'none';
            categoriesBrandsNormDiv.style.display = 'inline-block';
            brandsChecbox.value = 'invisible';
            brandsChecbox.name = 'visible_brand';
        } else {
            brandsInvisible.style.display = 'none';
            stepFiveDev.style.display = 'inline-block';
            stepFiveBrand.style.display = 'none';
            categoriesBrandsNormDiv.style.display = 'none';
            brandsChecbox.value = 'visible';
            brandsChecbox.name = 'visible_developer';
        }
    }


</script>