<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Domain\Auth\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

         User::factory()->create([
             'first_name' => 'Sami',
             'last_name'  => 'Maxhuni',
             'email' => 'samimaxhuni@example.com',
             'password' => 'Kosova123'
         ]);
    }
}
