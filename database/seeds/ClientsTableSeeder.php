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
            $clns	= config()->get('tsub.opsi.client');
            foreach ($clns as $name => $alias) {
                Artisan::call('passport:client', ['--password' => true, '--provider' => 'users', '--name' => $name]);
            }

            $key2 	= env('SECRET_TOGW01', 0);
            if($key2) {
	        	$k 	= DB::connection('system')->table('oauth_clients')->where('id', 2)->update(['secret' => $key2]);
            }

            $key3 	= env('SECRET_TOSW01', 0);
            if($key3) {
	        	$k 	= DB::connection('system')->table('oauth_clients')->where('id', 3)->update(['secret' => $key3]);
            }
		}
		catch (\Exception $e) {
			dd($e);
		} 
	}
}
