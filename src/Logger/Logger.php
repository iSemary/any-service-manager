<?php

namespace Isemary\AnyServiceManager\Logger;


class Logger {


    public function write(array|string $message, string $file): array {
        try {
            $dir = __DIR__ . "/../../logs/" . $file . ".log";
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
                'message' => "Failure on logging message : " . $e->getMessage()
            ];
        }
    }

    private function formatLogMessage(array|string $originalMessage): string {
        $dateTime = "[" . date("Y-m-d H:i:s") . "]";
        $message = "------------------------------------$dateTime-----------------------------------------------\n";
        $message .= json_encode($originalMessage);
        $message .= "\n";
        return $message;
    }
}
