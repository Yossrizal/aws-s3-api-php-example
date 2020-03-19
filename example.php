<?php 

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

include "../inc/func.php";

date_default_timezone_set('Asia/Jakarta');

$bucket = 'TEST123.BUCKETNAME.ORG';
$credentials = new Aws\Credentials\Credentials('TEST123', 'TEST123');

// Instantiate the client.
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-southeast-1',
    'credentials' => $credentials,
    ]);

// get specific folder in one bucket
$prefix = array(
    'folder/',
    'beta/',
    );

// Use the plain API (returns ONLY up to 1000 of your objects).
$objects = [];
for ($i=0; $i < count($prefix); $i++) { 
    try {

        // base get object
        // $objects[$i] = $s3->listObjects([
        //     'Bucket' => $bucket,
        //     // 'Prefix'=> $prefix[$i]
        //     // 'Delimiter' => '',
        //     // 'KeyMarker' => '',
        //     'MaxKeys' => 10
        //     ]);

        // iterator example
        // $objects[$i] = $s3->getIterator('ListObjects', array(
        //     'Bucket' => $bucket
        //     ), array(
        //     'limit'     => 999,
        //     'page_size' => 1
        //     ));

        // foreach ($iterator as $object) {
        //     echo $object['Key'] . "\n";
        // }


        // use iterator for loop all object more than 1000
        $iterator = $s3->getIterator('ListObjects', 
            array(
                'Bucket' => $bucket
                )
            );
        $z = 0;
        foreach ($iterator as $object) {
            $objects[$z] = $object;
            $z++;
        }

    } catch (S3Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
}

$response = $objects;

?>
