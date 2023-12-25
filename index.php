<?php

use Isemary\AnyServiceManager\OS\OperatingSystem;

require_once "./autoload.php";

$template = $twig->load('pages/index.twig');

$operatingSystem = new OperatingSystem();

echo $template->render([
    'operating_system' => $operatingSystem->getInfo()
]);
