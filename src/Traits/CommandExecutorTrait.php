<?php

namespace Isemary\AnyServiceManager\Traits;

use Isemary\AnyServiceManager\Logger\Logger;

trait CommandExecutorTrait {
    protected Logger $logger;

    public function initializeLogger(): void {
        $this->logger = new Logger();
    }

    /**
     * The function executes a command and returns the formatted output, while also logging the output
     * using a logger.
     * 
     * @param string command The `command` parameter is a string that represents the command to be
     * executed. It is passed to the `exec()` function, which executes the command in the shell. The output
     * of the command is captured in the `` array, and the return code of the command is stored in
     * the `$
     * 
     * @return ?string a formatted output string if there is any output from the executed command. If there
     * is no output, it returns null.
     */
    private function executeCommand(string $command): ?string {
        $this->initializeLogger();
        $output = null;
        exec($command, $output, $returnCode);

        if (!count($output)) {
            return null;
        }

        $formattedOutput = implode("\n", $output);
        $this->logger->write($formattedOutput, static::class);

        return $formattedOutput;
    }
}
