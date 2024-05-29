<?php

use Illuminate\Routing\Route;


function toRp($money)
{
    return 'Rp ' . number_format($money, 0, ',', '.');
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
        [
            'role' => 'Admin', // Add this line
            'route' => 'dashboard.admin.index',
            'icon' => 'bx-home',
            'name' => 'Dashboard',
        ],
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
            'role' => 'Platinum Member', // Add this line
            'route' => 'dashboard.user.index',
            'icon' => 'bx-home',
            'name' => 'Dashboard',
        ],
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
    ];

    return $sidebarData;
}
