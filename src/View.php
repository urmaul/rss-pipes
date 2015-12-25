<?php

namespace rsspipes;

abstract class View
{
    public static function run($pipesDir, $allowPhp = false)
    {
        mb_internal_encoding('UTF-8');

        $controller = new \rsspipes\Controller($pipesDir, $allowPhp);

        if (isset($_GET['pipe'])) {
            echo $controller->run($_GET['pipe'])->asXml();

        } else {
            $links = array_map(function($name){
                return sprintf(
                    '<li><a href="?pipe=%s">%s</a></li>',
                    $name, ucfirst($name)
                );
            }, $controller->listPipes());

            echo '<ul>' . implode('', $links) . "</ul>\n";
        }
    }
}
