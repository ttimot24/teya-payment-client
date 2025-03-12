<?php 

namespace Ttimot24\TeyaPayment;

class TeyaClient
{
    private $http;

    private $defaultConfig = [
        'environment' => 'sandbox',
        ['headers' => ['Accept' => 'application/json']]
    ];

    private $production = 'https://borgun.is/rpgapi';
    private $sandbox = 'https://test.borgun.is/rpgapi';

    public function __construct($config = [])   
    {
        $mergedConfig = array_merge($this->defaultConfig, $config);

        $this->http = new \GuzzleHttp\Client($mergedConfig);
        $this->http->setDefaultOption('base_uri', $mergedConfig['environment'] == 'sandbox' ? $this->sandbox : $this->production);
    }

    public function payment(){
        $response = $this->http->post(trim("/api/payment"));

        return $response->getBody();
    }

    public function transaction($id){

        $response = $this->http->get(trim("/api/payment/$id"));

        return $response->getBody();
    }

    public function cancel(){
        
    }

    public function refund(){
        
    }

    public function capture(){
        
    }
}