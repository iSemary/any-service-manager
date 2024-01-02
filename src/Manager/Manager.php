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

    public function isValidPackage(string $package): bool {
        return in_array($package, $this->packages);
    }
}
