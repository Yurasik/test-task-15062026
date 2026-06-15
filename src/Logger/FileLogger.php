<?php

declare(strict_types=1);

namespace App\Logger;

class FileLogger implements LoggerInterface
{
    public function __construct(private string $path) {}

    public function log(string $message): void
    {
        $dir = dirname($this->path);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, recursive: true);
        }

        $line = '[' . date('Y-m-d H:i') . '] ' . $message . PHP_EOL;
        file_put_contents($this->path, $line, FILE_APPEND | LOCK_EX);
    }
}
