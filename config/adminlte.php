<?php

return [
    'title' => 'Wali Admin',
    'title_postfix' => ' | Panel Kendali',

    'logo' => '<b>PROJECT</b> WALI',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',

    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,

    // AKTIFKAN FITUR DARK MODE DI SINI
    'layout_dark_mode' => true,

    'classes_body' => 'accent-primary text-sm',
    'classes_sidebar' => 'sidebar-dark-primary elevation-0 border-right',
    'classes_topnav' => 'navbar-expand navbar-dark navbar-gray-dark',

    'menu' => [
        ['header' => 'MENU UTAMA'],
        [
            'text' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'fas fa-fw fa-th-large',
        ],
        [
            'text' => 'Manajemen Guru',
            'route' => 'admin.guru',
            'icon' => 'fas fa-fw fa-user-plus',
        ],

        ['header' => 'PENGATURAN'],
        [
            'text' => 'Profil Saya',
            'route' => 'admin.profile',
            'icon' => 'fas fa-fw shadow-sm fa-user',
        ],
        [
            'text' => 'Lihat Website',
            'url' => '/',
            'icon' => 'fas fa-fw fa-globe',
            'topnav_right' => true,
        ],
    ],
];
