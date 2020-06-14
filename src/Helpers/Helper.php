<?php
if ( !function_exists('env')) {
    function env($name, $default = '')
    {
        $value = getenv($name);
        if (empty($value)) {
            return $default;
        }
        return $value;
    }
}