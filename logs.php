<?php

use Isemary\AnyServiceManager\Manager\Manager;
use Isemary\AnyServiceManager\OS\OperatingSystem;

require_once "./autoload.php";

$operatingSystem = new OperatingSystem();

$packages = (new Manager)->packages;

$package = (isset($_GET['package']) && !empty($_GET['package'])) ? $_GET['package'] : null;

$template = $twig->load('pages/logs.twig');
echo $template->render([
    'title' => 'Logs',
    'operating_system' => $operatingSystem->getInfo(),
    'packages' => $packages,
    'uri_package' => $package
]);
