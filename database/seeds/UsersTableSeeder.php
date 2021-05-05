<?php

use Illuminate\Database\Seeder;
use Illuminate\Validation\ValidationException;

use Ramsey\Uuid\Uuid;
use Lacunose\Acl\Aggregates\UserAggregateRoot;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		try {
			$id     =  (string) Uuid::uuid4();
            $data   = UserAggregateRoot::retrieve($id)
                    ->register([
                    	'name' 		=> 'Chelsy', 
                    	'email' 	=> 'chelsy@thunderlab.id', 
                    	'password'	=> 'admin123',
                    	'level'		=> 'thunder',
                    	'scopes'	=> array_keys(array_merge(config()->get('tacl.scopes'), config()->get('tsub.scopes'))),
                    ])->persist();

			$id     =  (string) Uuid::uuid4();
            $data   = UserAggregateRoot::retrieve($id)
                    ->register([
                    	'name' 		=> config()->get('tswirl.bot.name'), 
                    	'email' 	=> config()->get('tswirl.bot.email'), 
                    	'password'	=> 'tlabGo!!!',
                    	'level'		=> 'thunder',
                    	'scopes'	=> array_keys(config()->get('tacl.scopes')),
                    ])->persist();
		}
		catch (\Exception $e) {
			dd($e);
		} 
	}
}
