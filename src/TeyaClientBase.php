<?php 

namespace Ttimot24\TeyaPayment;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Ttimot24\TeyaPayment\TeyaClientException;

abstract class TeyaClientBase
{
    protected \Psr\Http\Client\ClientInterface $http;

    protected array $environments = [
        'sandbox' => 'https://test.borgun.is', 
        'production' => 'https://securepay.borgun.is'
    ];

    protected array $rules = [];

    protected array $defaultConfig = ['debug' => true, 'http_errors' => false];
    protected array $mergedConfig = [];

    public function __construct($config = [])   
    {

        $this->validateConfig($config);

        $this->mergedConfig = array_merge($this->defaultConfig, $config);
        $this->mergedConfig['base_uri'] = $this->getEnvironmentUri();
        $this->mergedConfig['allow_redirects'] = ['strict' => true];

        $this->configureLogging();
 
        $this->http = new \GuzzleHttp\Client($this->mergedConfig);
    }

    private function configureLogging(): void {

        if($this->getConfig('logger', null)){
            $this->mergedConfig['handler'] = HandlerStack::create();

            $this->mergedConfig['handler']->push(
                Middleware::log(
                    $this->getConfig('logger', null),
                    new MessageFormatter('{request} - {response}')
                )
            );
        }
    }

    public function hasConfig($key): bool {
        return array_key_exists($key, $this->mergedConfig);
    }

    public function getConfig($key = null, $default = null) {

        if($key && !$this->hasConfig($key)){
            return $default;
        }

        return $key? $this->mergedConfig[$key] : $this->mergedConfig;
    }

    public function setConfig($key, $value): void{
        $this->mergedConfig[$key] = $value; 
    }

    public function getEnvironments(): array {
        return $this->environments;
    }

    public function addEnvironment(string $namespace, string $url): void {
        $this->environments[$namespace] = $url;
    }

    public function getEnvironmentUri(): string {
        return $this->environments[$this->getConfig('environment')];
    }

    public function validateConfig($config): void {
        foreach($this->rules as $key){
            if(!array_key_exists($key, $config)){
                throw new TeyaClientException("Invalid configuration. Missing key: ".$key);
            }
        }
    }

    public function generateOrderId(): int
    {
        return time()+random_int(100000000000, 990000000000);
    }

}