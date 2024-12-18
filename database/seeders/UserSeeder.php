<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('secret'),
            'isOwner' => true,
        ]);

        $user->accounts()->sync([1]);

        User::factory()->count(5)->create();
    }
}
