<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// لا نحتاج Artisan هنا بعد الآن

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // سنقوم بإنشاء المستخدم فقط
        // سيتم منحه الدور يدوياً لاحقاً
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
