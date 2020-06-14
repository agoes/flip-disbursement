<?php
namespace Flip\Http\Response;

interface ResponseStrategyInterface
{
    public function parse(string $responseBody);
}