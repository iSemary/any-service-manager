<?php

namespace Isemary\AnyServiceManager\Manager;

class Manager {
    public $packagesPath;
    public $packagesNamespace;
    public $packages;

    public function __construct() {
        $this->packagesPath = __DIR__ . "/../Packages";
        $this->packagesNamespace = "Isemary\AnyServiceManager\Packages\\";
        $this->packages = $this->setPackages();
    }

    /**
     * The function "setPackages" retrieves the class names from PHP files in a specified directory and
     * returns them as an array, or returns false if the directory does not exist.
     * 
     * @return array|bool an array of class names if the packages directory exists and contains PHP
     * files. If the packages directory does not exist or does not contain any PHP files, it returns
     * false.
     */
    private function setPackages(): array|bool {
        $packages = [];
        if (is_dir($this->packagesPath)) {
            // Get all PHP files in the packages folder
            $phpFiles = glob($this->packagesPath . '/*.php');
            foreach ($phpFiles as $phpFile) {
                // Extract class names from each PHP file
                $fileContent = file_get_contents($phpFile);
                // Match class names in each file in this folder
                preg_match_all('/class\s+(\w+)/', $fileContent, $matches);
                // Add the matched class names to the result array
                $packages[] = $matches[1][0];
            }
            return $packages;
        }
        return false;
    }

    /**
     * The function "checkPackagesStatus" checks the status of multiple packages and returns an array of
     * their names and statuses.
     * 
     * @return array|bool an array of package statuses or a boolean value of false.
     */
    public function checkPackagesStatus(): array|bool {
        if (count($this->packages)) {
            $statuses = [];
            foreach ($this->packages as $key => $package) {
                $packageNamespace = $this->packagesNamespace . $package;
                $packageInstance = new $packageNamespace();
                $status = $packageInstance->exists();
                $version = $packageInstance->version();
                $statuses[] = [
                    'name' => $package,
                    'status' => $status,
                    'version' => $version,
                ];
            }
            return $statuses;
        }

        return false;
    }

    /**
     * The function checks if a given package is valid by checking if it exists in an array of packages.
     * 
     * @param string package A string representing the package name that needs to be checked for validity.
     * 
     * @return bool a boolean value, either true or false.
     */
    public function isValidPackage(string $package): bool {
        return in_array($package, $this->packages);
    }
}
