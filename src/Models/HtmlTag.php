<?php

namespace Metatag\Models;

use Metatag\Models\Tag;

class HtmlTag extends Tag {
    
    protected string $identifier = '';

    public function toHtml()
    {
        return "<{$this->name}>{$this->value}</{$this->name}>";
    }
}