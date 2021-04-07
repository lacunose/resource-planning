<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(PackageSeeder::class);
        // $this->call(VernonStore::class);
        // $this->call(NakoaSeeder::class);
        // $this->call(KontenaCoa::class);
    }
}
