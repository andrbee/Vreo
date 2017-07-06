<?php
$url = explode("?",$_SERVER['HTTP_REFERER']);

require_once( dirname(__FILE__) . '/../../../../wp-load.php' );
// start Amazon
require '../vendor/autoload.php';
$config = require '../inc/config.php';
use Aws\S3\S3Client;
global $wpdb;


// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);
// end Amazon
if( !is_user_logged_in() ) exit;

$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$user_ID = get_current_user_id();
$user = get_user_by( 'id', $user_ID );

if(isset($_POST['delete'])){
    $postid = $_POST['delete'];
    $force_delete = true;
    wp_delete_post( $postid,$force_delete );
    header('location: /edit-campaign/');
}
switch ($_POST['list-button']) {
  case 'completed':
    if(isset($_POST['postID'])){
        $postid = $_POST['postID'];
        $post_data = array(
            'ID'            => $postid,
            'post_status'   => 'completed',
            'post_type'     => 'post'
        );
        wp_update_post( $post_data );
        header('location: /edit-campaign/');
    }

    break;
  case 'delete':
    if(isset($_POST['postID'])){
        $postid = $_POST['postID'];
        $force_delete = true;
        $filesKey[]=get_post_meta( $postid, 'campaign_video_key', true );
        $filesKey[]=get_post_meta( $postid, 'campaign_bg_file', true );
        $filesKey[]=get_post_meta( $postid, 'campaign_image_file', true );
        $filesKey[]=get_post_meta( $postid, 'campaign_age_file', true );
        $filesKey[]=get_post_meta( $postid, 'campaign_bg_header_file', true );
//        echo "<script>console.log('".print_r(get_post_meta( $postid, 'campaignSlider' ))."');";
        foreach (get_post_meta( $postid, 'campaignSlider' )[0] as $slide) {
            $filesKey[]=$slide;
        }
        $delePost=wp_delete_post( $postid,$force_delete );
        if($delePost!==false){
            foreach ($filesKey as $value){
                if(!empty($value))
                $result = $s3->deleteObject(array(
                    // Bucket is required
                    'Bucket' => $config['s3']['bucket'],
                    // Key is required
                    'Key' => $value
                ));
            }
            $where=array('id_campaign'=>$postid);
            $wpdb->delete( 'place_step_f', $where, $where_format = null );
        }
        header('location: /edit-campaign/');
    }
    break;
  case 'uncompleted':
    if(isset($_POST['postID'])){
        $postid = $_POST['postID'];
        $post_data = array(
            'ID'            => $postid,
            'post_status'   => 'publish',
            'post_type'     => 'post'
        );
        wp_update_post( $post_data );
        header('location: /edit-campaign/');
    }
    break;
    case 'publish':
        if(isset($_POST['postID'])){
            $postid = $_POST['postID'];
            $post_data = array(
                'ID'            => $postid,
                'post_status'   => 'publish',
                'post_type'     => 'post'
            );
            wp_update_post( $post_data );
            header('location: /edit-campaign/');
        }
        break;

  default:
    # code...
    break;
}
