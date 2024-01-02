<?php

require_once "./autoload.php";

use Isemary\AnyServiceManager\Manager\Manager;
use Isemary\AnyServiceManager\OS\OperatingSystem;

$operatingSystem = new OperatingSystem();
$packagesStatus = (new Manager)->checkPackagesStatus();

$package = (isset($_GET['package']) && !empty($_GET['package'])) ? $_GET['package'] : null;

$template = $twig->load('pages/package-manager.twig');
echo $template->render([
    'title' => 'Package Manager',
    'operating_system' => $operatingSystem->getInfo(),
    'packages' => $packagesStatus,
    'uri_package' => $package
]);
