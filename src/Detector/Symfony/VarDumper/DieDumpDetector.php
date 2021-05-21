<?php

namespace LauLamanApps\PhpunitDebugCodeDetector\Detector\Symfony\VarDumper;

use LauLamanApps\PhpunitDebugCodeDetector\Detector\AbstractDetector;

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