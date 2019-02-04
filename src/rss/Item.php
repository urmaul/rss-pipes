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
    
    public function __construct($data = null)
    {
        if ($data !== null)
            $this->setData($data);
    }
    
    public function getData()
    {
        $data = [];
        foreach (self::dataAttributes() as $name) {
            $data[$name] = $this->$name;
        }
        return $data;
    }
    
    public function setData($data)
    {
        foreach (self::dataAttributes() as $name) {
            if (isset($data[$name]))
                $this->$name = $data[$name];
        }
    }
    
    public static function dataAttributes()
    {
        return ['guid', 'pubDate', 'title', 'link', 'description', 'comments'];
    }
}
