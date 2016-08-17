<?php

namespace Watchdog\Entities\Operators;

class GreaterThanInclusive extends Operator
{
    public function execute($leftValue, $rightValue)
    {
        return $leftValue >= $rightValue;
    }
}
