<?php
//-------------------------
$role = '';
if (in_array('developer', $user_info->roles)) $role = 'developer';
if ($role == "developer"){
global $wpdb;
$wpdb->update( 'activities',
    array( 'status' => 1),
    array( 'id_user' => $cur_user_id )
);
for ($day = 0;$day <= 7;$day++){
    $date_current = new \DateTime();
    $dateDay = $date_current->modify("-$day day");
    $dateDayDbStart = $dateDay->format("Ymd") . '000000';
    $dateDayDbEnd = $dateDay->format("Ymd") . '235959';
    $activitic_users_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'followUser' AND id_user = '$cur_user_id' AND (data>=$dateDayDbStart and  data<$dateDayDbEnd)");
    $activitic_signed_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'signedUser' AND id_user = '$cur_user_id' AND (data>=$dateDayDbStart and  data<$dateDayDbEnd)");
    $activitic_message_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'messages' AND id_user = '$cur_user_id' AND (data>=$dateDayDbStart and  data<$dateDayDbEnd)");

$step_message_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepMessages' AND id_user = '$cur_user_id' AND (data>=$dateDayDbStart and  data<$dateDayDbEnd)");
$step_price_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepPrice' AND id_user = '$cur_user_id' AND (data>=$dateDayDbStart and  data<$dateDayDbEnd)");
$step_approve_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'stepApprove' AND id_user = '$cur_user_id' AND (data>=$dateDayDbStart and  data<$dateDayDbEnd)");

    $activitic_profile_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'profileAccount' AND id_user = '$cur_user_id' AND (data>=$dateDayDbStart and  data<$dateDayDbEnd)");
    $activitic_admin_db = $wpdb->get_results( "SELECT * FROM activities WHERE type_notifications = 'adminMessageAll' AND id_user = '$cur_user_id' AND (data>=$dateDayDbStart and  data<$dateDayDbEnd)");
    $all_result=array_merge($activitic_message_db,$activitic_signed_db,$activitic_users_db,$activitic_profile_db,$activitic_admin_db,$step_message_db,$step_price_db,$step_approve_db);

if (!function_exists('dbSort')) {
    function dbSort($f1,$f2)
    {
        if($f1->data < $f2->data) return -1;
        elseif($f1->data > $f2->data) return 1;
        else return 0;
    }
}
uasort($all_result,"dbSort");
?>
<? if(!empty($all_result)){?>
<div class="portlet light">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <i class="icon-globe font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase"><? if ($day == 0) {
                    echo "Today, " . $dateDay->format("d/m/Y");
                } elseif ($day == 1) {
                    echo "Yesterday, " . $dateDay->format("d/m/Y");
                } else {
                    echo $dateDay->format("l, d/m/Y");
                } ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <!--BEGIN TABS-->
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1_1">
                <div class="scroller" style="" data-always-visible="1" data-rail-visible="0">
                    <ul class="feeds">
                        <?php foreach(array_reverse($all_result) as $key): ?>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <?if($key->type_notifications=='adminMessageAll'){?>
                                            <div class="label label-sm bg-blue">
                                                <span class="dashboard-icons-vreo-white"></span>
                                            </div>
                                            <?}elseif($key->type_notifications=='profileAccount'){?>
                                                <div class="label label-sm bg-yellow-gold">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            <?} elseif($key->type_notifications=='followUser'){?>
                                                <div class="label label-sm bg-grey-mint">
                                                    <i class="fa fa-user-plus"></i>
                                                </div>
                                            <?} elseif($key->type_notifications=='signedUser'){?>
                                                <div class="label label-sm bg-red-mint">
                                                    <i class="fa fa-user-times"></i>
                                                </div>
                                            <?} elseif($key->type_notifications=='messages'){?>
                                                <div class="label label-sm bg-yellow-gold">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                            <?} elseif($key->type_notifications=='stepMessages'){?>
                                                <div class="label label-sm bg-yellow-gold">
                                                    <<i class="fa fa-envelope"></i>
                                                </div>
                                            <?} elseif($key->type_notifications=='stepPrice'){?>
                                                <div class="label label-sm bg-red-mint">
                                                    <i class="fa fa-money"></i>
                                                </div>
                                            <?} elseif($key->type_notifications=='stepApprove'){?>
                                                <div class="label label-sm bg-yellow-gold">
                                                    <i class="fa fa-flag-checkered"></i>
                                                </div>
                                            <?} else {?>
                                                <div class="label label-sm label-success">
                                                    <span class="dashboard-icons-marketplace-white"></span>
                                                </div>
                                            <?}?>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"><?=$key->message;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2 time-col">
                                    <div class="date">
                                        <?php
                                        if ($day == 0){
                                        ?>
                                        <time class="timeago" datetime="<?= $key->data ?>">
                                            <?php } else {
                                                $data = new \DateTime($key->data);
                                                echo $data->format('h:i:s');
                                            } ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach;?>

                    </ul>
                </div>
            </div>
        </div>
        <!--END TABS-->
    </div>
</div><!--Portlet Light--><?}?>
<? } ?><!--for($day=1; $day<=7;$day++)-->
<? } ?><!-- End 'if($role=="developer")'-->

