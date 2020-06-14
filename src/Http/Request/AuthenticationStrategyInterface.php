<?php
namespace Flip\Http\Request;

interface AuthenticationStrategyInterface
{
    public function setAuthentication($httpClient) : void;
}