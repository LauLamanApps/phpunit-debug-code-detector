<?php

namespace LauLamanApps\PhpunitDebugCodeDetector\Detector\Php;

use LauLamanApps\PhpunitDebugCodeDetector\Detector\AbstractDetector;

class VarDumpDetector extends AbstractDetector
{
    public function getName(): string
    {
        return 'var_dump()';
    }

    public function getRegex(): string
    {
        return "/var_dump\(.+?\);/";
    }
}