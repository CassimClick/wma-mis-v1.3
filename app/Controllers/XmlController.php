<?php

namespace App\Controllers;

use LSS\Array2XML;
use SimpleXMLElement;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Controllers\BaseController;


class XmlController extends BaseController
{
    public function index()
    {
        $client = new Client();
        $url = 'http://restapi.adequateshop.com/api/Traveler?page=1';
        $response = $client->get($url);


        $data = new SimpleXMLElement($response->getBody());
        echo '<pre>';
        //print_r($data->travelers);
        echo '</pre>';
        $travelers = $data->travelers->Travelerinformation;

        $tr = '';
        foreach ($travelers as $traveler) {
            $tr .= <<<"HTML"
               <tr>
                    <td> $traveler->name</td>
                    <td> $traveler->email</td>
                    <td> $traveler->adderes</td>
                </tr>
             HTML;
        }
        $html = <<<"HTML"
         <table class="table" border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
               $tr
                
            </tbody>
         </table>
         HTML;

        echo $html;
    }

    public function toXml()
    {
        $array = [
            'name' => 'Morgan',
            'email' => 'morgan@gmail.com',
            'adderes' => 'Njiro Arusha',
            'Books' => [
                'bookName' => 'Sky Diving',
                'price' => 54.99,
                'author' => [
                    'authorName' => 'Sam Banks',
                    'year' => 2021
                ]
            ]
        ];

        // Use the Array2XML object to transform it.
        $xml = Array2XML::createXML('Travelerinformation', $array)->saveXML();
        $data = $this->xmlLibrary->arrayToXml($array, 'Travelerinformation');

        // echo $data;
        // print_r($this->xmlLibrary->xmlToArray($array));
        $arr = $this->xmlLibrary->xmlToArray($data);
        return $this->xmlLibrary->xmlToJson($xml);
        // printer($arr);
        return $this->response->setJSON([]);

    }

    public function fileContent()
    {
        echo file_get_contents(base_url('signature/demo.txt'));
         
    }


    public function xml()
    {

        // Code to convert php array to xml document



        // Creating an array for demo
        $array = [
            'name' => 'Salma Doe',
            'email' => numString(3) . 'salma@gmail.com',
            'adderes' => 'Majengo Arusha',
            // 'Books' =>[
            //     'bookName' => 'Sky Diving',
            //     'price' => 54.99,
            //     'author'=>[
            //         'authorName' => 'Sam Banks',
            //         'year' => 2021
            //     ]
            // ]

        ];


        $data = $this->xmlLibrary->arrayToXml($array, 'Travelerinformation');
        // $data = Array2XML::createXML('Travelerinformation', $array)->saveXML();

        $client = new Client();
        $url = 'http://restapi.adequateshop.com/api/Traveler';
        $headers =  [
            'Content-Type' => 'text/xml',
        ];

        $response =  $client->request('POST', $url, [
            'headers' => $headers,
            'body' =>  $data
        ]);
        echo $response->getBody();
    }

    public function xmlPost()
    {
        $client = new Client();

        // Prepare Request
        $request = new Request('POST', 'http://restapi.adequateshop.com/api/Traveler');
        $x = numString(3);
        $array = [
            'name' => 'Morgan',
            'email' => "morgan $x @gmail.com",
            'adderes' => 'Njiro Arusha',
        ];

        // Send Request
        $response = $client->send($request, [
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
            'body' => Array2XML::createXML('Travelerinformation', $array)->saveXML()
        ]);

        // Read Response
        $response_body = $response->getBody();
        // echo $response_body;

        return $this->xmlLibrary->xmlToJson($response_body);


        // $xml = new SimpleXMLElement($response_body);
        // $xx = (object)$xml;
        // printer($xx);
    }
}
