<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;

abstract class Section
{
    public function init()
    {
    }
    
    /**
     * @param Feed $feed
     */
    public function processFeed($feed)
    {
        foreach ($feed->items as $item) {
            $this->processItem($item);
        }
    }
    
    /**
     * @param Item $item
     */
    public function processItem($item)
    {
        throw new \Exception(__METHOD__ . 'shouldn`t be called.');
    }
    
    public static function create($config)
    {
        $class = __NAMESPACE__ . '\\' . ucfirst($config['type']);
        unset($config['type']);

        if (!class_exists($class))
            throw new Exception('Section does not exist: ' . $class);
        
        $section = new $class();
        foreach ($config as $key => $val) {
            $section->$key = $val;
        }
        
        $section->init();
        
        return $section;
    }
}

class Exception extends \Exception
{}

