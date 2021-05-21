<?php

namespace LauLamanApps\DebugCodeDetector;

use LauLamanApps\DebugCodeDetector\Detector\AbstractDetector;
use LauLamanApps\DebugCodeDetector\Detector\Php\PrintRDetector;
use LauLamanApps\DebugCodeDetector\Detector\Php\VarDumpDetector;
use LauLamanApps\DebugCodeDetector\Detector\Symfony\VarDumper\DieDumpDetector;
use LauLamanApps\DebugCodeDetector\Detector\Symfony\VarDumper\DumpDetector;
use LauLamanApps\DebugCodeDetector\Exception\DebugCodeDetectedException;
use LogicException;
use PHPUnit\Runner\AfterLastTestHook;

class DebugCodeDetectorExtension implements AfterLastTestHook
{
    private bool $colors;
    private string $projectPath;
    private array $foldersToScan;
    private bool $debugCodeDetected = false;

    /** @var AbstractDetector[] */
    private array $detectors;

    public function __construct(
        array $foldersToScan,
        null|array|string $detectors = 'all',
        ?bool $colors = null,
        ?string $projectPath = null,
    ) {
        $this->foldersToScan = $foldersToScan;
        $this->configureDetectors($detectors);
        $this->colors = $colors ?? true;
        $this->projectPath = $projectPath?? getcwd();
    }

    private function configureDetectors(array|string $detectors): void
    {
        if ($detectors === 'all') {
            $this->detectors = [
                new VarDumpDetector(),
                new PrintRDetector(),
                new DumpDetector(),
                new DieDumpDetector(),
            ];

            return;
        }

        if (count(array_filter($detectors, function ($detector) {
                return !($detector instanceof AbstractDetector);
            })) > 0) {

            throw new LogicException('Unknown detector given. Please check the PHPUnit configuration. When using a CUSTOM detector make sure it implements AbstractDetector');
        }

        $this->detectors = $detectors;
    }

    public function executeAfterLastTest(): void
    {
        foreach ($this->foldersToScan as $folder) {
            $this->scanFilesInFolder($folder);
        }

        if ($this->debugCodeDetected) {
            throw new DebugCodeDetectedException($this->colors);
        }
    }

    private function scanFilesInFolder(string $folder): void
    {
        $files = $this->getRecursiveFilesInFolder($folder);
        foreach ($files as $file) {
            $this->readFile($file);
        }
    }


    private function readFile(string $file): void
    {
        $fh = fopen($this->projectPath . DIRECTORY_SEPARATOR . $file, 'r');
        $lineNumber = 0;

        while (!feof($fh)) {
            $lineNumber++;
            $data = fgets($fh, 4096);
            if (!$data === false) {
                $this->detectDebugCode($data, $file, $lineNumber);
            }
        }
        fclose($fh);
    }

    private function detectDebugCode(string $data, string $file, int $lineNumber)
    {
        foreach ($this->detectors as $detector) {
            if ($detector->isDetected($data)) {
                $this->printError($detector->getName(), $file, $lineNumber);
                $this->debugCodeDetected = true;
            }
        }
    }

    private function getRecursiveFilesInFolder(string $folder): array
    {
        $dirContents = scandir($this->projectPath . DIRECTORY_SEPARATOR . $folder);
        $files = [];

        foreach ($dirContents as $key => $value) {
            $path = realpath($folder . DIRECTORY_SEPARATOR . $value);
            if (in_array($value, ['.', '..'])) {
                continue;
            }

            if (is_dir($path)) {
                $files = array_merge($files, $this->getRecursiveFilesInFolder($folder. DIRECTORY_SEPARATOR . $value));
                continue;
            }

            $files[] = str_replace($this->projectPath, '', $path);
        }

        return $files;
    }

    private function printError(string $code, string $file, int $lineNumber): void
    {
        if ($this->colors) {
            $message = "Debug code \e[0;31m%s\e[0m found in file \e[0;33m%s\e[0m on line \e[0;33m%s\e[0m\n";
        } else {
            $message = "Debug code '%s' found in file %s on line %s\n";
        }

        echo sprintf(
            $message,
            $code,
            $file,
            $lineNumber
        );
    }
}