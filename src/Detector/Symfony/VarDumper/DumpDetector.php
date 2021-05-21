<?php

namespace LauLamanApps\PhpunitDebugCodeDetector\Detector\Symfony\VarDumper;

use LauLamanApps\PhpunitDebugCodeDetector\Detector\AbstractDetector;

class DumpDetector extends AbstractDetector
{
    public function getName(): string
    {
        return 'dump()';
    }
    public function getRegex(): string
    {
        return "/\bdump\(.+?\)/";
    }
}