<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-includes/pluggable.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
$config = require TEMPLATEPATH . '/inc/config.php';
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$url = explode("?", $_SERVER['HTTP_REFERER']);
require_once(dirname(__FILE__) . '/../../../../wp-load.php');
global $wpdb;


$numberPost = $_GET['action'];
$daySerch = htmlspecialchars($_GET['day']);

$dayArgs = explode('_', $daySerch);
$dataStart = $dayArgs[0];
$dataEnd = $dayArgs[1];
$bdData = "AND DATE(data) >= '$dataStart' AND DATE(data) <= '$dataEnd'";

if ($user_info->roles[0] == 'developer') {
    $postList = query_posts(array('p' => $numberPost, 'post_status' => array('publish,completed')));
    $resultSendView = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_id = $cur_user_id AND developer_game_id = $numberPost $bdData");
    $resultSendViewNoData = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_id = $cur_user_id AND developer_game_id = $numberPost ORDER BY data DESC LIMIT 7");

    $resultSendDeviceId = $wpdb->get_results("SELECT developer_id, developer_game_id,COUNT(DISTINCT device_id) FROM pl_send_advertiser_ad_view_data WHERE developer_id = $cur_user_id AND developer_game_id = $numberPost $bdData");
}
if ($user_info->roles[0] == 'brand') {
    $resultBrandId = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_brand = $cur_user_id");
    $idDev = $resultBrandId[0]->id_dev;
    $resultSendView = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_id = $idDev AND developer_game_id = $numberPost $bdData");
    $resultSendViewNoData = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_id = $idDev AND developer_game_id = $numberPost ORDER BY data DESC LIMIT 7");
    $resultSendDeviceId = $wpdb->get_results("SELECT developer_id, developer_game_id,COUNT(DISTINCT device_id) FROM pl_send_advertiser_ad_view_data WHERE developer_id = $idDev AND developer_game_id = $numberPost $bdData");
    $postList = query_posts(array('p' => $numberPost, 'post_status' => array('completed')));
}
foreach ($postList as $key) {
    $post_author = $key->post_author;
    $imgHeader = $key->campaign_bg_header_file;
    $cost_per_view = $key->cost_campaign;
    $budget_number_campaign = $key->budget_number_campaign;
    $id = $key->ID;
    $res = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_game_id={$id} $bdData");
    $total_percentage = 0;
    $platform;
    $total_payments = 0;
}
function score($screen_percentage, $cost_per_view)
{
    $percentage = $screen_percentage;
    $cost = $cost_per_view;
    if ($percentage >= 3 && $percentage <= 10) {
        return round((($percentage / 100) * 10), 3);
    } elseif ($percentage >= 10) {
        return 1;
    } else {
        return 0;
    }
}

$countSendDeviceId = count($res);
$countdDeviceId = 0;
//foreach ($resultSendDeviceId[0] as $key) {
//
//    if ($countdDeviceId == 2) {
//        $countSendDeviceId = $key;
//    }
//    $countdDeviceId++;
//}
$totalHitTime = 0;
$chartJSON = array();
$chartJsonNoData = array();
foreach ($resultSendView as $key) {
    $totalHitTime += $key->total_hit_time;

    $chartJSON[] = [
        "year" => $key->data,
        "value" => round($key->total_hit_time)
    ];
}

foreach ($resultSendViewNoData as $key) {
    $id = $key->developer_id;
    $dataStart7 = $key->data;
    $d=$key->data;
    $date7 = new DateTime($d);
    $dateView = new DateTime($dataStart7);
    $date7->modify("-7 day");
    $dataEnd7 =  $date7->format('Y-m-d H:i:s');
    $dataEndView =  $date7->format('Y-m-d');
    $dataStartView =  $dateView->format('Y-m-d');

    $bdDataFor = "AND DATE(data) <= '$dataStart7' AND DATE(data) >= '$dataEnd7'";
    $resultSendViewNoData2 = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_id = $id AND developer_game_id = $numberPost $bdDataFor");
    $chartJsonNoData[] =
            [
                "year" => "{$dataStartView} <br> {$dataEndView}",
                "income" => count($resultSendViewNoData2),
                "expenses" => count($resultSendViewNoData2)
            ];
}

$chartJSON = json_encode($chartJSON);
$chartJsonNoData = json_encode($chartJsonNoData);

if ($user_info->roles[0] == 'developer') {
    $getPluginResultAction = $wpdb->get_results("SELECT * FROM pl_get_random_advertiser WHERE developer_id = $cur_user_id AND developer_game_id = $numberPost ");
} elseif ($user_info->roles[0] == 'brand') {
    $getPluginResultAction = $wpdb->get_results("SELECT * FROM pl_get_random_advertiser WHERE developer_game_id = $numberPost AND advertiser_ad_id = $cur_user_id");
}

if ($getPluginResultAction):
    ?>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="profile">
                <img src="<?= $config['s3']['cdnPath'] . "/" . $imgHeader; ?>" class="profile-img"
                     alt="profile background users">

                <div class="profile-company">
                    <? if ($user_info->user_login == 'developer4') { ?><img
                        src="<?= get_template_directory_uri() ?>/assets/pages/img/flag/de.png" width="34" height="34"
                        alt="Сountry flag" class="profile-company__img">
                    <? } else { ?><img
                        src="<?= get_template_directory_uri() ?>/assets/img/flags/<?= strtolower($user_info->country); ?>.png"
                        width="34" height="34" alt="Сountry flag" class="profile-company__img"><? } ?>
                    <h2 class="profile-company__name"><?= $user_info->companyname ?></h2>
                    <?php
                    require_once('../template-parts/countries.php');
                    foreach ($countries as $key => $value) {
                        if ($user_info->country == $key) {
                            $countriProfile = $value;
                            break;
                        }
                    }
                    ?>
                    <p class="profile-company__address"><?= $user_info->address ?>, <?= $user_info->country ?></p>
                </div>
                <div class="profile-user">
                    <img src="<?= $user_info->profilePic; ?>" class="profile-user__img"
                         alt="<?= $user_info->user_nicename ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
            <div class="dashboard-stat blue">
                <div class="visual">
                    <img
                        src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/visible-opened-eye-interface-option.png"
                        alt="">
                </div>
                <div class="details">
                    <div class="number"> <?php echo round($totalHitTime, 3) . ' sec.'; ?></div>
                    <div class="desc"> Total time</div>
                </div>
                <a class="more" href="javascript:;"> More details
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat bg-purple-seance bg-font-purple-seance">
                <div class="visual">
                    <img src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/icon_globe.png"
                         alt="">
                </div>
                <div class="details">
                    <div class="number"> <?php echo $countSendDeviceId; ?></div>
                    <div class="desc"> Daily views:</div>
                </div>
                <a class="more" href="javascript:;"> More details
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue-soft">
                <div class="visual">
                    <img
                        src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/vreo_icon_text_light.png"
                        alt="">
                </div>
                <div class="details">
                    <div class="number">
                        <?
                        $idFinishStavka = $wpdb->get_results("SELECT * FROM ps_price WHERE idDevPlace = $post_author AND postIdPlace = $numberPost  ORDER BY id");
                        $idFinishStavka = $idFinishStavka[count($idFinishStavka) - 1];
                        $idFinishStavka = $idFinishStavka->curIdPlace;

                        if ($idFinishStavka == $cur_user_id) {
                            $userInfoPartner = get_userdata($cur_user_id);
                            echo $cost_per_view;
                        }
                        else {
                        $userInfoPartner = get_userdata($cur_user_id);
                        if ($userInfoPartner->roles[0] == 'brand') {
                            $cost_per_view = round($cost_per_view * 1.33, 2);
                            echo $cost_per_view;
                        } else {
                            $cost_per_view = round($cost_per_view * 0.75, 2);
                            echo $cost_per_view;
                        }
                        }
                        ?>
                        <i class="fa fa-euro"></i></div>
                    <div class="desc"> Cost per view</div>
                </div>
                <a class="more" href="javascript:;"> Whats that
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat bg-yellow-crusta bg-font-yellow-crusta">
                <div class="visual">
                    <img src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/icon_bar-chart-o.png"
                         alt="">
                </div>
                <div class="details">
                    <div class="number">
                        <?
                        if ($idFinishStavka == $cur_user_id) {
                            $userInfoPartner = get_userdata($cur_user_id);
                            echo $budget_number_campaign;
                        } else {
                            $userInfoPartner = get_userdata($cur_user_id);
                            if ($userInfoPartner->roles[0] == 'brand') {
                                $budget_number_campaign = round($budget_number_campaign * 1.33, 2);
                                echo $budget_number_campaign;
                            } else {
                                $budget_number_campaign = round($budget_number_campaign * 0.75, 2);
                                echo $budget_number_campaign;
                            }
                        }
                        ?><i class="fa fa-euro"></i></div>
                    <div class="desc"> Budget</div>
                </div>
                <a class="more" href="javascript:;"> More details
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;margin-bottom: 30px; margin-left: 15px; margin-right: 15px;">
        <!-- BEGIN INTERACTIVE CHART PORTLET-->
        <div id="myfirstchart" style="height: 250px;"></div>
        <!-- END INTERACTIVE CHART PORTLET-->
        <script>
            new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data:<?php echo $chartJSON; ?>,
                // The name of the data record attribute that contains x-values.
                xkey: 'year',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['value'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Total time:']
            });
        </script>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Styles -->
            <style>
                #chartdiv {
                    width: 100%;
                    height: 500px;
                }
            </style>
            <!-- Chart code -->

            <script>
                var chart = AmCharts.makeChart( "chartdiv", {
                    "type": "serial",
                    "addClassNames": true,
                    "theme": "light",
                    "autoMargins": false,
                    "marginLeft": 30,
                    "marginRight": 8,
                    "marginTop": 10,
                    "marginBottom": 45,
                    "balloon": {
                        "adjustBorderColor": false,
                        "horizontalPadding": 10,
                        "verticalPadding": 8,
                        "color": "#ffffff"
                    },

                    "dataProvider": <?=$chartJsonNoData?>,
                    "startDuration": 1,
                    "graphs": [ {
                        "alphaField": "alpha",
                        "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                        "fillAlphas": 1,
                        "title": "Income",
                        "type": "column",
                        "valueField": "income",
                        "dashLengthField": "dashLengthColumn"
                    }, {
                        "id": "graph2",
                        "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                        "bullet": "round",
                        "lineThickness": 3,
                        "bulletSize": 7,
                        "bulletBorderAlpha": 1,
                        "bulletColor": "#FFFFFF",
                        "useLineColorForBulletBorder": true,
                        "bulletBorderThickness": 3,
                        "fillAlphas": 0,
                        "lineAlpha": 1,
                        "title": "Expenses",
                        "valueField": "expenses",
                        "dashLengthField": "dashLengthLine"
                    } ],
                    "categoryField": "year",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0,
                        "tickLength": 0
                    },
                    "export": {
                        "enabled": false
                    }
                } );
            </script>

            <!-- HTML -->
            <div id="chartdiv"></div>
        </div>

        <div class="col-md-6">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet">

                <div class="portlet-title bg-yellow-gold bg-font-yellow-gold">
                    <div class="caption" style="display: inline-block;">
                        <i class="fa fa-shopping-cart font-white"></i>
                        <span class="caption-subject font-white sbold uppercase">Payments</span>
                    </div>
                    <div class="actions" style="display: inline-block; float:right;">
                        <!--                                <button class="btn blue"><i class="fa fa-check"></i> Campaigns</button>-->
                        <!--                                <button class="btn green-jungle"><i class="fa fa-file-excel-o"></i> Export to .xls-->
                        <!--                                </button>-->
                        <!--                                <button class="btn yellow-gold"><i class="fa fa-repeat"></i> Reload</button>-->
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th>
                                    №
                                </th>
                                <th>
                                    <i class="fa fa-circle-o" aria-hidden="true"></i> Score
                                </th>
                                <th class="hidden-xs">
                                    <i class="fa fa-gamepad" aria-hidden="true"></i> Platform
                                </th>
                                <th>
                                    <i class="fa fa-money" aria-hidden="true"></i> Payments
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Time
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($res) {
                                $messageAdmin = '<table style="font-family: arial ;">';
                                $idKeyTotal = 0;
                                foreach ($res as $key => $r) {
                                    $total_percentage = $r->total_screen_percentage;
                                    $score = score($total_percentage, $cost_per_view);
                                    $platform = $r->platform;
                                    $platformsJS [] = $r->platform;

                                    $date = new DateTime($r->data);

                                    $idKeyTotal++;
                                    $scoreTotal += $score;

                                    $total_payments += $cost_per_view * $score;
                                    ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $score ?></td>
                                        <td><?= $platform ?></td>
                                        <td><?= round($cost_per_view * $score, 2) ?>$</td>
                                        <td><?= $date->format('d.m.Y') ?></td>
                                        <td><?= $date->format('H:i:s') ?></td>
                                    </tr>
                                    <?php
                                    $messageAdmin .= '                                
                                    <tr style="border: 1px solid black;">
                                    <td style="padding: 10px; font-weight: bold; font-size: 16px;">Score: </td>
                                    <td style="padding: 10px; font-size: 18px;">' . $score . '</td>
                                    </tr>
                                    <tr style="border: 1px solid black;">
                                    <td style="padding: 10px; font-weight: bold; font-size: 16px;">Platform: </td>
                                    <td style="padding: 10px; font-size: 18px;">' . $platform . '</td>
                                    </tr>
                                    <tr style="border: 1px solid black;">
                                    <td style="padding: 10px; font-weight: bold; font-size: 16px;">Payment: </td>
                                    <td style="padding: 10px; font-size: 18px;">' . round($cost_per_view * $score, 2) . '</td>
                                    </tr>
                                ';
                                }
                            }
                            if (!empty($res)) {
                                $platformsJS = array_count_values($platformsJS);
                                $platformJSON = array();
                                foreach ($platformsJS as $key => $value) {
                                    $platformJSON[] = [
                                        "label" => $key,
                                        "data" => $value
                                    ];
                                }
                                $platformJSON = json_encode($platformJSON);
                            }
                            ?>
                            <tr>
                                <td><b><?php echo $idKeyTotal; ?></b></td>
                                <td><b><?php echo $scoreTotal; ?></b></td>
                                <td style="text-align: right;"><b>Total:</b></td>
                                <td><?= round($total_payments, 2) ?>$</td>
                            </tr>
                            </tbody>
                        </table>
                        <?php
                        $messageAdmin .= '
                         <tr>
                            <td></td>
                            <td style="text-align: right;"><b>Total:</b></td>
                            <td>' . round($total_payments, 2) . '$</td>                            
                        </tr>
                        </table>
                        ';

                        $admin_email = get_option('admin_email');
                        $titleMailAdmin = 'Analytics Campaign Vreo.io';

                        $headers = 'From: Vreo.io <vreo@vreo.io>';
                        $headers .= 'content-type: text/html; charset=utf-8';
                        /*                 function add_month($time)
                                         {
                                             $d=date('j', $time);
                                             $m=date('n', $time);
                                             $y=date('Y', $time);

                                             $m++;
                                             if ($m>12) {
                                                 $y++;
                                                 $m=1;
                                             }


                                             if ($d==date('t', $time)) {
                                                 $d=31;
                                             }

                                             if (!checkdate($m, $d, $y)) {
                                                 $d=date('t', mktime(0, 0, 0, $m, 1, $y));
                                             }

                                             return mktime(0, 0, 0, $m, $d, $y);
                                         }
                                         $date=new DateTime();
                                         $date=$date->format('Y-m-d');
                                         $dataInformation = date('Y.m.d',add_month(strtotime($date)));
                                         $resultData = $wpdb->get_results("SELECT * FROM analytics_send WHERE id_user = $cur_user_id AND id_post = $numberPost");
                                         if ( $resultData ) {

                                         } else {
                                             $wpdb->insert(
                                             'analytics_send',
                                             array(
                                                 'id_user' => $cur_user_id,
                                                 'id_post' => $numberPost,
                                                 'data' => $dataInformation
                                             ),
                                             array('%s', '%s')
                                         );
                                          mail( $admin_email, $titleMailAdmin, $messageAdmin, $headers );
                                         }
                                         */

                        ?>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>

    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="portlet-title bg-purple-seance bg-font-purple-seance">
                <div class="caption" style="display: inline-block;">
                    <img
                        src="<?= get_template_directory_uri() ?>/assets/pages/img/profile/gamepad-controller.png"
                        height="30" style="margin: 10px;" alt="">
                    <span class="caption-subject font-white sbold uppercase">Platforms</span>
                </div>
                <div class="actions" style="display: inline-block; float:right;">
                    <!--                            <button class="btn green-jungle"><i class="fa fa-file-excel-o"></i> Export to .xls</button>-->
                    <!--                            <button class="btn yellow-gold"><i class="fa fa-repeat"></i> Reload</button>-->
                </div>
            </div>
            <div class="portlet-body" style="clear:both;">
                <div id="pie_chart" class="chart" style="width: 100%;height: 400px;"></div>
            </div>
        </div>
    </div>
    <script>
        var ChartsFlotcharts = function () {

            return {
                //main function to initiate the module

                init: function () {
                    App.addResizeHandler(function () {
//                    Charts.initPieCharts();
                    });
                },

                initCharts: function () {

                    if (!jQuery.plot) {
                        return;
                    }

                    var data = <?=$platformJSON?>;
                    var totalPoints = 250;

                    // random data generator for plot charts

                },
                initPieCharts: function () {

                    var data = <?=$platformJSON?>;


                    // DEFAULT
                    if ($('#pie_chart').size() !== 0) {
                        $.plot($("#pie_chart"), data, {
                            series: {
                                pie: {
                                    show: true
                                }
                            }
                        });
                    }

                    function pieHover(event, pos, obj) {
                        if (!obj)
                            return;
                        percent = parseFloat(obj.series.percent).toFixed(2);
                        $("#hover").html('<span style="font-weight: bold; color: ' + obj.series.color + '">' + obj.series.label + ' (' + percent + '%)</span>');
                    }

                    function pieClick(event, pos, obj) {
                        if (!obj)
                            return;
                        percent = parseFloat(obj.series.percent).toFixed(2);
                        alert('' + obj.series.label + ': ' + percent + '%');
                    }

                },

            };
        }();

        jQuery(document).ready(function () {
            ChartsFlotcharts.init();
            ChartsFlotcharts.initCharts();
            ChartsFlotcharts.initPieCharts();
        });
    </script>
    <?php else: ?>
    <h3>There are no campaigns with ad</h3>
<?php endif; ?>