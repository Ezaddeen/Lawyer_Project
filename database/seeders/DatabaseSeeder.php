<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء المستخدم أولاً
        $user = User::factory()->create([
            'name' => 'Admin User', // غيرنا الاسم ليكون أوضح
            'email' => 'admin@example.com', // غيرنا البريد الإلكتروني
            'password' => Hash::make('password'),
        ]);

        // منحه دور "super_admin"
        // هذا السطر هو الإضافة السحرية
        $user->assignRole('super_admin');
    }
}
