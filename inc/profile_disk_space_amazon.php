<?php
require '../vendor/autoload.php';
$config = require 'config.php';
$rolePath = $_POST['rolePath'];
    $Path = $rolePath;
    use Aws\S3\S3Client;

if(isset($rolePath)){
    // Instantiate the client.
    $s3 = S3Client::factory([
        'key' => $config['s3']['key'],
        'secret' => $config['s3']['secret'],
        'region' => 'eu-central-1'
    ]);
    $profile_use_disk_space = 0;
    $objects = $s3->getIterator('ListObjects', array(
        'Bucket' => $config['s3']['bucket'],
        'Prefix' => $Path
    ));
    foreach ($objects as $object) {
        $profile_use_disk_space += $object['Size'];
    }
    echo $profile_use_disk_space;

}else {
    echo -1;
}
