<?php
namespace Flip\Http\Request;

class Request
{
    private static $instance = null;
    private $baseUrl;
    private $httpClient;

    private function __construct() {
        $this->httpClient = curl_init();
        curl_setopt_array(
            $this->httpClient, 
            $this->getDefaultOptions()
        );
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
 
        return self::$instance;
    }

    public function setBaseUrl(string $baseUrl) : self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function setAuthentication(AuthenticationStrategyInterface $authentication)
    {
        $authentication->setAuthentication($this->httpClient);
    }

    private function getDefaultOptions() : array
    {
        return [
            CURLOPT_RETURNTRANSFER    => true,
        ];
    }

    public function get(string $path) : string
    {
        $this->initRequest($path);
        return $this->executeAndClose();
    }

    public function post(string $path, $requestBody = []) : string
    {
        $this->initRequest($path);
        curl_setopt($this->httpClient, CURLOPT_POSTFIELDS, $requestBody);
        return $this->executeAndClose();
    }

    private function executeAndClose() : string
    {
        $response = curl_exec($this->httpClient);
        curl_close($this->httpClient);
        return $response;
    }

    private function initRequest(string $path) : void
    {
        curl_setopt($this->httpClient, CURLOPT_URL, $this->buildUrl($path));
    }

    private function buildUrl(string $path) : string
    {
        return str_replace('//', '/', $this->baseUrl . $path);
    }
}