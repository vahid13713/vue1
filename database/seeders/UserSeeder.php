<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon; // Import Carbon for date manipulation

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Part 1: Create 3 admin users.
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

        // Part 2: Create 5 agent users.
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'name' => 'agent' . $i,
                'email' => 'agent' . $i . '@g.com',
                'password' => Hash::make('11111111'),
                'role' => 'agent',
                'parent_id' => 2,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Part 3: Create 200 new users with parent_id = 5 and specific creation dates.

        // --- THIS IS THE MODIFIED LINE ---
        // Set a fixed base date to 2025-11-10.
        $baseDate = Carbon::create(2025, 11, 10);

        for ($i = 1; $i <= 200; $i++) {
            $creationDate = null;

            if ($i <= 25) {
                // First 25 users: created exactly 15 days ago from the base date
                $creationDate = $baseDate->copy()->subDays(15);
            } elseif ($i <= 50) {
                // Next 25 users: created exactly 10 days ago from the base date
                $creationDate = $baseDate->copy()->subDays(10);
            } elseif ($i <= 75) {
                // Next 25 users: created exactly 5 days ago from the base date
                $creationDate = $baseDate->copy()->subDays(5);
            } else {
                // The remaining 125 users: created on the base date
                $creationDate = $baseDate->copy();
            }

            DB::table('users')->insert([
                'name' => 'seriesAuser' . $i,
                'email' => 'seriesAuser' . $i . '@g.com',
                'password' => Hash::make('11111111'),
                'role' => 'user',
                'parent_id' => 5,
                'email_verified_at' => $creationDate,
                'remember_token' => Str::random(10),
                'created_at' => $creationDate,
                'updated_at' => $creationDate,
            ]);
        }
    }
}
