<?php

global $wpdb;

require_once( dirname(__FILE__) . '/../../../../../wp-load.php' );

$idDevPlace = filter_input(INPUT_POST, 'idDevPlace', FILTER_SANITIZE_NUMBER_INT);
$postIdPlace = filter_input(INPUT_POST, 'postIdPlace', FILTER_SANITIZE_NUMBER_INT);
$cur_user_id = get_current_user_id();

$result = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_dev = $idDevPlace AND id_brand = $cur_user_id AND id_campaign = $postIdPlace");

$timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone'])*60, 0);
$date=new DateTime("",new DateTimeZone($timezone));
$date=$date->format('Y-m-d H:i:s');

if ( $result ) {
    //Пока нету выбора позиции для рекламы
    header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
} else {
    // Позиция пока не приходят из-за того что в плагине не работает выбор позиций
    $wpdb->insert(
        'place_step_f',
        array(
            'id_dev' => $idDevPlace,
            'id_brand' => $cur_user_id,
            'id_campaign' => $postIdPlace,
            'positon' => ''
        ),
        array('%s', '%s')
    );
    $resultPost = get_post($postIdPlace);
        $wpdb->insert(
            'ps_price',
            array(
                'cpv' => $resultPost->cost_campaign,
                'bp' => $resultPost->budget_number_campaign,
                'postIdPlace' => $postIdPlace,
                'idDevPlace' => $idDevPlace,
                'curIdPlace' => $idDevPlace,
                'statusPrice' => 0
            ),
            array('%s', '%f')
        );
    $infoName = get_userdata($cur_user_id);
    $wpdb->insert(
        'activities',
        array(
            'id_user' => $idDevPlace,
            'type_notifications' => 'stepPrice',
            'message' => "<a href=\"/place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}\">{$infoName->user_nicename}</a> wants to place an ad in your campaign",
            'status' => 0,
            'data' => $date,
            'categories' => '',
            'hash_tag' => ''
        ),
        array('%s', '%s')
    );
    $post_data = array(
        'ID' => $postIdPlace,
        'post_status' => 'completed',
        'post_type' => 'post'
    );
    wp_update_post($post_data);
    header("location: /place-step-second/?idDev={$idDevPlace}&pageId={$postIdPlace}");
}



