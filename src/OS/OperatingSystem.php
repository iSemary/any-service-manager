<?php

namespace Isemary\AnyServiceManager\OS;

class OperatingSystem {
    public function getInfo(): array {
        $data['name'] = php_uname('s');
        $data['host'] = php_uname('n');
        $data['release'] = php_uname('r');
        $data['machine'] = php_uname('m');

        $data['disk'] = $this->getDisk();
        $data['network'] = $this->getNetwork();
        return $data;
    }

    private function getDisk(): array {
        $data['total_space'] = disk_total_space('/');
        $data['free_space'] = disk_free_space('/');
        return $data;
    }

    private function getNetwork(): array {
        $ipAddress = exec('hostname -I');
        $ipAddress = explode(" ", $ipAddress);
        $localIP = $ipAddress[0];

        $publicIP = file_get_contents("http://ipecho.net/plain");

        $data = [
            'local' => $localIP,
            'public' => $publicIP
        ];
        return $data;
    }
}
