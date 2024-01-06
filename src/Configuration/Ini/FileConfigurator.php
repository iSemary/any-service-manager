<?php

namespace Isemary\AnyServiceManager\Configuration\Ini;

class FileConfigurator {

    public function readFile(string $fileLocation): string {
        return file_get_contents($fileLocation) ?? "";
    }


    /**
     * The function `returnOptions` reads a configuration file and returns an array of key-value pairs for
     * the editable values in the file.
     * 
     * @param string fileLocation The `fileLocation` parameter is a string that represents the location of
     * the configuration file. It should be the file path or URL where the configuration file is located.
     * 
     * @return array an array of options. Each option is represented as an associative array with two keys:
     * 'key' and 'value'.
     */
    public function returnOptions(string $fileLocation): array {
        $data = [];
        $fileContent = $this->readFile($fileLocation);
        // Split the content of configuration file into an array of lines
        $lines = explode("\n", $fileContent);
        // Loop through each line of the file
        foreach ($lines as $line) {
            // Get the first letter of the line
            $firstLetterInLine = substr($line, 0, 1);
            // Check if it's a comment line or editable value
            if (!in_array($firstLetterInLine, [";", "[", "", " "])) {
                // Separate the key and value by exploding the string into 2 pieces
                $formattedLine = explode(" =", $line);
                if (count($formattedLine) == 2) {
                    $key = $formattedLine[0];
                    $value = $formattedLine[1];

                    $data[] = ['key' => $key, 'value' => $value];
                } else {
                    $formattedLine = explode("=", $line);
                    if (count($formattedLine) == 2) {
                        $key = $formattedLine[0];
                        $value = $formattedLine[1];
                        $data[] = ['key' => $key, 'value' => $value];
                    }
                }
            }
        }

        return $data;
    }

    /**
     * The `writeFile` function in PHP takes a file location and an array of options, reads the old file
     * content, replaces specific lines in the file with new values based on the options, and writes the
     * edited file back to the original location, returning a response indicating the success or failure of
     * the operation.
     * 
     * @param string fileLocation The file location is the path to the file that you want to write to. It
     * should be a string representing the file's location on the file system.
     * @param array options An array of options to be written to the file. Each option should have a 'name'
     * and 'value' key.
     * 
     * @return array an array with the following keys and values:
     */
    public function writeFile(string $fileLocation, array $options): array {
        // save old file content for rolling back case
        $oldFile = $this->readFile($fileLocation);

        try {
            $editedFile = $oldFile;
            foreach ($options as $option) {
                $escapedName = preg_quote($option['name'], '/'); // to avoid special characters like dots ex: (zend.exception_ignore_args)
                $searchPattern = "/^{$escapedName}\s*=\s*(.*)/m";
                $replacement = "{$option['name']} ={$option['value']}";
                $editedFile = preg_replace($searchPattern, $replacement, $editedFile);
            }

            $writeOut = $this->writeOutFile($fileLocation, $editedFile);
            if ($writeOut) {
                // Return response type
                return [
                    'status' => 200,
                    'success' => true,
                    'message' => "Ini file changed successfully"
                ];
            } else {
                echo "<pre>" . $editedFile . "</pre>";

                return [
                    'status' => 400,
                    'success' => false,
                    'message' => "Could't write out the old file"
                ];
            }
        } catch (\Exception $e) {
            // Rollback file changes
            $this->writeOutFile($fileLocation, $oldFile);
            // Return response type
            return [
                'status' => 400,
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    /**
     * The function writes the given content to a file at the specified location and returns true if
     * successful, false otherwise.
     * 
     * @param string fileLocation The file path where the file will be created or overwritten.
     * @param string fileContent The `` parameter is a string that represents the content that
     * you want to write to the file.
     * 
     * @return bool a boolean value. It returns true if the file was successfully written, and false if
     * there was an error opening the file.
     */
    private function writeOutFile(string $fileLocation, string $fileContent): bool {
        $handle = fopen($fileLocation, 'w');
        if ($handle) {
            ftruncate($handle, 0);
            fwrite($handle, $fileContent);
            fclose($handle);
            return true;
        }

        return false;
    }
}
