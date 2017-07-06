<div class="login-content express-registration">
    <h1>Express registration</h1>
    <p class="exp-reg-description"> Please enter the required information below.</p>
    <div class="col-md-9">
        <div class="portlet-body">
            <!-- BEGIN FORM-->
            <form class="form-horizontal"
                  action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>"
                  onsubmit="return checkingForm(this,event);" id="submit_form_exp" name="resetpassform" method="post"
                  autocomplete="off">
                <div class="form-body">
                    <div class="form-group form-md-line-input" style="position: relative;">
                        <input type="text" class="user-login form-control" name="user_login" id="form_control_1"
                               placeholder="Username" required pattern="[a-zA-Z0-9_]+" autocomplete="off">
                        <span id="validLogin"></span>
                        <label for="form_control_1">
                            <span class="required"></span>
                        </label>
                        <span class="help-block">Enter your name...</span>
                    </div>
                    <div class="form-group form-md-line-input">
                        <input class="form-control" type="password" id="form_control_1" placeholder="Password"
                               name="pwd2" required autocomplete="off">
                        <label for="form_control_1">
                            <span class="required"></span>
                        </label>
                        <span class="help-block">Enter your password...</span>
                    </div>
                    <div class="form-group form-md-line-input">
                        <input type="email" class="email1 form-control" id="form_control_1 diag_nap_uchr"
                               name="user_email" placeholder="Email" required
                               pattern="^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$"
                               autocomplete="off">
                        <span id="validEmailFirst"></span>
                        <label for="form_control_1">
                            <span class="required"></span>
                        </label>
                        <span class="help-block">Please enter your email...</span>
                    </div>
                    <div class="form-group form-md-line-input" style="position: relative;">
                        <input type="email" class="email2 form-control" id="form_control_1 diag_osn" name="email2"
                               placeholder="Confirm email" required
                               pattern="^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$"
                               autocomplete="off">
                        <span id="validEmail"></span>
                        <label for="form_control_1">
                            <span class="required"></span>
                        </label>
                        <span class="help-block">Please enter your email...</span>
                    </div>
                    <p style="margin: 0;">Date of birth</p>
                    <div class="col-md-6">
                        <div class="form-group form-md-line-input">
                            <select class="form-control" name="user_month" required>
                                <option value="" selected="selected">Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="form_control_1" name="user_date"
                                   placeholder="Date" pattern="[0-9]+" title="1-31" autocomplete="off" required>
                            <label for="form_control_1">
                                <span class="required"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="form_control_1" name="user_year"
                                   placeholder="Year" pattern="[0-9]+" title="(YYYY)" autocomplete="off" required>
                            <label for="form_control_1">
                                <span class="required"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group form-md-radios">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="checkbox2_8" name="user_gender" value="Male"
                                       class="md-radiobtn">
                                <label for="checkbox2_8">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Male </label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" id="checkbox2_9" name="user_gender" value="Female"
                                       class="md-radiobtn">
                                <label for="checkbox2_9">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Female </label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" id="checkbox2_10" name="user_gender" value="Non-binary"
                                       class="md-radiobtn">
                                <label for="checkbox2_10">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Non-binary </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-md-radios" style="margin: 0;">
                            <label for="form_control_1">Developer or Brand?</label>
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="checkbox8_8" name="wp_rar_user_role"
                                           onclick="brandInvisible(this);" value="developer" class="md-radiobtn"
                                           checked>
                                    <label for="checkbox8_8">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Developer</label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="checkbox8_9" name="wp_rar_user_role"
                                           onclick="brandInvisible(this);" value="brand" class="md-radiobtn">
                                    <label for="checkbox8_9">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Brand </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-md-line-input">
                            <p style="margin: 0;">Country</p>
                            <?php
                            require_once('countries.php');
                            ?>
                            <select class="form-control" name="user_country" required>
                                <? foreach ($countries as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" id="categoriesBrandsExpDiv">
                        <div class="form-group form-md-line-input">
                            <p style="margin: 0;">Category </p>
                            <select id="categoriesBrandsExp" name="categoriesBrands[]"
                                    class="mt-multiselect btn btn-default" multiple="multiple" data-label="left"
                                    data-select-all="true" data-width="100%" data-filter="true"
                                    data-action-onchange="true">
                                <?
                                $args = array(
                                    'child_of' => get_category_by_slug('brands')->term_id,
                                    'hide_empty' => 0,
                                    'hierarchical' => true,
                                    'orderby' => 'ID'
                                );
                                $categories = get_categories($args);
                                foreach ($categories as $key):?>
                                    <option value="<?= $key->slug ?>"><?= $key->name ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div id="brands-exp-invisible" style="height: 60px;" class="col-md-6">
                        <div class="form-group">
                            <p style="margin: 0;">If you don't want your profile to appear on the marketplace, check the box below. You can change this setting any time.</p>
                            <div class="mt-checkbox-list">
                                <label class="mt-checkbox" style="margin: 0;"> Make me invisible
                                    <input type="checkbox" id="brandsExpCheckbox" value="invisible"
                                           name="visible_brand">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <script>
                        var brandsExpInvisible = document.getElementById('brands-exp-invisible');
                        var categoriesBrandsExpDiv = document.getElementById('categoriesBrandsExpDiv');
                        brandsExpInvisible.style.display = 'none';
                        categoriesBrandsExpDiv.style.display = 'none';
                        function brandInvisible(e) {
                            var brandsExpChecbox = document.getElementById('brandsExpCheckbox');
                            var radioActive = e;
                            if (radioActive.value == 'brand') {
                                brandsExpInvisible.style.display = 'inline-block';
                                categoriesBrandsExpDiv.style.display = 'inline-block';
                                brandsExpChecbox.value = 'invisible';
                                brandsExpChecbox.name = 'visible_brand';
                            } else {
                                brandsExpInvisible.style.display = 'none';
                                categoriesBrandsExpDiv.style.display = 'none';
                                brandsExpChecbox.value = 'visible';
                                brandsExpChecbox.name = 'visible_developer';
                            }
                        }
                    </script>
                    <script>
                        function checkingForm(elem, event) {
                            var chbxMale = document.getElementById("checkbox2_8");
                            var chbxFeMale = document.getElementById("checkbox2_9");
                            var chbxNonBinary = document.getElementById("checkbox2_10");

                            var chbxDeveloper = document.getElementById("checkbox8_8");
                            var chbxBrand = document.getElementById("checkbox8_9");
                            if ((chbxMale.checked == true || chbxFeMale.checked == true || chbxNonBinary.checked == true) && (chbxDeveloper.checked == true || chbxBrand.checked == true)) {
                                console.log("true");
                                return;
                            } else {
                                console.log("false");
                                return false;
                            }

                        }
                    </script>
                    <div class="col-md-12">
                        <p>By clicking on Sign up, you agree to <a href="#">Vreo terms & conditions</a> and <a href="#">privacy
                                policy</a></p>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="wp-submit" class="btn blue">Sign Up</button>
                            <button type="button" id="back-btn-expReg" class="btn blue btn-outline">Back</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>

    </div>
</div>

