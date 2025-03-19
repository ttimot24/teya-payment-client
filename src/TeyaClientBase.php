<?php 

namespace Ttimot24\TeyaPayment;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Ttimot24\TeyaPayment\TeyaClientException;

abstract class TeyaClientBase
{
    protected $http;

    protected $environments = [
        'sandbox' => 'https://test.borgun.is', 
        'production' => 'https://borgun.is'
    ];

    protected $rules = [];

    protected $defaultConfig = ['debug' => true, 'http_errors' => false];
    protected $mergedConfig = [];

    public function __construct($config = [])   
    {

        $this->validateConfig($config);

        $this->mergedConfig = array_merge($this->defaultConfig, $config);
        $this->mergedConfig['base_uri'] = $this->getEnvironmentUri();
        $this->mergedConfig['allow_redirects'] = ['strict' => true];

        $this->configureLogging();
 
        $this->http = new \GuzzleHttp\Client($this->mergedConfig);
    }

    private function configureLogging(){

        if($this->getConfig('log_enabled', false)){
            $this->mergedConfig['handler'] = HandlerStack::create();

            $logger = new Logger('Teya HTTP Client');
            $logger->pushHandler(new StreamHandler($this->getConfig('log_file', 'teya.log')), \Monolog\Level::fromName($this->getConfig('log_level','info')));

            $this->mergedConfig['handler']->push(
                Middleware::log(
                    $logger,
                    new MessageFormatter('{request} - {response}')
                )
            );
        }

    }

    public function hasConfig($key){
        return array_key_exists($key, $this->mergedConfig);
    }

    public function getConfig($key = null, $default = null){

        if($key && !$this->hasConfig($key)){
            return $default;
        }

        return $key? $this->mergedConfig[$key] : $this->mergedConfig;
    }

    public function getEnvironments(): array {
        return $this->environments;
    }

    public function addEnvironment(string $namespace, string $url): void {
        $this->environments[$namespace] = $url;
    }

    public function getEnvironmentUri(){
        return $this->environments[$this->getConfig('environment')];
    }

    public function validateConfig($config){
        foreach($this->rules as $key){
            if(!array_key_exists($key, $config)){
                throw new TeyaClientException("Invalid configuration. Missing key: ".$key);
            }
        }
    }

}