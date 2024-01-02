<?php

namespace Isemary\AnyServiceManager\Logger;


class Logger {
    private string $path;

    public function __construct() {
        $this->path =  __DIR__ . "/../../logs/";
    }

    /**
     * The function writes a message to a log file and returns a status and message indicating whether the
     * logging was successful or not.
     * 
     * @param array message The "message" parameter can be either an array or a string. It represents the
     * content of the log message that you want to write.
     * @param string package The "package" parameter is a string that represents the name of the package or
     * module for which the log message is being written.
     * 
     * @return array an array with the following keys and values:
     */
    public function write(array|string $message, string $package): array {
        try {
            $dir = $this->path . $package . ".log";
            if (!is_dir(dirname($dir))) {
                mkdir(dirname($dir), 0777, true);
            }

            if (!file_exists($dir)) {
                fopen($dir, "w");
            }

            $dir = fopen($dir, 'a');
            $message = self::formatLogMessage($message);
            fwrite($dir, $message);
            fclose($dir);

            return [
                'status' => 200,
                'success' => true,
                'message' => "Message logged successfully"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'success' => false,
                'message' => "Failure on logging. message : " . $e->getMessage()
            ];
        }
    }

    /**
     * The function `returnLog` returns the contents of a log file for a given package, along with a status
     * code, success flag, and error message if applicable.
     * 
     * @param string package The parameter "package" is a string that represents the name of the package
     * for which you want to retrieve the log file.
     * 
     * @return array an array with different keys and values depending on the conditions.
     */
    public function returnLog(string $package): array {
        try {
            $logFile = $this->path . $package . ".log";
            if (file_exists($logFile)) {
                $log = file_get_contents($logFile);
                return [
                    'status' => 200,
                    'success' => true,
                    'data' => $log
                ];
            } else {
                return [
                    'status' => 400,
                    'success' => false,
                    'message' => "Log file not exists"
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'success' => false,
                'message' => "Failed to fetch log file. message : " . $e->getMessage()
            ];
        }
    }

    /**
     * The function formatLogMessage formats a log message by adding a timestamp and converting the
     * original message to a JSON string.
     * 
     * @param array originalMessage The `originalMessage` parameter can be either an array or a string. It
     * represents the message that needs to be formatted for logging.
     * 
     * @return string a formatted log message as a string.
     */
    private function formatLogMessage(array|string $originalMessage): string {
        $dateTime = "[" . date("Y-m-d H:i:s") . "]";
        $message = "------------------------------------$dateTime-----------------------------------------------\n";
        $message .= json_encode($originalMessage);
        $message .= "\n";
        return $message;
    }
}
