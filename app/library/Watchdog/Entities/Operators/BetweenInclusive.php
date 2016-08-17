<?php

namespace Watchdog\Entities\Operators;

use InvalidArgumentException;

class BetweenInclusive extends Operator
{
    public function execute($leftValue, $rightValue)
    {
        if (!is_array($rightValue))
			throw new InvalidArgumentException("Second parameter must be an array.");
        
        return $rightValue[0] <= $leftValue && $leftValue <= $rightValue[1];
    }
}
