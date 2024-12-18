<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
      $this->call([
          \Database\Seeders\AccountSeeder::class,
          \Database\Seeders\ContactSeeder::class,
          \Database\Seeders\CustomerSeeder::class,
          \Database\Seeders\InvoiceSeeder::class,
          \Database\Seeders\LineItemSeeder::class,
          \Database\Seeders\LocationSeeder::class,
          \Database\Seeders\PartSeeder::class,
          \Database\Seeders\RoleSeeder::class,
          \Database\Seeders\TaskSeeder::class,
          \Database\Seeders\UnitSeeder::class,
          \Database\Seeders\UserSeeder::class,
      ]);
  }
}
