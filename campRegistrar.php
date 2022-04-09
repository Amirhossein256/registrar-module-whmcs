<?php

use Amirhossein256\Registrar\Api;
use Amirhossein256\Registrar\multiRegistrar;

include __DIR__ . "/vendor/autoload.php";

function campRegistrar_getConfigArray($params)
{
    return include __DIR__ . "/config.php";
}

function campRegistrar_RegisterDomain($vars)
{

    for ($i = 0; $i < 6; $i++) {
        if (!empty($vars['ns' . $i])) {
            $nameServers[] = $vars['ns' . $i];
        }
    }

    try {
        $api = new Api($vars['baseUrl']);
        $register = new multiRegistrar($vars['apiToken'], $api);

        $contact = [
            'email' => $vars['email'],
            'name' => $vars['fullname']
        ];

        $register->registerDomain($vars['domain_punycode'], $vars['regperiod'], $nameServers, $contact);
    } catch (\Throwable $e) {
        return [
            'error' => $e->getMessage()
        ];
    }
}

function campRegistrar_RenewDomain($vars)
{
    $api = new Api($vars['baseUrl']);
    $register = new multiRegistrar($vars['apiToken'], $api);

    $res = $register->renewDomain($vars['domain_punycode'], $vars['regperiod']);

    return $res;
}

function campRegistrar_TransferDomain($vars)
{

}

function campRegistrar_GetEPPCode($vars)
{

    return "12234564";
}

function campRegistrar_GetNameservers($vars)
{
    $api = new Api($vars['baseUrl']);
    $register = new multiRegistrar($vars['apiToken'], $api);

    try {
        $res = $register->whois($vars['domain_punycode']);
        $resArray = json_decode($res);
    } catch (\Throwable $e) {
        return [
            'error' => $e->getMessage()
        ];
    }

    return [
        'success' => true,
        "ns1" => $resArray->dns[0],
        "ns2" => $resArray->dns[1],
        "ns3" => $resArray->dns[2],
        "ns4" => $resArray->dns[3],
        "ns5" => $resArray->dns[4],
    ];
}

function campRegistrar_SaveNameservers($vars)
{
    $api = new Api($vars['baseUrl']);
    $register = new multiRegistrar($vars['apiToken'], $api);

    $dnsList = [
      $vars['ns1'],
      $vars['ns2'],
      $vars['ns3'],
      $vars['ns4'],
      $vars['ns5']
    ];
    $res = $register->updateDns($vars['domain_punycode'], $dnsList);

    file_put_contents(__DIR__ . '/log.json', json_encode($res));
    return array(
        'success' => true,
    );
}