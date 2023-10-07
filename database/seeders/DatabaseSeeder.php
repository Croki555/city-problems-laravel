<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            StatusSeeder::class,
            CategorySeeder::class,
        ]);
         \App\Models\User::factory(1)->create([
             'login'=> 'admin',
             'name' => 'Админ',
             'surname' => 'null',
             'email_verified_at' => null,
             'remember_token'=> null,
             'password'=> Hash::make('adminWSR'),
             'email' => 'admin@example.com',
             'is_admin'=> 1,
         ]);
    }
}
