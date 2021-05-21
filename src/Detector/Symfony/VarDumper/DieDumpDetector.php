<?php

namespace LauLamanApps\DebugCodeDetector\Detector\Symfony\VarDumper;

use LauLamanApps\DebugCodeDetector\Detector\AbstractDetector;

class DieDumpDetector extends AbstractDetector
{
    public function getName(): string
    {
        return 'dd()';
    }

    public function getRegex(): string
    {
        return "/\bdd\(.+?\)/";
    }
}