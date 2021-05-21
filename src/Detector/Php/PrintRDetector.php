<?php

namespace LauLamanApps\PhpunitDebugCodeDetector\Detector\Php;

use LauLamanApps\PhpunitDebugCodeDetector\Detector\AbstractDetector;

class PrintRDetector extends AbstractDetector
{
    public function getName(): string
    {
        return 'print_r()';
    }

    public function getRegex(): string
    {
        return "/\bprint_r\(.+?\);/";
    }
}