<?php

namespace rsspipestests;

class ViewTest extends \PHPUnit_Framework_TestCase
{
    public function testListSmoke()
    {
        $pipesDir = __DIR__ . '/pipes';
        ob_start();
        \rsspipes\View::run($pipesDir);
        ob_end_clean();
    }
}
