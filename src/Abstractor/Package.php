<?php

namespace Isemary\AnyServiceManager\Abstractor;

use Isemary\AnyServiceManager\Traits\CommandExecutorTrait;

abstract class Package {
    use CommandExecutorTrait;
    abstract public function exists();
    abstract public function version();
    abstract public function install();
    abstract public function uninstall();
    abstract public function directory();
    abstract public function purge();
}
