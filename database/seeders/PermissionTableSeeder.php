<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissions
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'cabang-list',
            'cabang-create',
            'cabang-edit',
            'cabang-delete',
            'pelanggan-list',
            'pelanggan-create',
            'pelanggan-edit',
            'pelanggan-delete',
            'produk-list',
            'produk-create',
            'produk-edit',
            'produk-delete',
            'pembelian-list',
            'pembelian-create',
            'pembelian-edit',
            'pembelian-delete',
            'penjualan-list',
            'penjualan-create',
            'penjualan-edit',
            'penjualan-delete',
            'rekapbon-list',
            'rekapbon-create',
            'rekapbon-edit',
            'rekapbon-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
