<?php

if (!function_exists('array_pluck')) {
    function array_pluck($array, $field)
    {
        return array_map(function ($item) use ($field) {
            return $item[$field];
        }, $array);
    }
}

if (!function_exists('json_pretty')) {
    function json_pretty($obj)
    {
        return json_encode($obj, JSON_PRETTY_PRINT);
    }
}
