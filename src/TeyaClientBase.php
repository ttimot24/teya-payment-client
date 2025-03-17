<?php 

namespace Ttimot24\TeyaPayment;

use Ttimot24\TeyaPayment\TeyaClientException;

class TeyaClientBase
{
    protected $http;

    protected $environments = [
        'sandbox' => 'https://test.borgun.is', 
        'production' => 'https://borgun.is'
    ];

    protected $rules = [];

    protected $defaultConfig = [];
    protected $mergedConfig = [];

    public function __construct($config = [])   
    {

        $this->validateConfig($config);

        $this->mergedConfig = array_merge($this->defaultConfig, $config);
        $this->mergedConfig['base_uri'] = $this->getEnvironmentUri();

        $this->http = new \GuzzleHttp\Client($this->mergedConfig);
    }

    public function getConfig($key){
        return $key? $this->mergedConfig[$key] : $this->mergedConfig;
    }

    public function getEnvironments(): array {
        return $this->environments;
    }

    public function addEnvironment(string $namespace, string $url): void {
        $this->environments[$namespace] = $url;
    }

    public function getEnvironmentUri(){
        return $this->environments[$this->mergedConfig['environment']];
    }

    public function validateConfig($config){
        foreach($this->rules as $key){
            if(!array_key_exists($key, $config)){
                throw new TeyaClientException("Invalid configuration. Missing key: ".$key);
            }
        }
    }

}