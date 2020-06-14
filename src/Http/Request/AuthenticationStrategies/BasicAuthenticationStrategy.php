<?php
namespace Flip\Http\Request\AuthenticationStrategies;

use Flip\Http\Request\AuthenticationStrategyInterface;

class BasicAuthenticationStrategy implements AuthenticationStrategyInterface
{
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function setAuthentication($httpClient) : void
    {
        curl_setopt($httpClient, CURLOPT_USERPWD, $this->username . ':' . $this->password);  
    }
}
