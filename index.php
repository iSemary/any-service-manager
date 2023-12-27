<?php


use Isemary\AnyServiceManager\OS\OperatingSystem;

require_once "./autoload.php";

$operatingSystem = new OperatingSystem();

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

$template = $twig->load('pages/index.twig');
echo $template->render([
    'operating_system' => $operatingSystem->getInfo(),
    'packages' => $packages
]);
