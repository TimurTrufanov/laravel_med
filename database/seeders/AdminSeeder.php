<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'адмін')->first();

        User::create([
                'email' => 'admin@admin.admin',
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'password' => Hash::make('admin@admin.admin'),
                'role_id' => $adminRole->id,
            ]
        );
    }
}
