<?php

namespace PHPExperts\MiniApiBase;

use Minicli\App;
use Minicli\Output\Printer;
use ReflectionClass;

class Installer
{
    protected string $projectRoot;
    protected string $packageRoot;
    protected Printer $printer;

    public function __construct(App $app)
    {
        $this->projectRoot = getcwd();
        $this->packageRoot = dirname((new ReflectionClass(self::class))->getFileName(), 2);
        $this->printer = $app->getPrinter();
    }

    public function run(): void
    {
        $this->printer->display("Starting Mini API Base framework installation...");
        $itemsToPublish = ['.framework', 'bin', 'database', 'prompts', 'public', 'src'];

        foreach ($itemsToPublish as $item) {
            $source = $this->packageRoot . '/' . $item;
            $destination = $this->projectRoot . '/' . $item;
            if (!file_exists($source)) continue;
            $this->recursiveCopy($source, $destination);
        }

        $this->printer->success("Framework installation complete!");
        $this->printer->info("Please re-run 'php app' to see the available application commands.");
    }

    protected function recursiveCopy(string $source, string $destination): void
    {
        if (is_dir($source)) {
            if (!is_dir($destination)) mkdir($destination, 0755, true);
            $files = scandir($source);
            foreach ($files as $file) {
                if ($file !== "." && $file !== "..") {
                    $this->recursiveCopy("$source/$file", "$destination/$file");
                }
            }
        } elseif (file_exists($source)) {
            if (!file_exists($destination)) {
                copy($source, $destination);
                $this->printer->info(sprintf("  - Copied: %s", str_replace($this->projectRoot . '/', '', $destination)));
            } else {
                $this->printer->info(sprintf("  - Exists: %s", str_replace($this->projectRoot . '/', '', $destination)));
            }
        }
    }
}
