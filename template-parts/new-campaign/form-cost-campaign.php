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
                    <div class="iter_up" onclick="iterCostPerView(this)"><i class="fa fa-caret-up" aria-hidden="true"></i></div>
                    <div class="iter_down" onclick="iterCostPerView(this)"><i class="fa fa-caret-down" aria-hidden="true"></i></div>
                    <label for="cpv"></label>
                    <input  name="cost-campaign"
                                           id="cost-campaign" required
                                           style="width: 85px; color:black;" onkeydown="return convertPriceCPV(this,event,'<?=$user_info->roles[0]?>')"></div>
                <!-- <input type="text" name="cost-campaign"  value="" required style="width: 100px; color:black;">&#8364;</div> -->
                <div class="desc"> Cost per view<span class="required" style="color:red;"
                                                      aria-required="true">*</span></div>
            </div>
            <div class="dasborard-campaign">
                <div class="number"><input type="number" min="0" step="1" name="pic-number-campaign"
                                           id="pic-number-campaign" value="" required onkeypress="return inputOnlyInteger(this,event)"
                                           style="width: 70px; color:black;">x
                </div>
                <div class="desc"> Picture advertising <span class="required" style="color:red;"
                                                             aria-required="true">*</span></div>
            </div>
            <div class="dasborard-campaign">
                <div class="number"><input type="number" min="0" step="1" name="video-number-campaign"
                                           id="video-number-campaign" value="" required onkeypress="return inputOnlyInteger(this,event)"
                                           style="width: 70px; color:black;">x
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
                            alert("Picture advertising and Video advertising not contain two input zeros. Enter accurate data.");
                        }
                    });
                });
            </script>
            <div class="dasborard-campaign"> </div>
            <div class="dasborard-campaign">
                <div class="number"> <label for="bp" style="margin-right: 20px;"></label><input type="number" min="5" step="5" name="budget-number-campaign" onchange="changeConvertPriceBudget(this,'<?=$user_info->roles[0]?>')" onkeydown="return convertPriceBudget(this,event,'<?=$user_info->roles[0]?>')"
                                           value="" required style="width: 100px; color:black;"> &#8364;
                </div>
                <div class="desc"> Minimum budget <span class="required" style="color:red;"
                                                        aria-required="true">*</span></div>
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