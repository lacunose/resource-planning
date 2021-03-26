<?php

use Illuminate\Database\Seeder;
use Illuminate\Validation\ValidationException;

use Ramsey\Uuid\Uuid;
use Lacunose\Sale\Models\Product;
use Lacunose\Sale\Aggregates\CatalogAggregateRoot;

class NakoaSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		$this->catalog();
	}

	public function catalog()
	{
		try {
			//ARTIKEL
			if (($handle = fopen(public_path('/2020/11/05/nakoa_catalog.csv'), 'r')) !== FALSE) 
			{
				$header         = null;

				while (($data = fgetcsv($handle, 500, ",")) !== FALSE) 
				{
					if ($header === null) 
					{
						$header = $data;
						continue;
					}

					$all_row    = array_combine($header, $data);
					try {
						if(empty($all_row['code'])){
							// \Log::info($all_row['no']);
							break;
						}

						\DB::beginTransaction();

						$prod	= Product::where('code', $all_row['code'])->first();
			            $id 	=  (string) Uuid::uuid4();
						if($prod){
							$id = $prod->uuid;
						}

			            $vars 	= [];

			            if(in_array($all_row['code'], ['BT', 'TM'])) {
			            	$vars= [[
			            		'code'			=> $all_row['code'].'H-L',
			            		'name'			=> 'Honey',
			            		'extra_price'	=> 0,
			            	],[
			            		'code'			=> $all_row['code'].'L-L',
			            		'name'			=> 'Lychee',
			            		'extra_price'	=> 0,
			            	],[
			            		'code'			=> $all_row['code'].'M-L',
			            		'name'			=> 'Mango',
			            		'extra_price'	=> 0,
			            	],[
			            		'code'			=> $all_row['code'].'P-L',
			            		'name'			=> 'Peach',
			            		'extra_price'	=> 0,
			            	],];
			            }elseif(!Str::is('*-L*', $all_row['code'])){
			            	$vars= [[
			            		'code'			=> $all_row['code'].'-R',
			            		'name'			=> 'Regular',
			            		'extra_price'	=> 0,
			            	],[
			            		'code'			=> $all_row['code'].'-L',
			            		'name'			=> 'Large',
			            		'extra_price'	=> 3000,
			            	],[
			            		'code'			=> $all_row['code'].'-H',
			            		'name'			=> 'Hot',
			            		'extra_price'	=> 0,
			            	],];
			            }

			            $input 	= [
			            	'name'	=> $all_row['name'],
			            	'code'	=> $all_row['code'],
			            	'group'	=> $all_row['group'],
			            	'price'	=> $all_row['price'],
			            	'galleries'	=> [[
			            		'title'	=> 'thumbnail',
			            		'url'	=> 'https://scontent-sin6-2.cdninstagram.com/v/t51.2885-15/e35/s1080x1080/124194335_151171136744756_3720304063819690401_n.jpg?_nc_ht=scontent-sin6-2.cdninstagram.com&_nc_cat=108&_nc_ohc=cbCzVkx1B9oAX9tUiqK&tp=1&oh=cd3ad63cfbff3dfb05ce86eaaacaf0e7&oe=60141131',
			            	]]
			            ];
			            $data   = CatalogAggregateRoot::retrieve($id)
			                ->save($input)
			                ->updateVarian($vars)
			                ->publish((string)now(), null)
			                ->persist();

						\DB::commit();
					}catch(\Exception $e){
						\Log::info($e);
						dd($e->getMessage());
					}
				}
			} 
		}
		catch (ValidationException $e) {
			dd($all_row);
			dd($e->errors());
		} 
	}
}
