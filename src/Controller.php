<?php

namespace rsspipes;

use SimpleXMLElement;
use rich\collections\Strings;
use Symfony\Component\Yaml\Yaml;

class Controller
{
    private $pipesDir;
    
    public function __construct($pipesDir)
    {
        $this->pipesDir = $pipesDir;
    }
    
    public function listPipes()
    {
        return Strings::from(scandir($this->pipesDir))
            ->diff(['.', '..'])
            ->filter(function($name) {
                return preg_match('~\.yml$~', $name);
            })
            ->replace('.yml', '')
            ->values();
    }
    
    /**
     * 
     * @param string $pipe
     * @return Feed
     * @throws Exception
     */
    public function run($pipe)
    {
        $pipes = $this->listPipes();
        if (!in_array($pipe, $pipes))
            throw new Exception('Unknown pipe');
        
        $config = Yaml::parse($this->pipesDir . '/' . $pipe . '.yml');
        $pipe = new Pipe($config);
        
        return $pipe->run();
    }
}
