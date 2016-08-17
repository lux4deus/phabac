<?php

namespace Watchdog\Contracts;

use Watchdog\Services\Request;

interface Validatable {
    
    /**
     * 
     * @param   ABAC\Services\Request
     * @returns Boolean
     */
    public function validate(Request $request);
}
