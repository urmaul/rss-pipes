<?php

namespace rsspipestests;

use rsspipes\Controller;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testListPipes()
    {
        $controller = new Controller(__DIR__ . '/pipes');
        
        $this->assertEquals(['first', 'second'], $controller->listPipes());
    }
    
    public function testListPipesWithPhp()
    {
        $controller = new Controller(__DIR__ . '/pipes', true);
        
        $this->assertEquals(['first', 'second', 'third'], $controller->listPipes());
    }
    
    public function testReadYamlConfig()
    {
        $controller = new Controller(__DIR__ . '/pipes');
        
        $actual = $controller->readConfig('first');
        
        $expected = [
            [
                'type' => 'atom',
                'url' => 'http://urmaul.com/atom.xml',
            ],
            [
                'type' => 'block',
                'rules' => [
                    'title' => 'Yii',
                ],
            ],
        ];
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @expectedException \Exception
     */
    public function testNotReadPhpConfig()
    {
        $controller = new Controller(__DIR__ . '/pipes');
        
        $controller->readConfig('third');
    }
    
    public function testReadPhpConfig()
    {
        $controller = new Controller(__DIR__ . '/pipes', true);
        
        $actual = $controller->readConfig('third');
        
        $expected = [
            [
                'type' => 'atom',
                'url' => 'http://urmaul.com/atom.xml',
            ],
            [
                'type' => 'block',
                'rules' => [
                    'title' => 'Yii',
                ],
            ],
        ];
        $this->assertEquals($expected, $actual);
    }
}
