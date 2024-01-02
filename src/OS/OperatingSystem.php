<?php

namespace Isemary\AnyServiceManager\OS;

use Isemary\AnyServiceManager\Commands\Linux;

class OperatingSystem {
    private string $password;
    public function __construct() {
        $this->password = $_ENV['ROOT_PASSWORD'];
    }

    public function getInfo(array $extraFields = []): array {
        $data['name'] = php_uname('s');
        $data['host'] = php_uname('n');
        $data['release'] = php_uname('r');
        $data['machine'] = php_uname('m');

        if (in_array("disk", $extraFields)) $data['disk'] = $this->getDisk();
        if (in_array("network", $extraFields)) $data['network'] = $this->getNetwork();
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

    public function powerOff(): bool {
        $command = sprintf("echo '%s' | sudo -S %s", $this->password, Linux::POWER_OFF);
        exec($command, $output, $returnVar);
        if ($returnVar === 0) {
            return true;
        } else {
            return false;
        }
    }

    public function restart(): bool {
        $command = sprintf("echo '%s' | sudo -S %s", $this->password, Linux::RESTART);
        exec($command, $output, $returnVar);
        if ($returnVar === 0) {
            return true;
        } else {
            return false;
        }
    }
}
