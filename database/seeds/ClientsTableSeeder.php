<?php

use Illuminate\Database\Seeder;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Artisan;

class ClientsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		try {
            $clients    = config()->get('tsub.opsi.client');
            foreach ($clients as $name => $alias) {
                Artisan::call('passport:client', ['--password' => true, '--provider' => 'users', '--name' => $name]);
            }
		}
		catch (\Exception $e) {
			dd($e);
		} 
	}
}
