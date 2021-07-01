<?php

namespace Metatag\Models;

abstract class Tag {
    
    protected string $identifier;
    protected string $name;
    protected string $value;
    
    public function __construct(string $name, string $value)
    {
        $this->setName($name);
        $this->setValue($value);
    } 
         
    public function getName()
    {
        return $this->name;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    private function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function setValue(string $value)
    {
        $this->value = $value;
    }
    
    public function toHtml()
    {
        return "<meta {$this->identifier}='{$this->name}' content='{$this->value}' >";
    }
}