<?php

namespace rsspipes\rss;

use SimpleXMLElement;

class Item
{
    public $guid;
    public $pubDate;
    public $title;
    public $link;
    public $description;
    public $comments;
    public $category = [];
    
    public $attributes = [];
    
    public function getData()
    {
        $data = [];
        foreach (['guid', 'pubDate', 'title', 'link', 'description', 'comments'] as $name) {
            $data[$name] = $this->$name;
        }
        return $data;
    }
    
    public function setData($data)
    {
        foreach (['guid', 'pubDate', 'title', 'link', 'description', 'comments'] as $name) {
            if (isset($data[$name]))
                $this->$name = $data[$name];
        }
    }
    
    /**
     * 
     * @param SimpleXMLElement $xml
     */
    public function fillXmlElement($xml)
    {
        foreach (['guid', 'pubDate', 'title', 'link', 'description', 'comments'] as $name) {
            $this->addChild($xml, $name);
        }
    }
    
    /**
     * 
     * @param SimpleXMLElement $xml
     * @param string $name
     */
    private function addChild($xml, $name)
    {
        $child = $xml->addChild($name, $this->$name);
        
        if (isset($this->attributes[$name])) {
            foreach ($this->attributes[$name] as $key => $value) {
                $child->addAttribute($key, $value);
            }
        }
    }
}
