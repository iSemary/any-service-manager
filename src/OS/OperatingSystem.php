<?php

namespace Isemary\AnyServiceManager\OS;

use Isemary\AnyServiceManager\Commands\Linux;

class OperatingSystem {
    private string $password;
    public function __construct() {
        $this->password = $_ENV['ROOT_PASSWORD'];
    }

    /**
     * The function `getInfo` returns an array containing information about the PHP environment, such as
     * the system name, host name, release version, and machine type, with the option to include additional
     * information about disk and network.
     * 
     * @param array extraFields The `extraFields` parameter is an optional array that allows you to specify
     * additional information that you want to retrieve. It accepts values such as "disk" and "network" to
     * indicate the specific information you want to include in the returned data array.
     * 
     * @return array an array containing information about the system. The array includes the following
     * keys: 'name', 'host', 'release', and 'machine'. If the 'disk' key is included in the 
     * array, the 'disk' key will also be included in the returned array with the value obtained from the
     * getDisk() method. Similarly, if the 'network' key is
     */
    public function getInfo(array $extraFields = []): array {
        $data['name'] = php_uname('s');
        $data['host'] = php_uname('n');
        $data['release'] = php_uname('r');
        $data['machine'] = php_uname('m');
        $data['internet_connection'] = $this->checkInternetConnection();

        if (in_array("disk", $extraFields)) $data['disk'] = $this->getDisk();
        if (in_array("network", $extraFields)) $data['network'] = $this->getNetwork();
        return $data;
    }

    /**
     * The function "getDisk" returns an array containing the total and free disk space on the root
     * directory.
     * 
     * @return array An array containing the total disk space and free disk space.
     */
    private function getDisk(): array {
        $data['total_space'] = disk_total_space('/');
        $data['free_space'] = disk_free_space('/');
        return $data;
    }

    /**
     * The function `getNetwork()` retrieves the local and public IP addresses of the server.
     * 
     * @return array an array with 3 keys: 'local IP', 'public IP' and 'internet connection'. The value of 'local' is the local IP
     * address of the server, and the value of 'public' is the public IP address of the server.
     */
    private function getNetwork(): array {
        $ipAddress = exec('hostname -I');
        $ipAddress = explode(" ", $ipAddress);
        $localIP = $ipAddress[0];

        $data = [
            'local' => $localIP,
            'public' => $this->getPublicIP(),
        ];
        return $data;
    }

    /**
     * The function executes a command to power off a Linux system using sudo and returns true if the
     * command is successful, otherwise it returns false.
     * 
     * @return bool a boolean value. If the command to power off the system is executed successfully
     * (returnVar === 0), then it returns true. Otherwise, it returns false.
     */
    public function powerOff(): bool {
        $command = sprintf("echo '%s' | sudo -S %s", $this->password, Linux::POWER_OFF);
        exec($command, $output, $returnVar);
        if ($returnVar === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The function restarts the Linux system by executing a restart command with sudo privileges.
     * 
     * @return bool a boolean value. If the returnVar is equal to 0, it will return true. Otherwise, it
     * will return false.
     */
    public function restart(): bool {
        $command = sprintf("echo '%s' | sudo -S %s", $this->password, Linux::RESTART);
        exec($command, $output, $returnVar);
        if ($returnVar === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The function checks if there is an internet connection by attempting to open a socket connection to
     * www.google.com.
     * 
     * @return bool a boolean value. It returns true if there is an internet connection and false if there
     * is no internet connection.
     */
    public function checkInternetConnection(): bool {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        }
        return false;
    }

    /**
     * The function "getPublicIP" returns the public IP address of the server if there is an internet
     * connection, otherwise it returns "-".
     * 
     * @return string a string value. If there is an internet connection, it will return the public IP
     * address obtained from the "http://ipecho.net/plain" URL. If there is no internet connection, it will
     * return a dash ("-").
     */
    private function getPublicIP(): string {
        if ($this->checkInternetConnection()) {
            return file_get_contents("http://ipecho.net/plain");
        }
        return "-";
    }
}
