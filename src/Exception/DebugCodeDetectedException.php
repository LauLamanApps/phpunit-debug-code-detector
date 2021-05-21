<?php

namespace LauLamanApps\DebugCodeDetector\Exception;

use Exception;

class DebugCodeDetectedException extends Exception
{
    public function __construct(bool $useColor)
    {
        $message = "ERROR: Debug code was detected.";

        if ($useColor) {
            $message = "\e[1;37;41m" . $message . "\e[0m\n";
        }

        parent::__construct($message);
    }
}