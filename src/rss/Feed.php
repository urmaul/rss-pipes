<?php

namespace rsspipes\rss;

use SimpleXMLElement;

use AntiMattr\Xml\XmlBuilder;

class Feed
{
    public $attributes = ['version' => '2.0'];
    public $namespaces = [];
    public $metadata = [];
    /**
     * @var Item[]
     */
    public $items = [];
    
    public function asXmlElement()
    {
        //$xml = new SimpleXMLElement('<rss/>');
        
        $builder = new XmlBuilder();
        $xml = $builder->setEncoding('UTF-8')->setRoot('rss')->create();
        
        foreach ($this->attributes as $key => $value) {
            $xml->addAttribute($key, $value);
        }
        
        $data = [];
        
        foreach ($this->metadata as $key => $val) {
            if (is_array($val)) {
                $data[] = [
                    '_name' => $key,
                    '_values' => $val,
                ];
            } else {
                $data[$key] = $val;
            }
        }
        
        foreach ($this->items as $item) {
            $data[] = [
                '_name' => 'item',
                '_values' => $item->getData(),
            ];
        }
        
        $builder->add($xml, [
            [
                '_name' => 'channel',
                '_values' => $data
            ],
        ]);
        
        return $xml;
    }
    
    public function asXml()
    {
        return $this->asXmlElement()->asXML();
    }
}
