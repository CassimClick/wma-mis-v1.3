<?php

namespace App\Libraries;

use SimpleXMLElement;

class XmlLibrary
{

    public $response;
    public function __construct()
    {
        $this->response = \Config\Services::response();
    }


    function arrayToXml($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml;

        // If there is no Root Element then insert root
        if ($_xml === null) {
            $_xml = new SimpleXMLElement("<$rootElement/>");
        }

        // Visit all key value pair
        foreach ($array as $k => $v) {

            // If there is nested array then
            if (is_array($v)) {

                // Call function for nested array
                $this->arrayToXml($v, $k, $_xml->addChild($k));
            } else {

                $_xml->addChild($k, $v);
            }
        }
        return str_replace('<?xml version="1.0"?>', '<?xml version="1.0" encoding="UTF-8"?>', $_xml->asXML());
       
    }

    //=================converting xml to an array====================
    public function xmlToArray($xml): array
    {
        return (array)new SimpleXMLElement($xml);
    }

    //=================converting xml to Json Object====================
    public function xmlToJson($xml)
    {
        return $this->response->setJSON([new SimpleXMLElement($xml)]);
    }
}
