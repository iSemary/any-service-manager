<?php

namespace Isemary\AnyServiceManager\Packages;

use Isemary\AnyServiceManager\Abstractor\Package;
use Isemary\AnyServiceManager\Commands\Linux;
use Isemary\AnyServiceManager\Interfaces\PackageStatus;
use Isemary\AnyServiceManager\Logger\Logger;

class Elasticsearch extends Package implements Linux {
    private string $packageName;
    private string $password;
    private Logger $logger;

    public function __construct() {
        $this->packageName = "elasticsearch";
        $this->password = $_ENV['ROOT_PASSWORD'];
        $this->logger = new Logger;
    }

    /**
     * The function checks if a package exists and returns its status as either active, inactive, or
     * uninstalled.
     * 
     * @return int an integer value. The value returned depends on the conditions met in the function. If
     * the output is empty, the function returns the constant value `PackageStatus::UNINSTALLED`. If the
     * output contains the string 'Active: active', the function returns the constant value
     * `PackageStatus::ACTIVE`. Otherwise, the function returns the constant value
     * `PackageStatus::INACTIVE`.
     */
    public function exists(): int {
        $check = Linux::SYSTEMCTL_STATUS . " " . $this->packageName;
        $output = $this->execute($check);
        // If the output is empty, the package is not found
        if (!$output) {
            return PackageStatus::UNINSTALLED;
        }
        // check if 'Active: active' exists in the output
        return (strpos($output, 'Active: active') !== false) ? PackageStatus::ACTIVE : PackageStatus::INACTIVE;
    }

    /**
     * The function returns the version of a PHP package if it is found, otherwise it returns null.
     * 
     * @return ?string a string value or null.
     */
    public function version(): ?string {
        $check = $this->packageName . " " . Linux::CHECK_VERSION_COMMAND;
        $output = $this->execute($check);
        // If the output is empty, the package is not found
        if (!$output) {
            return null;
        } else {
            return $output;
        }
    }

    /**
     * The function "install" checks if a package or service exists and returns true if it does,
     * otherwise it returns false.
     * 
     * @return bool a boolean value. It returns true if the package exists or service exists, and false
     * if the command execution fails or the package/service does not exist.
     */
    public function install(): bool {
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

    /**
     * The function "directory" returns the directory path of a package if it exists.
     * 
     * @return string a string that represents the directory of the package.
     */
    public function directory(): string {
        $dir = "";
        if ($this->exists()) {
            $command = Linux::FIND_COMMAND . " " . $this->packageName;
            $output = $this->execute($command);
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

    /**
     * The function executes a command and returns the output as a formatted string, while also logging the
     * output.
     * 
     * @param command The `` parameter is a string that represents the command to be executed. It
     * is passed to the `exec()` function, which runs the command in the shell. The output of the command
     * is captured in the `` array.
     * 
     * @return ?string a formatted output string.
     */
    public function execute($command): ?string {
        $output = null;
        exec($command, $output, $returnCode);
        if (!count($output)) {
            return null;
        }
        $formattedOutput = implode("\n", $output);
        $this->logger->write($formattedOutput, "Elasticsearch");
        return $formattedOutput;
    }
}
