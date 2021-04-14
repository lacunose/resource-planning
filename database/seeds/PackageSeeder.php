<?php

use Illuminate\Database\Seeder;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

use Lacunose\Subscribe\Models\Price;
use Lacunose\Subscribe\Aggregates\PackageAggregateRoot;

class PackageSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		try {
			$domains 	= ['tsale', 'tcust', 'twh', 'tmf', 'tproc', 'tfin', 'tswirl'];
			$scopes 	= [];

			foreach ($domains as $dom) {
				$scopes	= array_merge(array_keys(config()->get($dom.'.scopes')), $scopes);
            }

           	$inp1 = [
           		'title'			=> 'Pro Plus', 
           		'membership'	=> 'professional', 
           		'period'		=> 'monthly', 
           		'contract'		=> [
           			['flag'		=> 'feature', 'description' => 'Trial', 'amount' => 10000],
           		], 
           		'scopes'		=> $scopes, 
           		'clients'		=> array_keys(config()->get('tsub.opsi.client')), 
           		'description'	=> [
           			['spec'		=> 'Hosting', 'desc' => 'Shared'],
           			['spec'		=> 'Access', 'desc' => 'Shared'],
           			['spec'		=> 'Help Desk', 'desc' => '8/5'],
           		],
           	];

           	$inp2 = [
           		'title'			=> 'SSH', 
           		'membership'	=> 'exclusive', 
           		'period'		=> 'monthly', 
           		'contract'		=> [
           			['flag'		=> 'feature', 'description' => 'Trial', 'amount' => 10000],
           		], 
           		'scopes'		=> $scopes, 
           		'clients'		=> array_keys(config()->get('tsub.opsi.client')), 
           		'description'	=> [
           			['spec'		=> 'Hosting', 'desc' => 'VPS'],
           			['spec'		=> 'Access', 'desc' => 'VPS'],
           			['spec'		=> 'Help Desk', 'desc' => '8/5'],
           		],
           	];

           	$pack1 	= Price::where('title', $inp1['title'])->first();
           	$pack2 	= Price::where('title', $inp2['title'])->first();

	        $id1	= $pack1 ? $pack1->uuid : (string) Uuid::uuid4();
	        $id2	= $pack2 ? $pack2->uuid : (string) Uuid::uuid4();

           	DB::beginTransaction();
            $dt   	= PackageAggregateRoot::retrieve($id1)->save($inp1)->publish(now()->format('Y-m-d'))->persist();
            $dt   	= PackageAggregateRoot::retrieve($id2)->save($inp2)->publish(now()->format('Y-m-d'))->persist();
            DB::commit();
		}
		catch (\Exception $e) {
			dd($e);
		} 
	}
}
