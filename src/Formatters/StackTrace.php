<?php

declare(strict_types=1);

namespace Transgressions\Formatters;

use Throwable;

class StackTrace
{
    /**
     * Creates and instance of the stack trace formatter
     *
     * @return static
     */
    public static function create(): static
    {
        return new static;
    }

    /**
     * Accepts an exception and returns a stack trace with the lines around the problem
     *
     * @param Throwable $throwable
     * @return array
     */
    public function get(Throwable $throwable): array
    {
        $traces = $throwable->getTrace();
        foreach ($traces as &$trace) {
            $trace['file-data'] = $this->getFileLines($trace);
        }

        $currentFile = [
            'message' => $throwable->getMessage(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
            'code' => $throwable->getCode(),
        ];

        $currentFile['file-data'] = $this->getFileLines($currentFile);

        array_unshift($traces, $currentFile);

        return $traces;
    }

    /**
     * Get the files line data. Gets +/- 8 lines from where the error occurs
     *
     * @param array $trace
     * @return array
     */
    private function getFileLines(array $trace): array
    {
        $fileLines = file($trace['file']);
        $line = $trace['line'] - 1;
        $maxLines = count($fileLines) - 1;

        $startLine = $line - 8;
        $endLine = $line + 8;

        $startLine < 0 and $startLine = 0;
        $endLine > $maxLines and $endLine = $maxLines;

        $currentLine = $startLine;

        $collectedLines = [];
        do {
            $collectedLines[$currentLine] = $fileLines[$currentLine];
            $currentLine++;
        } while ($currentLine < $endLine);

        return $collectedLines;
    }
}
