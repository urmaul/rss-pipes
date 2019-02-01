<?php

namespace rsspipes;

use Exception;
use rsspipes\rss\Feed;
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
        $pipes = array_diff(scandir($this->pipesDir), ['.', '..']);
        $pipes = array_filter($pipes, function(string $name) {
            $extensions = $this->allowPhp ? ['yml', 'php'] : ['yml'];
            return preg_match('~\.(' . implode('|', $extensions) . ')$~', $name);
        });
        $pipes = array_map(function (string $name) {
            return preg_replace('~\.(php|yml)$~', '', $name);
        }, $pipes);

        return array_values($pipes);
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
            return Yaml::parse(file_get_contents($filename . '.yml'));
            
        } elseif ($this->allowPhp && file_exists($filename . '.php')) {
            return include ($filename . '.php');
            
        } else {
            throw new Exception('Unknown pipe');
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
