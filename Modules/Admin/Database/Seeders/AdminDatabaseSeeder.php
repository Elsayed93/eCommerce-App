<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Entities\Admin;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Admin::create([
            'name' => 'super admin',
            'email' => 'super_admin@example.com',
            'password' => Hash::make('123456789'),
            'is_super' => true,
        ]);

        // $this->call("OthersTableSeeder");
    }
}
