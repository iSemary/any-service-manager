<?php

use Isemary\AnyServiceManager\OS\OperatingSystem;
use Isemary\AnyServiceManager\Packages\Redis;

require_once "./autoload.php";

$template = $twig->load('pages/index.twig');

$operatingSystem = new OperatingSystem();

$redis = (new Redis)->uninstall();
var_dump($redis);
die();
echo $template->render([
    'operating_system' => $operatingSystem->getInfo(),
    'redis' => $redis
]);
