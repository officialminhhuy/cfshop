<?php
require(__DIR__ . '/../vendor/autoload.php');

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

$factory = (new Factory())

    // ->withProjectId('verify-shop')
    ->withServiceAccount('verify-shop-firebase-adminsdk-10zet-df75afb236.json')
    ->withDatabaseUri('https://verify-shop-default-rtdb.firebaseio.com/');
$database = $factory->createDatabase();
$auth = $factory->createAuth();
$uid = 'some-uid';
