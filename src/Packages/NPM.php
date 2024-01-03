<?php

namespace Isemary\AnyServiceManager\Packages;

use Isemary\AnyServiceManager\Abstractor\Package;
use Isemary\AnyServiceManager\Commands\Linux;
use Isemary\AnyServiceManager\Interfaces\PackageStatus;
use Isemary\AnyServiceManager\Logger\Logger;

class NPM extends Package implements Linux {
    private string $packageName;
    private string $password;
    private Logger $logger;

    public function __construct() {
        $this->packageName = "npm";
        $this->password = $_ENV['ROOT_PASSWORD'];
        $this->logger = new Logger;
    }

    /**
     * The exists() function checks if a package exists on a Linux system and returns its status.
     * 
     * @return int an integer value. If the package is not found, it returns the constant
     * `PackageStatus::UNINSTALLED`, otherwise it returns the constant `PackageStatus::ACTIVE`.
     */
    public function exists(): int {
        $check = $this->packageName . " " . Linux::CHECK_VERSION_COMMAND;
        $output = $this->execute($check);
        // If the output is empty, the package is not found
        if (!$output) {
            return PackageStatus::UNINSTALLED;
        } else {
            return PackageStatus::ACTIVE;
        }
    }

    /**
     * The version() function checks the version of a package and returns it, or returns null if the
     * package is not found.
     * 
     * @return string|null The version of the package or null if not found.
     */
    public function version(): ?string {
        $checkCommand = $this->packageName . " " . Linux::CHECK_VERSION_COMMAND;
        $output = $this->execute($checkCommand);
        // If the output is empty, the package is not found
        if (!$output) {
            return null;
        } else {
            // Return the version information
            return $output;
        }
    }

    /**
     * The function "install" checks if a package or service exists and returns true if it does, otherwise
     * it returns false.
     * 
     * @return bool a boolean value. It returns true if the package exists or service exists, and false if
     * the command execution fails or the package does not exist.
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
     * The function uninstalls a package in Linux using a sudo command and checks if the package executable
     * or service is no longer found to confirm successful uninstallation.
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
     * @param string command The `command` parameter is a string that represents the command to be
     * executed. It can be any valid command that can be executed in the command line, such as running a
     * script, installing a package, or executing a system command.
     * 
     * @return ?string a formatted output string if there is any output from the executed command. If there
     * is no output, it returns null.
     */
    public function execute(string $command): ?string {
        $output = null;
        exec($command, $output, $returnCode);
        if (!count($output)) {
            return null;
        }
        $formattedOutput = implode("\n", $output);
        $this->logger->write($formattedOutput, "NPM");
        return $formattedOutput;
    }
}
