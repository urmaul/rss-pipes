<?php

namespace rsspipes\sections;

use rsspipes\rss\Item;

/**
 * Section that replaces substring inside attribute.
 */
class Replace extends Section
{
    /**
     * @var callable
     */
    public $item;
    
    /**
     * Attribute we want to replace substring in.
     * @var string
     */
    public $attribute;
    /**
     * Subtring we want to replace.
     * @var string
     */
    public $search;
    /**
     * Subtring we want to replace with.
     * @var string
     */
    public $replace;
    
    public function init()
    {
        parent::init();
        
        \Assert\that($this->attribute, 'replace.attribute')->notEmpty()->inArray(Item::dataAttributes());
        \Assert\that($this->search, 'replace.search')->notEmpty()->string();
        \Assert\that($this->replace, 'replace.replace')->notEmpty()->string();
    }
    
    /**
     * @param Item $item
     */
    public function processItem($item)
    {
        $data = $item->getData();
        
        $replaced = [];
        $replaced[$this->attribute] = str_replace($this->search, $this->replace, $data[$this->attribute]);
        $item->setData($replaced);
    }
}
