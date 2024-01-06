<?php

require_once "./autoload.php";

use Isemary\AnyServiceManager\Configuration\Ini\FileManager;
use Isemary\AnyServiceManager\OS\OperatingSystem;

$operatingSystem = new OperatingSystem();

$iniFiles = (new FileManager)->getAvailableFiles();

$template = $twig->load('pages/php-configuration.twig');
echo $template->render([
    'title' => 'PHP Configuration',
    'operating_system' => $operatingSystem->getInfo(),
    'ini_files' => $iniFiles
]);
