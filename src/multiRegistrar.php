<?php

namespace Amirhossein256\Registrar;

class multiRegistrar
{

    private $apiToken;
    private \Amirhossein256\Registrar\Api $api;


    public function __construct($apiToken, Api $api)
    {

        $this->apiToken = $apiToken;
        $this->api = $api;
    }

    /**
     * @param $domain
     * @param $period
     * @param array $dnsList
     * @param array $contact | ['email' => "", 'name' => ""]
     * @return mixed
     */
    public function registerDomain($domain, $period, array $dnsList, array $contact)
    {

        $params = [
            "domain" => $domain,
            "period" => $period,
            "dnsList" => $dnsList,
            "contact" => $contact
        ];

        return $this->api->request('post', '/domain/register', $this->getHeaders(), $params);
    }

    public function renewDomain($domain, $period)
    {

        $params = [
            "period" => $period,
        ];

        return $this->api->request('put', "/domain/{$domain}/renew", $this->getHeaders(), $params);
    }

    public function updateDns($domain, $dnsList)
    {

        $params = [
            "dnsList" => $dnsList
        ];

        return $this->api->request('put', "/domain/{$domain}/dns", $this->getHeaders(), $params);
    }

    public function getEpp($domain)
    {

        return $this->api->request('get', "/domain/{$domain}/epp", $this->getHeaders());
    }

    public function ManageInquiry($tackId)
    {

        return $this->api->request('get', "/manage/inquiry/$tackId", $this->getHeaders());
    }

    public function whois($domain)
    {

        return $this->api->request('get', "/domain/{$domain}", $this->getHeaders());
    }

    private function getHeaders()
    {
        return [
            "Authorization" => 'Bearer ' . $this->apiToken,
        ];
    }

}