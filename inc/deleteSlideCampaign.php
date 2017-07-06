<?php
require_once(dirname(__FILE__) . '/../../../../wp-load.php');
// start Amazon
require '../vendor/autoload.php';
$config = require '../inc/config.php';
use Aws\S3\S3Client;


// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);
// end Amazon
$key=$_GET['Key'];
$idPost=$_GET['idPost'];
//echo $idPost."<br>";
//echo $key."<br>";
if(!empty($key)) {
    $result = $s3->deleteObject(array(
        // Bucket is required
        'Bucket' => $config['s3']['bucket'],
        // Key is required
        'Key' => $key
    ));

        $slides=get_post_meta($idPost, "campaignSlider");
    
        if(($k = array_search($key,$slides[0])) !== FALSE){
            unset($slides[0][$k]);
            update_post_meta($idPost,'campaignSlider',$slides[0]);
        }


    if($s3->doesObjectExist($config['s3']['bucket'],$key)){
        echo false;
    }else{
        echo true;
    }

}