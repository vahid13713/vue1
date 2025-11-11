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

        // Part 3: Create users for each parent_id from 2 to 5.
        // --- THIS IS THE MODIFIED PART ---

        // Set a fixed base date to 2025-11-10.
        $baseDate = Carbon::create(2025, 11, 10);

        // Outer loop to iterate through parent_ids from 2 to 9.
        for ($parentId = 2; $parentId <= 5; $parentId++) {
            // Inner loop to create 125 users for the current parent_id.
            for ($i = 1; $i <= 125; $i++) {
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
                    // The remaining users: created on the base date
                    $creationDate = $baseDate->copy();
                }

                DB::table('users')->insert([
                    'name' => 'user_parent' . $parentId . '_num' . $i,
                    'email' => 'user_parent' . $parentId . '_num' . $i . '@g.com',
                    'password' => Hash::make('11111111'),
                    'role' => 'user',
                    'parent_id' => $parentId, // Use the parentId from the outer loop
                    'email_verified_at' => $creationDate,
                    'remember_token' => Str::random(10),
                    'created_at' => $creationDate,
                    'updated_at' => $creationDate,
                ]);
            }
        }
    }
}
