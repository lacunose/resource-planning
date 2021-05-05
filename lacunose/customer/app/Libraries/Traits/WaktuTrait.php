<?php

namespace Lacunose\Customer\Libraries\Traits;

use Carbon\Carbon;

/**
 * Trait tanggal
 *
 * Digunakan untuk reformat tanggal sesuai Keuntungan
 *
 * @program    Thunderlabid
 * @subprogram Credit
 * @author     C Mooy <chelsy@thunderlab.od>
 */
trait WaktuTrait {

 	/**
	 * parse input tanggal
	 * @param d/m/Y H:i $value 
	 * @return Y-m-d H:i:s $value 
	 */
	public function formatDateTimeFrom($value){
		if(is_null($value)){
			return null;
		}
		return Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s');
	}

	/**
	 * parse output tanggal
	 * @param Y-m-d H:i:s $value 
	 * @return d/m/Y H:i $value 
	 */
	public function formatDateTimeTo($value)
	{
		if(is_null($value)){
			return null;
		}
		return Carbon::parse($value)->format('d/m/Y H:i');
	}


 	/**
	 * parse input tanggal
	 * @param d/m/Y $value 
	 * @return Y-m-d $value 
	 */
	public function formatDateFrom($value)
	{
		return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d H:i:s');
	}

	/**
	 * parse output tanggal
	 * @param Y-m-d $value 
	 * @return d/m/Y $value 
	 */
	public function formatDateTo($value)
	{
		return Carbon::parse($value)->format('d/m/Y');
	}
}