<?php
require_once(dirname(__FILE__) . '/../../../../../../wp-load.php');

global $wpdb;

$id = $_POST['id'];

$res = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_game_id={$id}");
$postList = query_posts(array('p' => $id, 'post_status' => array('publish,completed')));

foreach ($postList as $key) {
    $imgHeader = $key->campaign_bg_header_file;
    $cost_per_view = $key->cost_campaign;
    $budget_number_campaign = $key->budget_number_campaign;
    $id = $key->ID;
    $res = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_game_id={$id}");
    $total_percentage = 0;
    $platform;
    $total_payments=0;

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
?>
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
    <style>
        table {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
            font-size: 14px;
            background: white;
            max-width: 70%;
            width: 20%;
            border-collapse: collapse;
            text-align: left;
        }
        th {
            font-weight: normal;
            color: #039;
            border-bottom: 2px solid #6678b1;
            padding: 10px 8px;
        }
        td {
            color: #669;
            padding: 9px 8px;
            transition: .3s linear;
        }
        tr:hover td {color: #6699ff;}
    </style>
    <div class="portlet-body">
        <div class="table-scrollable">
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                <tr>
                    <th>
                        <i class="fa fa-circle-o" aria-hidden="true"></i> Score
                    </th>
                    <th>
                        <i class="fa fa-gamepad" aria-hidden="true"></i> Platform
                    </th>
                    <th>
                        <i class="fa fa-money" aria-hidden="true"></i> Payments
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($res){
                    foreach ($res as $r) {
                        $total_percentage = $r->total_screen_percentage;
                        $score = score($total_percentage, $cost_per_view);
                        $platform = $r->platform;
                        $platformsJS .= $r->platform.",";
                        $total_payments+=$cost_per_view * $score;
                        ?>
                        <tr>
                            <td><?= $score ?></td>
                            <td><?= $platform ?></td>
                            <td><?= round($cost_per_view * $score, 2) ?>$</td>
                        </tr>
                    <? }
                } ?>
                <tr>
                    <td></td>
                    <td style="text-align: right;"><b>Total:</b></td>
                    <td><?= round($total_payments, 2)?>$</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
