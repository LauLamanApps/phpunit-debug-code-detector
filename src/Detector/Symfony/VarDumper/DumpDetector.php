<?php

namespace LauLamanApps\DebugCodeDetector\Detector\Symfony\VarDumper;

use LauLamanApps\DebugCodeDetector\Detector\AbstractDetector;

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