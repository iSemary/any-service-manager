<?php

namespace Isemary\AnyServiceManager\Packages;

use Exception;
use Isemary\AnyServiceManager\Abstractor\Package;
use Isemary\AnyServiceManager\Commands\Linux;
use Isemary\AnyServiceManager\Interfaces\PackageStatus;

class Elasticsearch extends Package implements Linux {
    private $packageName;
    private $password;

    public function __construct() {
        $this->packageName = "elasticsearch";
        $this->password = $_ENV['ROOT_PASSWORD'];
    }

    public function exists() {
        $check = Linux::SYSTEMCTL_STATUS . " " . $this->packageName;
        $output = $this->execute($check);
        // Package not found
        if (!$output) {
            return PackageStatus::UNINSTALLED;
        }
        // check if 'Active: active' exists in the output
        return (strpos($output, 'Active: active') !== false) ? PackageStatus::ACTIVE : PackageStatus::INACTIVE;
    }
    public function install() {
        $command = sprintf("echo '%s' | sudo -S %s $this->packageName -y", $this->password, Linux::INSTALL_COMMAND);

        $output = $this->execute($command);
        // Command execution failed
        if ($output === null) {
            return false;
        }

        // Check if the package exists or service exists
        $checkCommand = sprintf("which %s", escapeshellarg($this->packageName));
        $checkOutput = $this->execute($checkCommand);

        // If the package package exists or service exists
        return $checkOutput === null;
    }
    public function uninstall() {
        $command = sprintf("echo '%s' | sudo -S %s $this->packageName -y", $this->password, Linux::UNINSTALL_COMMAND);

        $output = $this->execute($command);
        // Command execution failed
        if ($output === null) {
            return false;
        }

        // Check if the package executable or service doesn't exist anymore
        $checkCommand = sprintf("which %s", escapeshellarg($this->packageName));
        $checkOutput = $this->execute($checkCommand);

        // If the package executable or service is not found, consider it uninstalled
        return $checkOutput === null;
    }

    public function directory() {
        $dir = "";
        if ($this->exists()) {
            $command = Linux::FIND_COMMAND . " " . $this->packageName;
            $output = $this->execute($command);
            $dir = $output;
        }
        return $dir;
    }

    public function purge() {
        $command = sprintf("echo '%s' | sudo -S %s $this->packageName -y", $this->password, Linux::PURGE_COMMAND);

        $output = $this->execute($command);
        // Command execution failed
        if ($output === null) {
            return false;
        }

        // Check if the package executable or service doesn't exist anymore
        $checkCommand = sprintf("which %s", escapeshellarg($this->packageName));
        $checkOutput = $this->execute($checkCommand);

        // If the package executable or service is not found, consider it purged
        return $checkOutput === null;
    }

    public function execute($command) {
        $output = null;
        exec($command, $output, $returnCode);
        if (!count($output)) {
            return null;
        }
        return implode("\n", $output);
    }
}
