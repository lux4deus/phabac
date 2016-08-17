<?php

namespace Watchdog\Entities\Operators;

class LessThan extends Operator
{
    public function execute($leftValue, $rightValue)
    {
        return $leftValue < $rightValue;
    }
}
