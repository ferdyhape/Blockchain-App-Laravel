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
            'name' => 'Project',
        ],
        [
            'role' => 'Platinum Member', // Add this line
            'route' => null,
            'icon' => 'bx-bar-chart-alt-2',
            'name' => 'Stats',
        ],
    ];

    return $sidebarData;
}

function getBreadcrumb()
{
    $breadcrumb = [
        'User Project Management' => [
            [
                'route' => 'dashboard.user.project-management.index',
                'name' => 'Project',
                'level' => '1',
            ],
            [
                'route' => 'dashboard.user.project-management.create',
                'name' => 'Create Project',
                'level' => '2',
            ],
            [
                'route' => '#',
                'name' => 'Revise Project',
                'level' => '2',
            ],
            [
                'route' => '#',
                'name' => 'Show Project',

                'level' => '2',
            ],

        ],
        'Admin Project Management' => [
            [
                'route' => 'dashboard.admin.project-management.index',
                'name' => 'Project',
                'level' => '1',
            ],
            [
                'route' => '#',
                'name' => 'Show Project',
                'level' => '2',
            ],
        ],
        'Admin User Management' => [
            [
                'route' => 'dashboard.admin.user-management.index',
                'name' => 'Users',
                'level' => '1',
            ],
        ],
    ];

    return $breadcrumb;
}
