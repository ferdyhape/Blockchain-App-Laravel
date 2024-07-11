<?php

use Carbon\Carbon;
use Illuminate\Routing\Route;


function toRp($money)
{
    return 'Rp ' . number_format($money, 0, ',', '.');
}

function getPriceToken()
{
    return 100000;
}


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

function getSidebarData()
{
    $sidebarData = [
        // [
        //     'role' => 'Admin', // Add this line
        //     'route' => 'dashboard.admin.index',
        //     'icon' => 'bx-home',
        //     'name' => 'Dashboard',
        // ],
        [
            'role' => 'Admin', // Add this line
            'route' => 'dashboard.admin.user-management.index',
            'icon' => 'bx-user',
            'name' => 'Users',
        ],
        [
            'role' => 'Admin', // Add this line
            'route' => 'dashboard.admin.project-management.index',
            'icon' => 'bx-folder',
            'name' => 'Project',
        ],
        [
            'role' => 'Admin', // Add this line
            'route' => 'dashboard.admin.transaction.index',
            'icon' => 'bx-transfer',
            'name' => 'Token Transaction',
        ],
        [
            'role' => 'Admin', // Add this line
            'route' => 'dashboard.admin.wallet-transaction.index',
            'icon' => 'bx-wallet',
            'name' => 'Wallet Topup',
        ],
        [
            'role' => 'Admin', // Add this line
            'route' => 'dashboard.admin.payment-method.index',
            'icon' => 'bx-credit-card',
            'name' => 'Payment Method',
        ],
        // [
        //     'role' => 'Platinum Member', // Add this line
        //     'route' => 'dashboard.user.index',
        //     'icon' => 'bx-home',
        //     'name' => 'Dashboard',
        // ],
        [
            'role' => 'Platinum Member', // Add this line
            'route' => 'dashboard.user.project-management.index',
            'icon' => 'bx-folder',
            'name' => 'My Project',
        ],
        [
            'role' => 'Platinum Member', // Add this line
            'route' => 'dashboard.user.available-project.index',
            'icon' => 'bx-bar-chart-alt-2',
            'name' => 'Available Projects',
        ],
        [
            'role' => 'Platinum Member', // Add this line
            'route' => 'dashboard.user.transaction.index',
            'icon' => 'bx-transfer',
            'name' => 'My Transaction',
        ],
        [
            'role' => 'Platinum Member', // Add this line
            'route' => 'dashboard.user.token.index',
            'icon' => 'bx-coin-stack',
            'name' => 'My Token',
        ],
        [
            'role' => 'Platinum Member', // Add this line
            'route' => 'dashboard.user.my-wallet.index',
            'icon' => 'bx-wallet',
            'name' => 'My Wallet',
        ]
    ];

    return $sidebarData;
}

function diffForHumansFromString($datetime)
{
    $date = Carbon::parse($datetime);
    return $date->diffForHumans();
}


function getBankTransferList()
{
    $data = [
        'Bank Mandiri',
        'Bank BCA',
        'Bank BNI',
        'Bank BRI',
        'Bank CIMB Niaga',
        'Bank Danamon',
        'Bank Permata',
        'Bank Panin',
        'Bank OCBC NISP',
        'Bank Maybank',
    ];
    return $data;
}
