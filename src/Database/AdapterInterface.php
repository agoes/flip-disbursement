<?php

namespace Flip\Database;

interface AdapterInterface
{
    public function buildDsn() : string;
    
    public function connect();
}