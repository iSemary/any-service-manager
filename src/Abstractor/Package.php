<?php

namespace Isemary\AnyServiceManager\Abstractor;

abstract class Package {
    abstract public function exists();
    abstract public function install();
    abstract public function uninstall();
    abstract public function directory();
    abstract public function purge();
    abstract public function execute($command);
}
