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
    public static function validatePhoneNumber($phone)
    {
        if (preg_match('/^[0-9]*$/', $phone)) {
            return  true;
        } else {
            return  false;
        }
    }

    public static function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
}
