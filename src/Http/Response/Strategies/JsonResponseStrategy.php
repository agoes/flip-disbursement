<?php
namespace Flip\Http\Response\Strategies;

use Flip\Http\Response\ResponseStrategyInterface;

class JsonResponseStrategy implements ResponseStrategyInterface
{
    public function parse(string $responseBody)
    {
        return json_decode($responseBody);
    }
}