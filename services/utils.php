<?php
function moneyFormat($x)
{
    return str_replace(',', '.', strval(number_format($x)));
}
