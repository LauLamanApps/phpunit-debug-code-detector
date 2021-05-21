<?php

namespace LauLamanApps\DebugCodeDetector\Detector\Php;

use LauLamanApps\DebugCodeDetector\Detector\AbstractDetector;

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