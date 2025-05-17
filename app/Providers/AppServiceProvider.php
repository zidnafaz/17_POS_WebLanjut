<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use App\Models\UserModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                if ($user instanceof UserModel) {
                    $role = $user->getRole();

                    $menus = [
                        // Navbar search & fullscreen
                        [
                            'type' => 'navbar-search',
                            'text' => 'search',
                            'topnav_right' => false,
                            'icon' => 'fas fa-fw fa-search',
                        ],
                        [
                            'type' => 'fullscreen-widget',
                            'topnav_right' => true,
                            'icon' => 'fas fa-fw fa-expand-arrows-alt',
                        ],

                        // Sidebar search
                        [
                            'type' => 'sidebar-menu-search',
                            'text' => 'search',
                            'icon' => 'fas fa-fw fa-search',
                        ],

                        // Profile Section
                        [
                            'type' => 'sidebar-profile',
                            'text' => $user->nama,
                            'url' => route('user.profile', $user->user_id),
                            'icon' => $user->profile_picture
                                ? asset('storage/profile_pictures/' . $user->profile_picture)
                                : asset('vendor/adminlte/dist/img/avatar.png'),
                            'username' => $user->username,
                            'role' => $user->level->level_nama ?? 'Tanpa Level'
                        ],

                        // Dashboard selalu tampil
                        [
                            'text' => 'Dashboard',
                            'url' => '/',
                            'icon' => 'fas fa-fw fa-tachometer-alt',
                        ],
                    ];

                    // Tambahkan menu sesuai role
                    if (in_array($role, ['ADM', 'MNG', 'STF'])) {
                        $menus[] = ['header' => 'Data Produk'];
                        $menus[] = [
                            'text' => 'Kategori Produk',
                            'url' => '/kategori',
                            'icon' => 'fas fa-fw fa-th-large',
                        ];
                        $menus[] = [
                            'text' => 'Daftar Produk',
                            'url' => '/products',
                            'icon' => 'fas fa-fw fa-cogs',
                        ];
                    }

                    if (in_array($role, ['ADM', 'MNG'])) {
                        $menus[] = ['header' => 'Data Suplier'];
                        $menus[] = [
                            'text' => 'Suplier',
                            'url' => '/suplier',
                            'icon' => 'fas fa-fw fa-box',
                        ];
                    }

                    if ($role === 'ADM') {
                        $menus[] = ['header' => 'Data User'];
                        $menus[] = [
                            'text' => 'Daftar User',
                            'url' => '/user',
                            'icon' => 'fas fa-fw fa-users',
                        ];
                        $menus[] = [
                            'text' => 'Level User',
                            'url' => '/level',
                            'icon' => 'fas fa-fw fa-user-cog',
                        ];
                    }

                    if (in_array($role, ['ADM', 'MNG', 'STF'])) {
                        $menus[] = ['header' => 'Data Transaksi'];
                        $menus[] = [
                            'text' => 'Stok Barang',
                            'url' => '/stok',
                            'icon' => 'fas fa-fw fa-cogs', // Ikon untuk Stok Barang
                        ];
                        $menus[] = [
                            'text' => 'Transaksi Penjualan',
                            'url' => '/penjualan',
                            'icon' => 'fas fa-fw fa-cash-register',
                        ];
                    }

                    // Logout selalu tampil
                    $menus[] = [
                        'text' => 'Logout',
                        'url' => 'logout',
                        'icon' => 'fas fa-fw fa-sign-out-alt',
                        'classes' => 'bg-danger',
                    ];

                    Config::set('adminlte.menu', $menus);
                }
            }
        });
    }
}
