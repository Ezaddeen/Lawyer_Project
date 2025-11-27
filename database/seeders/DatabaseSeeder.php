<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan; // <-- السطر الأول الجديد

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- الخطوة السحرية ---
        // تشغيل أمر إنشاء الأدوار والصلاحيات أولاً
        Artisan::call('shield:install --fresh'); // <-- السطر الثاني الجديد

        // الآن، قم بإنشاء المستخدم
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // الآن، قم بمنحه دور "super_admin" الذي تم إنشاؤه للتو
        $user->assignRole('super_admin');
    }
}
