<?php

namespace Watchdog\Entities\Operators;

class Equals extends Operator {
    
    public function execute($leftValue, $rightValue)
    {
        return $leftValue === $rightValue;
    }
}
