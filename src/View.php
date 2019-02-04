<?php

namespace rsspipes;

use rsspipes\builder\JsonBuilder;
use rsspipes\builder\RssBuilder;

abstract class View
{
    public static function run($pipesDir, $allowPhp = false)
    {
        mb_internal_encoding('UTF-8');

        $controller = new \rsspipes\Controller($pipesDir, $allowPhp);

        if (isset($_GET['pipe'])) {
            $feed = $controller->run($_GET['pipe']);
            
            $format = isset($_GET['format']) ? $_GET['format'] : 'rss';
            $builder = $format === 'json' ? new JsonBuilder() : new RssBuilder();
            $contentType = $builder->getContentType();
            header("Content-Type: $contentType; charset=utf-8");
            echo $builder->buildFeed($feed);

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
