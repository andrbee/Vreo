<?php
/*
 * Template name: New Campaign
 */

get_header('dashboard');

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
if (in_array('developer', $user_info->roles)) {
    $rolePath = 'Developers';
} elseif (in_array('brand', $user_info->roles)) {
    $rolePath = 'Brands';
} else {
    $rolePath = 'Guests';
}
$rolePath .= "/" . $user_info->user_nicename;

?>


    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" height="3000">
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

        <form id="campaign-form" role="form"
              action="<?php echo get_stylesheet_directory_uri() ?>/inc/campaign-registration.php"
              enctype="multipart/form-data" method="POST" onsubmit="return checkAllElemForm(this,event)">
            <!-- Button save and public -->
            <?php require_once __DIR__ . '/template-parts/new-campaign/form-button-header.php'; ?>
            <!-- End button save and public -->
            <!-- BEGIN New campaign header img -->
            <?php require_once __DIR__ . '/template-parts/new-campaign/form-campaign-header.php'; ?>
            <!-- END New campaign header img -->

            <!-- Begin main block -->
            <?php require_once __DIR__ . '/template-parts/new-campaign/form-main-campaign.php'; ?>
            <!-- End main block -->

            <!-- Blue block -->           
            <?php require_once __DIR__ . '/template-parts/new-campaign/form-cost-campaign.php'; ?>
            <!-- End blue block -->

            <div class="clearfix"></div>
            <!-- END DASHBOARD STATS 1-->
            <!-- Slider and textarea -->
            <?php require_once __DIR__ . '/template-parts/new-campaign/form-footer.php'; ?>
            <!-- End slider and textarea -->

            <!-- Begin button save and public -->
            <?php require_once __DIR__ . '/template-parts/new-campaign/form-button-footer.php'; ?>
            <!-- End begin button save and public -->
            
            <script>
                function validationText() {
                    var editorRequired = CKEDITOR.instances['editor7'].getData();
                    var flag = 0;
                    if (editorRequired == '') {
                        $("#intro-text").html(" Required");
                        flag = 0;
                    }
                    if ((editorRequired !== '')) {
                        flag = 1;
                    }
                    if (flag == 1) {
                        // $('#campaign-form').submit();
                    }
                    ;

                }
                ;
            </script>
            <div id="timePublish"></div>
        </form>
        <!-- End button save and public -->

        <!-- New campaign footer -->
        <?php require_once __DIR__ . '/template-parts/new-campaign/campaign-footer.php'; ?>
        <!-- End campaign footer -->

        <!-- END CONTENT BODY -->
        <!-- END CONTENT -->
    </div>
    <script src="<?= get_template_directory_uri() ?>/js/inputOnlyNum.js" type="text/javascript"></script>
    <script src="<?= get_template_directory_uri() ?>/js/convertPrice.js" type="text/javascript"></script>
    <script src="<?= get_template_directory_uri() ?>/js/checkAllElemForm.js" type="text/javascript"></script>
    <script>
        function timePost() {
            Data = new Date();
            var Year = Data.getFullYear();
            var Month = Data.getMonth() + 1;
            var Day = Data.getDate();
            var Hour = Data.getHours();
            var Minutes = Data.getMinutes();
            var Seconds = Data.getSeconds();
            var out = Year + '-' + Month + '-' + Day + ' ' + Hour + ':' + Minutes + ':' + Seconds;
            var timePublish = document.getElementById('timePublish');
            timePublish.outerHTML = '<input type="hidden" name="timePublish" value="' + out + '">';
        }
    </script>
    <script> $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
    <script>
        var upload_size_all_files = 0;
        var sizeFilesProfile = 0;
        var path_profile = "<?=$rolePath?>";
        $.post('<?=get_template_directory_uri()?>/inc/profile_disk_space_amazon.php', {
            rolePath: path_profile
        }, function (data) // отправляем GET запрос на href, указанный в ссылке
        {
            sizeFilesProfile = Number(data);
        });


        function uploadFilesSize() {
            upload_size_all_files = 0;
            var el = [];
            var message = 0;

            el.push(document.getElementById("campaign-bg-header"));
            el.push(document.getElementById("campaign-age"));
            el.push(document.getElementById("campaign_video"));
            el.push(document.getElementById("campaign-image"));
            el.push(document.getElementById("campaign-bg"));
            var i = 0;
            for (; i < el.length; i++) {
                var k = 0;
                var files = el[i].files;
                var len = files.length;

                for (; k < len; k++) {
                    upload_size_all_files += files[k].size;
//                    console.log("Filename: " + files[k].name);
//                console.log("Type: " + files[k].type);
//                    console.log("Size: " + files[k].size + " bytes");
                }
//                upload_size_all_files += sizeFilesProfile;
                message = upload_size_all_files;
                if ((upload_size_all_files + sizeFilesProfile) > 524288000) {
                    var submitButtons = document.querySelectorAll("button[name='active']");
                    var s = 0;
                    for (; s < submitButtons.length; s++) {
                        submitButtons[s].disabled = true;

                    }
//                    console.log((upload_size_all_files / 1024) / 1024);

                    if (i === (el.length - 1)) {
                        alert('The files selected by you exceed your 500mb limit');
                    }
                } else {
                    var submitButtons = document.querySelectorAll("button[name='active']");
                    var s = 0;
                    for (; s < submitButtons.length; s++) {
                        submitButtons[s].disabled = false;

                    }
                }
//                console.log("Вы выбрали файлов на " + (((message+sizeFilesProfile)/1024)/1024) + " mb");
            }
        }

    </script>
<?php
require_once get_template_directory() . '/template-parts/content-previes.php';
get_footer('dashboard');
