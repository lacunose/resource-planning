<?php

use Illuminate\Database\Seeder;
use Illuminate\Validation\ValidationException;

use Ramsey\Uuid\Uuid;
use Lacunose\Warehouse\Models\Dock;
use Lacunose\Warehouse\Aggregates\DockAggregateRoot;
use Lacunose\Warehouse\Aggregates\RecipeAggregateRoot;

class VernonStore extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		$this->dock();
	}

	public function dock()
	{
		try {
			//ARTIKEL
			if (($handle = fopen(public_path('/2020/11/05/vernon_dock.csv'), 'r')) !== FALSE) 
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
							$parent 			= Dock::where('code', $all_row['parent_code'])->firstorfail();
							$all_row['dock_id']	= $parent->id;
						}

			            $id =  (string) Uuid::uuid4();

			            $data   = DockAggregateRoot::retrieve($id)
			                ->draft(\Arr::only($all_row, ['dock_id', 'name', 'code', 'type', 'threshold', 'unit']))
			                ->persist();

			            $data   = DockAggregateRoot::retrieve($id)
			                ->submit()
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
