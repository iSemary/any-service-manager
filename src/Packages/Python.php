<?php

namespace Isemary\AnyServiceManager\Packages;

use Isemary\AnyServiceManager\Abstractor\Package;
use Isemary\AnyServiceManager\Commands\Linux;
use Isemary\AnyServiceManager\Interfaces\PackageStatus;
use Isemary\AnyServiceManager\Traits\CommandExecutorTrait;

class Python extends Package implements Linux {
    use CommandExecutorTrait;

    private string $packageName;
    private string $password;

    public function __construct() {
        $this->packageName = "python3";
        $this->password = $_ENV['ROOT_PASSWORD'];
    }

    /**
     * The function checks if a package exists and returns its status as either active or inactive.
     * 
     * @return int an integer value. It returns PackageStatus::UNINSTALLED if the package is not found,
     * PackageStatus::ACTIVE if 'Active: active' exists in the output, and PackageStatus::INACTIVE
     * otherwise.
     */
    public function exists(): int {
        $checkVersion = $this->version();
        if ($checkVersion) {
            return PackageStatus::ACTIVE;
        }
        return PackageStatus::UNINSTALLED;
    }

    /**
     * The function "version" checks the version of a PHP package and returns it, or returns null if the
     * package is not found.
     * 
     * @return ?string a string value or null.
     */
    public function version(): ?string {
        $check = $this->packageName . " " . Linux::CHECK_VERSION_COMMAND;
        $output = $this->executeCommand($check);
        // If the output is empty, the package is not found
        if (!$output) {
            return null;
        } else {
            return $output;
        }
    }

    /**
     * The function "install" checks if a package or service exists and returns true if it does, otherwise
     * it returns false.
     * 
     * @return bool a boolean value. If the command execution fails or the package/service does not exist,
     * it will return false. Otherwise, it will return true.
     */
    public function install(): bool {
        $command = sprintf("echo '%s' | sudo -S %s $this->packageName -y", $this->password, Linux::INSTALL_COMMAND);

        $output = $this->executeCommand($command);
        // Command execution failed
        if ($output === null) {
            return false;
        }

        // Check if the package exists or service exists
        $checkCommand = sprintf("which %s", escapeshellarg($this->packageName));
        $checkOutput = $this->executeCommand($checkCommand);

        // If the package package exists or service exists
        return $checkOutput === null;
    }

    /**
     * The function uninstalls a package in Linux by executing a command and checking if the package
     * executable or service still exists.
     * 
     * @return bool a boolean value. It returns true if the package executable or service is not found,
     * indicating that the uninstallation was successful. It returns false if the command execution failed
     * or if the package executable or service still exists, indicating that the uninstallation was not
     * successful.
     */
    public function uninstall(): bool {
        $command = sprintf("echo '%s' | sudo -S %s $this->packageName -y", $this->password, Linux::UNINSTALL_COMMAND);

        $output = $this->executeCommand($command);
        // Command execution failed
        if ($output === null) {
            return false;
        }

        // Check if the package executable or service doesn't exist anymore
        $checkCommand = sprintf("which %s", escapeshellarg($this->packageName));
        $checkOutput = $this->executeCommand($checkCommand);

        // If the package executable or service is not found, consider it uninstalled
        return $checkOutput === null;
    }

    /**
     * The function "directory" returns the directory path of a package if it exists.
     * 
     * @return string a string that represents the directory of the package.
     */
    public function directory(): string {
        $dir = "";
        if ($this->exists()) {
            $command = Linux::FIND_COMMAND . " " . $this->packageName;
            $output = $this->executeCommand($command);
            $dir = $output;
        }
        return $dir;
    }

    /**
     * The function "purge" in PHP executes a command to remove a package and checks if the package
     * executable or service still exists to determine if it was successfully purged.
     * 
     * @return bool a boolean value. It returns true if the package executable or service is not found,
     * indicating that the purge was successful. It returns false if the command execution failed or if the
     * package executable or service still exists, indicating that the purge was not successful.
     */
    public function purge(): bool {
        $command = sprintf("echo '%s' | sudo -S %s $this->packageName -y", $this->password, Linux::PURGE_COMMAND);

        $output = $this->executeCommand($command);
        // Command execution failed
        if ($output === null) {
            return false;
        }

        // Check if the package executable or service doesn't exist anymore
        $checkCommand = sprintf("which %s", escapeshellarg($this->packageName));
        $checkOutput = $this->executeCommand($checkCommand);

        // If the package executable or service is not found, consider it purged
        return $checkOutput === null;
    }
}
