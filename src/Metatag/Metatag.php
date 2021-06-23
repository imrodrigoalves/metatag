<?php

namespace RodrigoAlves\Metatag;

use RodrigoAlves\Metatag\Models\Tag;
use RodrigoAlves\Metatag\Models\NameTag;
use RodrigoAlves\Metatag\Models\PropertyTag;

class Metatag
{
    private $tags = [];

    public function add(Tag $tag)
    {
        if ($key = $this->getKeyIfDuplicate($tag)) {
            $this->tags[$key]->setValue($tag->getValue());
        } else {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function image(string $path)
    {
        $this->add(app()->metatag->createPropertyTag('og:image', $path))
            ->add(app()->metatag->createPropertyTag('twitter:image', $path));
            
        return $this;
    }

    public function title(string $title)
    {
        $this->add(app()->metatag->createPropertyTag('og:title', $title))
            ->add(app()->metatag->createPropertyTag('twitter:title', $title));
            
        return $this;

    }

    public function description(string $description)
    {
        $this->add(app()->metatag->createNameTag('description', $description))
            ->add(app()->metatag->createPropertyTag('og:description', $description))
            ->add(app()->metatag->createPropertyTag('twitter:description', $description));
            
        return $this;
    }
    
    public function url(string $url)
    {
        $this->add(app()->metatag->createPropertyTag('og:url', $url))
            ->add(app()->metatag->createPropertyTag('twitter:url', $url));
            
        return $this;
    }

    public function toHtml()
    {
        foreach ($this->tags as $tag) {
            echo $tag->toHtml() . "\n";
        }
    }

    public function createPropertyTag(string $name, string $value)
    {
        return new PropertyTag($name, $value);
    }

    public function createNameTag(string $name, string $value)
    {
        return new NameTag($name, $value);
    }

    private function getKeyIfDuplicate(Tag $tag)
    {
        foreach ($this->tags as $key => $existingTag) {
            if ($existingTag->getName() === $tag->getName()) {
                return $key;
            }
        }
    }
}
