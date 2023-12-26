<?php

namespace Isemary\AnyServiceManager\Manager;

class Manager {
    public $packagesPath;
    public $packages;
    public function __construct() {
        $this->packagesPath = __DIR__ . "/../Packages";
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
                $packages = array_merge($packages, $matches[1]);
                return $packages;
            }
        }
        return false;
    }

    public function checkPackagesStatus(): array|bool {
        $statuses = [];
        if (count($this->packages)) {
            foreach ($this->packages as $key => $package) {
                $packageInstance = new $this->packagesPath . '\\' . $package();
                $status = $packageInstance->exists();
                $statuses[] = [
                    'name' => $package,
                    'status' => $status
                ];
            }
        }

        return false;
    }
}
