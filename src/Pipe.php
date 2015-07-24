<?php

namespace rsspipes;

use rsspipes\rss\Feed;
use rsspipes\sections\Section;

class Pipe
{
    /**
     * @var Section[] 
     */
    private $sections = [];
    
    public function __construct($config)
    {
        foreach ($config as $sectionConfig) {
            $this->sections[] = Section::create($sectionConfig);
        }
    }
    
    public function run()
    {
        $feed = new Feed;
        
        foreach ($this->sections as $section) {
            $section->processFeed($feed);
        }
        
        return $feed;
    }
}
