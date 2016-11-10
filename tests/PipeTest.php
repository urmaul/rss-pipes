<?php

namespace rsspipestests;

use rsspipes\Pipe;

class PipeTest extends \PHPUnit_Framework_TestCase
{
    public function testNothing()
    {
        
    }
    
    /**
     * @expectedException rsspipes\sections\exceptions\InvalidConfigException
     */
    public function testInvalidSection()
    {
        new Pipe([['type' => 'invalid']]);
    }
}
