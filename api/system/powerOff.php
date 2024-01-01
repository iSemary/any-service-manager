<?php
require_once "../../autoload.php";

use Isemary\AnyServiceManager\OS\OperatingSystem;

$powerOff = (new OperatingSystem())->powerOff();
