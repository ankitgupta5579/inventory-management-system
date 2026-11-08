<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $attributes = [
            'name' => 'Test User',
            'password' => 'password',
        ];

        foreach ([
            'mobile' => '0000000000',
            'address' => 'Test address',
            'gender' => 'other',
        ] as $column => $value) {
            if (Schema::hasColumn('users', $column)) {
                $attributes[$column] = $value;
            }
        }

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            $attributes,
        );
    }
}
