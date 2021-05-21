<?php

namespace LauLamanApps\DebugCodeDetector\Detector;

abstract class AbstractDetector
{
    abstract public function getName(): string;

    abstract public function getRegex(): string;

    public function isDetected(string $data): bool
    {
        return preg_match($this->getRegex(), $data) === 1;
    }
}