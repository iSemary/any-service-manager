<?php

namespace Isemary\AnyServiceManager\Configuration\Ini;

use Isemary\AnyServiceManager\Traits\CommandExecutorTrait;

class FileManager {
    use CommandExecutorTrait;

    /**
     * Retrieves a list of available PHP configuration files.
     *
     * @return array An array containing the paths of available PHP configuration files.
     */
    public function getAvailableFiles(): array {
        $files = [];

        $getLoadedFilesCommand = "find /etc -name php.ini 2>/dev/null";
        $iniLoadedFiles = $this->executeCommand($getLoadedFilesCommand);
        if ($iniLoadedFiles) {
            $files = explode(PHP_EOL, $iniLoadedFiles);
        }
        return $files;
    }

    /**
     * The function checks if a file exists.
     * 
     * @param string file The file parameter is a string that represents the path to a file that you want
     * to check for existence.
     * 
     * @return bool a boolean value, either true or false.
     */
    public function checkFileExists(string $file): bool {
        return file_exists($file);
    }
}
