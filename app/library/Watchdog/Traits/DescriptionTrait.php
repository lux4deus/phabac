<?php

namespace Watchdog\Traits;

trait DescriptionTrait {
    
    protected $name;
    
    protected $description;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
}
