<?php
namespace Amirhossein256\Registrar;


class Api
{

    private \GuzzleHttp\Client $client;

    public function __construct($baseUrl, $timeOut = 2.0)
    {

        $this->client = new \GuzzleHttp\Client(
            [
                'base_uri' => $baseUrl,
                'timeout' => $timeOut
            ]
        );
    }


    public function request($method, $endPoint, $headers, $params = [])
    {

        $res = $this->client->request($method, $endPoint, $this->setRequestData($headers, $params));

        return $res->getBody()->getContents();

    }

    private function setRequestData($headers, $params)
    {
        $params = [
            'form_params' => $params
        ];
        $headers = [
            'headers' => $headers
        ];

        return array_merge($headers, $params);
    }


}