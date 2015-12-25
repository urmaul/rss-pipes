<?php

namespace rsspipes;

abstract class View
{
    public static function run($pipesDir, $allowPhp = false)
    {
        mb_internal_encoding('UTF-8');

        $controller = new \rsspipes\Controller($pipesDir, $allowPhp);

        if (isset($_GET['pipe'])) {
            $feed = $controller->run($_GET['pipe']);
            
            $format = isset($_GET['format']) ? $_GET['format'] : 'rss';
            if ($format === 'json') {
                header('Content-Type: application/json');
                echo $feed->asJson();
                
            } else {
                header('Content-Type: application/rss+xml');
                echo $feed->asXml();
            }

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
