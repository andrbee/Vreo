<?php
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
$key=$_POST['Key'];
if(!empty($key)) {
    $result = $s3->deleteObject(array(
        // Bucket is required
        'Bucket' => $config['s3']['bucket'],
        // Key is required
        'Key' => $key
    ));

    if($s3->doesObjectExist($config['s3']['bucket'],$key)){
        echo false;
    }else{
        echo true;
    }

}