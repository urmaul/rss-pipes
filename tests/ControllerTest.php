<?php

namespace rsspipestests;

use rsspipes\Controller;

class PipeTest extends \PHPUnit_Framework_TestCase
{
    public function testListPipes()
    {
        $controller = new Controller(__DIR__ . '/pipes');
        
        $this->assertEquals(['first', 'second'], $controller->listPipes());
    }
}
