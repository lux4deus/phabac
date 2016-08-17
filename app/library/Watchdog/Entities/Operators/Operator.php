<?php

namespace Watchdog\Entities\Operators;

abstract class Operator
{
    abstract public function execute($leftValue, $rightValue);
}
