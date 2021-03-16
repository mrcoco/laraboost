<?php


namespace App\Lib;


use GuzzleHttp\Client;

class SiakadService
{
    private $url;
    private $method;
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getData($method, $params)
    {
        $req = new Client();
    }


}