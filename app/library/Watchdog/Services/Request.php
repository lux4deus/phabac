<?php

namespace Watchdog\Services;

use InvalidArgumentException;
use Watchdog\Entities\User;
use Watchdog\Entities\Environment;

class Request
{
    protected $action;
    
    protected $resource;
    
    protected $user;
    
    protected $environment;
    
    public function __construct($action, $resource, User $user, Environment $env)
    {
        $this->action = $action;
        $this->resource = $ressource;
        $this->user = $user;
        $this->environment = $env;
    }
    
    public function getValue($value)
    {
        $params = explode(".", $value);
        
        // is value a dot notation starting with $.
        if( $params[0] === "$" ){
            
            array_shift($params);
            
            return array_reduce($params, function($carry, $item){
                // Check property not is set
                if(! property_exists($carry, $item)){
                    throw new InvalidArgumentException("Property '$item' does not exist!");
                }
                
                return $carry->{$item};
            }, $this);
        }
        
        return $params[0];
    }
}
