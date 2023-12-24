<?php

include_once './vendor/autoload.php';

use Isemary\AnyServiceManager\OS\OperatingSystem;

$os = new OperatingSystem();

var_dump($os->getInfo());
