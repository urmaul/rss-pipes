<?php

namespace rsspipestests;

use rsspipes\Pipe;

class PipeTest extends \PHPUnit_Framework_TestCase
{
    public function testNothing()
    {
        
    }
    
    /**
     * @expectedException rsspipes\sections\Exception
     */
    public function testInvalidSection()
    {
        new Pipe([['type' => 'invalid']]);
    }
}
