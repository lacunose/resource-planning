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
<<<<<<< HEAD
        $this->call(PackageSeeder::class);
=======
        // $this->call(PackageSeeder::class);
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
    }
}
