<?php

use Isemary\AnyServiceManager\Manager\Manager;
use Isemary\AnyServiceManager\OS\OperatingSystem;

require_once "./autoload.php";

$operatingSystem = new OperatingSystem();
$systemPackages = (new Manager())->packages;

$packages = [];
foreach ($systemPackages as $systemPackage) {
    $packages[] = [
        'title' => $systemPackage,
        'icon' => 'assets/images/icons/' . strtolower($systemPackage) . '.png',
        'alt' =>  strtolower($systemPackage),
        'status' => 'Checking'
    ];
}

$template = $twig->load('pages/index.twig');
echo $template->render([
    'title' => "Home",
    'operating_system' => $operatingSystem->getInfo(['disk', 'network']),
    'packages' => $packages
]);
