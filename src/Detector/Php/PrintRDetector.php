<?php

namespace LauLamanApps\DebugCodeDetector\Detector\Php;

use LauLamanApps\DebugCodeDetector\Detector\AbstractDetector;

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