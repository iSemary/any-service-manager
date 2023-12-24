<?php

namespace Isemary\AnyServiceManager\OS;

class OperatingSystem {
    public function getInfo(): array {
        $data['name'] = php_uname('s');
        $data['host'] = php_uname('n');
        $data['release'] = php_uname('r');
        $data['machine'] = php_uname('m');
        return $data;
    }
}
