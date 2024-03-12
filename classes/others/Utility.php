<?php

namespace Classes\Others;

class Utility
{
    public static function moneyFormat($x)
    {
        return str_replace(',', '.', strval(number_format($x)));
    }
    public static function renderView(string $view, array $data = [])
    {
        $path = dirname(__DIR__, 2) . '/views/' . "{$view}.php";
        extract($data);
        
        require($path);
    }
}
