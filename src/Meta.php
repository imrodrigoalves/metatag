<?php

namespace Metatag;

use Metatag\Models\Tag;
use Metatag\Models\NameTag;
use Metatag\Models\PropertyTag;

class Meta
{
    private array $tags = [];

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
        $this->add($this->createPropertyTag('og:image', $path))
            ->add($this->createPropertyTag('twitter:image', $path));
            
        return $this;
    }

    public function title(string $title, bool $isPageTitle = false)
    {
        $this->add($this->createPropertyTag('og:title', $title))
            ->add($this->createPropertyTag('twitter:title', $title));

        if($isPageTitle){
            $this->pageTitle($title);
        }

        return $this;
    }

    public function description(string $description)
    {
        $this->add($this->createNameTag('description', $description))
            ->add($this->createPropertyTag('og:description', $description))
            ->add($this->createPropertyTag('twitter:description', $description));
            
        return $this;
    }
    
    public function url(string $url)
    {
        $this->add($this->createPropertyTag('og:url', $url))
            ->add($this->createPropertyTag('twitter:url', $url));
            
        return $this;
    }

    public function pageTitle(string $title)
    {
        $this->add($this->createHtmlTag('title', $title));
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

    public function createHtmlTag(string $tagName, string $title)
    {
        return new HtmlTag($tagName, $title);
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
