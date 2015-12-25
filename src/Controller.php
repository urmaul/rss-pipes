<?php

namespace rsspipes;

use rich\collections\Strings;
use Symfony\Component\Yaml\Yaml;

class Controller
{
    private $allowPhp = false;
    
    private $pipesDir;
    
    public function __construct($pipesDir, $allowPhp = false)
    {
        $this->pipesDir = $pipesDir;
        $this->allowPhp = $allowPhp;
    }
    
    public function listPipes()
    {
        return Strings::from(scandir($this->pipesDir))
            ->diff(['.', '..'])
            ->filter(function($name) {
                $extensions = ['yml'];
                if ($this->allowPhp)
                    $extensions[] = 'php';
                return preg_match('~\.(' . implode('|', $extensions) . ')$~', $name);
            })
            ->replace('.yml', '')
            ->replace('.php', '')
            ->values();
    }
    
    /**
     * Reads pipe config from file.
     * @param string $pipe pipe name
     * @return array
     * @throws Exception
     */
    public function readConfig($pipe)
    {
        $filename = $this->pipesDir . '/' . $pipe;
        if (file_exists($filename . '.yml')) {
            return Yaml::parse($filename . '.yml');
            
        } elseif ($this->allowPhp && file_exists($filename . '.php')) {
            return include ($filename . '.php');
            
        } else {
            throw new \Exception('Unknown pipe');
        }
    }
    
    /**
     * 
     * @param string $pipe
     * @return Feed
     * @throws Exception
     */
    public function run($pipe)
    {
        $config = $this->readConfig($pipe);
        $pipe = new Pipe($config);
        return $pipe->run();
    }
}
