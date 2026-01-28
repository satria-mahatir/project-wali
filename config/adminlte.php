<?php

return [
    'title' => 'Wali Admin',
    'title_postfix' => ' | Panel Kendali',

    'google_fonts' => [
        'allowed' => true,
    ],

    'logo' => '<b>PROJECT</b> WALI',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-2',

    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,

    'classes_body' => 'accent-primary text-sm',
    'classes_content_wrapper' => 'bg-light',
    'classes_sidebar' => 'sidebar-dark-primary elevation-0 border-right',
    'classes_topnav' => 'navbar-white navbar-light border-bottom-0 shadow-sm',

    'use_route_url' => true,
    'dashboard_url' => 'dashboard',

    'laravel_asset_bundling' => false,
    'laravel_asset_mode' => 'vite',

    'menu' => [
        ['type' => 'sidebar-menu-search', 'text' => 'Cari fitur...'],
        ['header' => 'MENU UTAMA'],
        [
            'text' => 'Dashboard',
            'route'  => 'dashboard',
            'icon' => 'fas fa-fw fa-th-large',
        ],
        ['header' => 'MANAJEMEN PENGGUNA'],
        [
            'text' => 'Data Guru Wali',
            'route' => 'admin.guru', // HUBUNGAN KE ROUTE BARU
            'icon' => 'fas fa-fw fa-user-tie',
            'label' => 'HOT',
            'label_color' => 'primary',
        ],
        ['header' => 'PENGATURAN'],
        [
            'text' => 'Profil Saya',
            'url' => 'admin/settings',
            'icon' => 'fas fa-fw fa-user-circle',
        ],
    ],
];