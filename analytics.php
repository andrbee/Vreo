<?php
/*
 * Template name: Analytics
 */

get_header('dashboard');
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$tags = (array)get_the_tags();
if (!empty($tags)) {
    foreach ($tags as $tag) {
        $masiv[] = $tag->slug;
    }
}

if ($user_info->roles[0] == 'developer') {
    $args = array(
        'author' => $cur_user_id,
        'post_status' => 'publish,completed',
        'tag' => $masiv
    );
}
if ( $user_info->roles[0] == 'brand') {
    $resultBrandId = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_brand = $cur_user_id");
    $resultBrandIdCount =  count($resultBrandId) - 1;
    $argsDevId = [];
    for ($i = 0; $i <= $resultBrandIdCount; $i++){
        $argsDevId[] = $resultBrandId[$i]->id_dev;
    }
    $argsBrandId = array_unique($argsDevId);
    $args = array(
        'author__in' => $argsDevId,
        'post_status' => 'completed',
        'tag' => $masiv
    );
}

$posts3 = get_posts($args);
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
            <div class="breadcrumbs page-bar" typeof="BreadcrumbList" vocab="https://schema.org/">
                <ul class="page-breadcrumb">
                    <?php if (function_exists('bcn_display')) {
                        bcn_display();
                    } ?>
                </ul>
                <div class="page-toolbar">
                    <select id="mySelect" class="bs-select form-control input-small" data-style="btn-primary" style="">
                        <?php foreach ($posts3 as $key) {
                            echo "<option value=\"{$key->ID}\">" . $key->post_title . "</option>";
                        }
                        ?>
                    </select>

                    <script>

                    </script>
                    <div id="reportrange" class="tooltips btn pull-right bg-red-thunderbird bg-font-red-thunderbird btn-fit-height" >
                        <i class="icon-calendar"></i>&nbsp;
                        <span></span>
                        <input type="hidden" name="dateTime" id="dateTime">
                        <b class="caret"></b>
                    </div>
                    <script>
                        $(function() {
                            var start = moment().subtract(29, 'days');
                            var end = moment();
                            function cb(start, end) {
                                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                                    $('#dateTime').val(start.format('YYYY-MM-DD') + '_' + end.format('YYYY-MM-DD'));

                            }
                            $('#reportrange').daterangepicker({
                                startDate: start,
                                endDate: end,
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')]
                                }
                            },
                                cb);
                            cb(start, end);

                        });
                    </script>
                    <script>
                        $(window).load(function () {
                            var x = document.getElementById("mySelect").value;
                            var day = document.getElementById("dateTime").value;
                            $("#mySelect").change(function () {
                                x = document.getElementById("mySelect").value;
                                day = document.getElementById("dateTime").value;
                                $.ajax({
                                    type: "GET",
                                    url: '../wp-content/themes/metronic/inc/response.php?action=' + x + '&day=' + day,
                                    data: x,
                                    success: function (data) {
                                        $('#headerblock').html(data);
                                    }
                                });
                            });

                            $('.daterangepicker').mouseleave(function () {
                                var x = document.getElementById("mySelect").value;
                                var day = document.getElementById("dateTime").value;
                                $.ajax({
                                    type: "GET",
                                    url: '../wp-content/themes/metronic/inc/response.php?action=' + x + '&day=' + day,
                                    data: x,
                                    success: function (data) {
                                        $('#headerblock').html(data);
                                    }
                                });
                            });
                             $.ajax({
                                    type: "GET",
                                    url: '../wp-content/themes/metronic/inc/response.php?action=' + x + '&day=' + day,
                                    data: x,
                                    success: function (data) {
                                        $('#headerblock').html(data);
                                    }
                                });
                        });
                    </script>
                </div>
            </div>
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->
            <!-- BEGIN DASHBOARD STATS 1-->
            <!-- BEGIN PROFILE IMG -->
            <div id="headerblock"></div>
            <!-- END PROFILE IMG -->
            <div class="clearfix"></div>
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
<?php
get_footer('dashboard');
