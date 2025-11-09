<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ایجاد 3 کاربر ادمین
        for ($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                'name' => 'admin' . $i,
                'email' => 'admin' . $i . '@g.com',
                'password' => Hash::make('11111111'),
                'role' => 'admin',
                'parent_id' => 1,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ایجاد 5 کاربر نماینده
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'name' => 'agent' . $i,
                'email' => 'agent' . $i . '@g.com',
                'password' => Hash::make('11111111'),
                'role' => 'agent',
                'parent_id' => 2, // در صورت نیاز می‌توانید مقدار parent_id را تنظیم کنید
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ایجاد 40 کاربر عادی
        for ($i = 1; $i <= 100; $i++) {
            $parentId = 0;
            if ($i <= 10) {
                $parentId = 2;
            } elseif ($i <= 20) {
                $parentId = 3;
            } elseif ($i <= 30) {
                $parentId = 4;
            } else {
                $parentId = 5;
            }
            DB::table('users')->insert([
                'name' => 'user' . $i,
                'email' => 'user' . $i . '@g.com',
                'password' => Hash::make('11111111'),
                'role' => 'user',
                'parent_id' => $parentId, // در صورت نیاز می‌توانید مقدار parent_id را تنظیم کنید
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
