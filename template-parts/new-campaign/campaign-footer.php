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
            <div
                class="profile-usertitle-name"> <?= $user_info->first_name; ?> <?= $user_info->last_name; ?> </div>
            <div class="profile-usertitle-job"> <?= $user_info->roles[0]; ?> </div>
        </div>
        <!-- END SIDEBAR USER TITLE -->
        <!-- SIDEBAR BUTTONS -->
        <!-- <div class="profile-userbuttons">
             <button type="button" class="btn btn-circle green btn-sm">Connect</button>
             <button type="button" class="btn btn-circle red btn-sm">Message</button>
         </div>-->
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