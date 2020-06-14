<?php
namespace Flip\Http\Request;

use Flip\Http\Response\ResponseStrategyInterface;

class Request
{
    private static $instance = null;
    private $baseUrl;
    private $httpClient;
    private $responseStrategy;

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

    public function setAuthentication(AuthenticationStrategyInterface $authentication) : self
    {
        $authentication->setAuthentication($this->httpClient);
        return $this;
    }

    public function setResponseStrategy(ResponseStrategyInterface $responseStrategy) : self
    {
        $this->responseStrategy = $responseStrategy;
        return $this;
    }

    private function getDefaultOptions() : array
    {
        return [
            CURLOPT_RETURNTRANSFER    => true,
        ];
    }

    public function get(string $path)
    {
        $this->initRequest($path);
        curl_setopt($this->httpClient, CURLOPT_HTTPGET, true);
        return $this->execute();
    }

    public function post(string $path, $requestBody = [])
    {
        $this->initRequest($path);
        curl_setopt($this->httpClient, CURLOPT_POSTFIELDS, $requestBody);
        return $this->execute();
    }

    private function execute()
    {
        $response = curl_exec($this->httpClient);
        return $this->responseStrategy->parse($response);
    }

    private function initRequest(string $path) : void
    {
        curl_setopt($this->httpClient, CURLOPT_URL, $this->buildUrl($path));
    }

    private function buildUrl(string $path) : string
    {
        return $this->baseUrl . $path;
    }
}