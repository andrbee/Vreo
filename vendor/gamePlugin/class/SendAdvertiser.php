<?php
require_once(dirname(__FILE__) . '/../../../../../../wp-load.php');
require_once __DIR__ . '/Advertiser.php';

class SendAdvertiser extends Advertiser
{

    private function sendDbResult($arrayResult)
    {
        global $wpdb;
        $device_id = $arrayResult['device_id'];
        $developer_id = $arrayResult['developer_id'];
        $developer_game_id = $arrayResult['developer_game_id'];
        $total_screen_percentage = $arrayResult['total_screen_percentage'];
        $date24Cur = new DateTime();

        $valid = $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE device_id = '$device_id' AND developer_id = $developer_id AND developer_game_id = $developer_game_id");
        $count=count($valid);
        $date24 = new DateTime($valid[$count-1]->date24);
//        echo "<pre>";
//        print_r($valid);
//
//        echo $date24->format('Y-m-d H:i:s') . " База <br>";

        $date24->modify('+1 day');

//        echo $date24->format('Y-m-d H:i:s') . " База +1 день <br>";
//        echo $date24Cur->format('Y-m-d H:i:s') . " Текущее <br>";
//
//        var_dump($date24Cur < $date24);


        if ($valid && $date24Cur < $date24) {
            $old_percentage = $valid[$count-1]->total_screen_percentage;

            if ($old_percentage < $total_screen_percentage) {
                $newPercentage = $total_screen_percentage;
                $wpdb->update(
                    'pl_send_advertiser_ad_view_data',
                    array(
                        "developer_id" => $developer_id,
                        "developer_access_token" => $arrayResult['developer_access_token'],
                        "developer_game_id" => $developer_game_id,
                        "has_send_data_before_for_game" => $arrayResult['has_send_data_before_for_game'],
                        "has_send_data_before_for_ad" => $arrayResult['has_send_data_before_for_ad'],
                        "advertiser_ad_id" => $arrayResult['advertiser_ad_id'],
                        "advertiser_ad_is_visual" => $arrayResult['advertiser_ad_is_visual'],
                        "advertiser_ad_is_aural" => $arrayResult['advertiser_ad_is_aural'],
                        "total_hit_time" => $arrayResult['total_hit_time'],
                        "total_screen_percentage" => $newPercentage,
                        "total_screen_position_x" => $arrayResult['total_screen_position_x'],
                        "total_screen_position_y" => $arrayResult['total_screen_position_y'],
                        "total_blocked_percentage" => $arrayResult['total_blocked_percentage'],
                        "total_volume_percentage" => $arrayResult['total_volume_percentage'],
                        "platform" => $arrayResult['platform'],
                        "with_vr" => $arrayResult['with_vr'],
                        "data" => date("Y-m-d H:i:s"),
                        "device_id" => $device_id
                    ),
                    array(
                        'developer_access_token' => $arrayResult['developer_access_token'],
                        "device_id" => $device_id,
                        "date24"=>$valid[$count-1]->date24,
                        "developer_id" => $developer_id,
                        "developer_game_id" => $developer_game_id
                    ),
                    array('%s', '%s')
                );
            }

        } else {
            $wpdb->insert(
                'pl_send_advertiser_ad_view_data',
                array(
                    "developer_id" => $developer_id,
                    "developer_access_token" => $arrayResult['developer_access_token'],
                    "developer_game_id" => $developer_game_id,
                    "has_send_data_before_for_game" => $arrayResult['has_send_data_before_for_game'],
                    "has_send_data_before_for_ad" => $arrayResult['has_send_data_before_for_ad'],
                    "advertiser_ad_id" => $arrayResult['advertiser_ad_id'],
                    "advertiser_ad_is_visual" => $arrayResult['advertiser_ad_is_visual'],
                    "advertiser_ad_is_aural" => $arrayResult['advertiser_ad_is_aural'],
                    "total_hit_time" => $arrayResult['total_hit_time'],
                    "total_screen_percentage" => $arrayResult['total_screen_percentage'],
                    "total_screen_position_x" => $arrayResult['total_screen_position_x'],
                    "total_screen_position_y" => $arrayResult['total_screen_position_y'],
                    "total_blocked_percentage" => $arrayResult['total_blocked_percentage'],
                    "total_volume_percentage" => $arrayResult['total_volume_percentage'],
                    "platform" => $arrayResult['platform'],
                    "with_vr" => $arrayResult['with_vr'],
                    "data" => date("Y-m-d H:i:s"),
                    "device_id" => $device_id,
                    "date24" => date("Y-m-d H:i:s")
                ),
                array('%s', '%s')
            );
        }
    }

    public function sendResult()
    {
        $this->sendDbResult($this->receiveJson());
    }
}

