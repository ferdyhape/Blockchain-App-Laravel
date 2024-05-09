<?php

use Illuminate\Routing\Route;


function toRp($money)
{
    return 'Rp ' . number_format($money, 0, ',', '.');
}


// function checkClassIsActive($route)
// {
//     $checkRequest = request()->routeIs($route);
//     return $checkRequest ? 'active' : '';
// }

function checkClassIsActive($routeNames, $class = 'active')
{
    if (is_array($routeNames)) {
        foreach ($routeNames as $routeName) {
            if (request()->routeIs($routeName)) {
                return $class;
            }
        }
    } elseif (is_string($routeNames)) {
        if (request()->routeIs($routeNames)) {
            return $class;
        }
    }

    return '';
}
