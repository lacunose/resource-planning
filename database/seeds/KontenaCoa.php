<?php

use Illuminate\Database\Seeder;

use Ramsey\Uuid\Uuid;

use Lacunose\Finance\Models\Coa;
use Lacunose\Finance\Aggregates\CoaAggregateRoot;

class KontenaCoa extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		try {
			//ARTIKEL
			if (($handle = fopen(public_path('/2020/11/05/kontena_coa.csv'), 'r')) !== FALSE) 
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

						if(!empty($all_row['parent_code'])){
							$parent 			= Coa::where('code', $all_row['parent_code'])->firstorfail();
							$all_row['path']	= implode(',', array_filter([$parent->path, $all_row['code']]));
						}else{
							$all_row['path']	= $all_row['code'];
						}
						unset($all_row['no']);
						unset($all_row['parent_code']);

			            $id 	=  (string) Uuid::uuid4();

			            $data   = CoaAggregateRoot::retrieve($id)->update($all_row)->persist();

						\DB::commit();
					}catch(\Exception $e){
						\Log::info($e);
						dd($e->getMessage());
					}
				}
			} 
		}
		catch (\Exception $e) {
			dd($all_row);
			dd($e->errors());
		} 
	}
}
