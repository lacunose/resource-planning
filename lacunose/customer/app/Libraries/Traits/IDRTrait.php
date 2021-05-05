<?php

namespace Lacunose\Customer\Libraries\Traits;

use Exception, Str;

/**
 * Trait Link list
 *
 * Digunakan untuk initizialize link list mode
 *
 * @program    TTagihan
 * @author     C Mooy <chelsymooy1108@gmail.com>
 */
trait IDRTrait {
 	 	
	/**
	 * Add Event_list to queue
	 * @param [IEvent_list] $event_list 
	 */
	public function formatMoneyFrom($value)
	{
		if(is_null($value)){
			return 0;
		}

		list($currency,$amount) 	= array_map('trim', explode(' ', $value));

		if(!STR::is(strtolower($currency), 'rp') && !STR::is(strtolower($currency), 'rp.'))
		{
			throw new Exception('rp', 1);
		}

		return (str_replace(',', '.', str_replace('.', '', $amount))) * 1;
	}

	/**
	 * Add Event_list to queue
	 * @param [IEvent_list] $event_list 
	 */
	public function formatNumber($value)
	{
		return number_format($value,2, "," ,".");
	}
	/**
	 * Add Event_list to queue
	 * @param [IEvent_list] $event_list 
	 */
	public function formatMoneyTo($value)
	{
		if(is_null($value)){
			return 'Rp 0';
		}

		if($value < 0) {
			return '((Rp '.number_format(abs($value),2, "," ,".").'))';
		}

		return 'Rp '.number_format($value,2, "," ,".");
	}
}