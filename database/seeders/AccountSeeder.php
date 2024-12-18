<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account = Account::create(['name' => 'Acme Corporation']);

        Account::factory()->count(5)->create();
    }
}
