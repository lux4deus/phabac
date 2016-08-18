<?php

namespace Watchdog\Services;

use InvalidArgumentException;
use Illuminate\Support\Collection;
use Watchdog\Entities\Policy;

class ABACManager implements \Watchdog\Contracts\Validatable
{
    protected $policies;

    protected function __construct(array $policies)
    {
        Collection::macro('filterResponseType', function($responseType){
            return collect($this->items)->filter(function($policy) use ($responseType){
                return $policy->getResponseType() === $responseType;
            });
        });
        
        $this->policies = new Collection($policies);
        
        $this->policies->each(function($policy){
            if(! in_array($policy->getResponseType(), [Policy::ACCEPT, Policy::DENY])){
                throw new InvalidArgumentException("Policy response type is not recognized!");
            }
        });
        
        return $this;
    }
    
    public static function create(array $policies)
    {
        return new static($policies);
    }
    
    public function validate(Request $request)
    {
        // Validate Deny Policies
        if( $this->doesADenyPolicyPreventAccess($request) ){
            return FALSE;  // a DENY policy resolved to true, there access denied
        }
        
        // Validate Accept Policies
        return $this->doesOneAcceptPolicyGiveAccess($request);
    }
    
    protected function doesADenyPolicyPreventAccess(Request $request)
    {
        return $this->policies
            ->filterResponseType(Policy::DENY)
            ->reduce(function($carry, $policy) use ($request){
                return $carry ? $carry :  $policy->validate($request);
            }, FALSE);
    }
   
    protected function doesOneAcceptPolicyGiveAccess(Request $request)
    {
        return $this->policies
            ->filterResponseType(Policy::ACCEPT)
            ->reduce(function($carry, $policy) use ($request){
                return $carry ? $carry :  $policy->validate($request);
            }, FALSE);
    }
}
