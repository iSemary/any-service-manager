<?php
require_once "../../autoload.php";

use Isemary\AnyServiceManager\OS\OperatingSystem;

$restart = (new OperatingSystem())->restart();
