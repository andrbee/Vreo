<?php
require_once(dirname(__FILE__) . '/../../../../../../wp-load.php');
require_once __DIR__ . '/Advertiser.php';


class GetAdvertiser extends Advertiser
{
    
    private function returnResult($advertiserId, $typeId, $mediaUrl, $error)
    {
        header('Content-Type:application/json;charset=utf-8');
        if ( $error == true ) {
            return json_encode(array("success" => "true",
                                     "result" => array(
                                         "advertiser_ad_id" => $advertiserId,
                                         "type_media_id" => $typeId,
                                         "media_url" => $mediaUrl
                                     )
                )
            );
        } else {
            return json_encode(array("success" => "true"));
        }
    }
    private function getDbPost($postId)
    {
        return query_posts(array('p' => $postId, 'post_status' => array('publish,completed')));
    }

    private function getSendDbReuslt($postId)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM pl_send_advertiser_ad_view_data WHERE developer_game_id={$postId}");
    }

    private function getDbResult($devId, $gameId, $typeId, $tokenId)
    {
        global $wpdb;
       return $wpdb->get_results( "SELECT * FROM pl_get_random_advertiser WHERE developer_id = $devId AND developer_access_token = '$tokenId' AND developer_game_id = $gameId");

    }


    public function getResult()
    {
        $resultJson  = $this->receiveJson();
        $developer_id = $resultJson['developer_id'];
        $developer_game_id = $resultJson['developer_game_id'];
        $type_media_id = $resultJson['type_media_format_ids'];
        $developer_token = $resultJson['developer_access_token'];

        $findeRes = $this->getDbResult($developer_id, $developer_game_id, $type_media_id, $developer_token);
       
        if ( !$findeRes ) {
            return $this->returnResult(null, null, null, false);
        } else {
            $result  = $this->getSendDbReuslt($developer_game_id);
            $postList = $this->getDbPost($developer_game_id);
            foreach ($postList as $key) {
                $costPerView = $key->cost_campaign;
                $budgetNumberCampaign = $key->budget_number_campaign;
                $placeholderPlugin = $key->placeholder_plugin;
            }
            foreach ($result as $value) {
                $totalPercentage = $value->total_screen_percentage;
                $score = $this->score($totalPercentage, $costPerView);
                $totalPayments += $costPerView * $score;
            }
            if (round($totalPercentage, 0, PHP_ROUND_HALF_UP) >= $budgetNumberCampaign) {
                return $this->returnResult($findeRes[0]->advertiser_ad_id, 1, $placeholderPlugin, true);
            } else {
                return $this->returnResult($findeRes[0]->advertiser_ad_id, (int)$findeRes[0]->type_media_id, $findeRes[0]->media_url, true);
            }

        }
    }
}