<?php
require_once __DIR__ . "/../../autoload.php";

use Isemary\AnyServiceManager\OS\OperatingSystem;

$restart = (new OperatingSystem())->restart();
