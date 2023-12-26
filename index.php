<?php

use Isemary\AnyServiceManager\Manager\Manager;
use Isemary\AnyServiceManager\OS\OperatingSystem;
use Isemary\AnyServiceManager\Packages\Redis;

require_once "./autoload.php";

$template = $twig->load('pages/index.twig');

$operatingSystem = new OperatingSystem();


$manager = (new Manager)->checkPackagesStatus();

die(var_dump($manager));
// $redis = (new Redis)->uninstall();
// var_dump($redis);
// die();
$packages = [
    [
        'title' => 'Redis',
        'icon' => 'assets/images/icons/redis.png',
        'alt' => 'redis',
        'status' => 'Checking',
    ],
    [
        'title' => 'NPM',
        'icon' => 'assets/images/icons/npm.png',
        'alt' => 'npm',
        'status' => 'Checking',
    ],
    [
        'title' => 'Elasticsearch',
        'icon' => 'assets/images/icons/elasticsearch.png',
        'alt' => 'elasticsearch',
        'status' => 'Checking',
    ],
    [
        'title' => 'MySQL',
        'icon' => 'assets/images/icons/mysql.png',
        'alt' => 'mysql',
        'status' => 'Checking',
    ],
];

echo $template->render([
    'operating_system' => $operatingSystem->getInfo(),
    'packages' => $packages
]);
