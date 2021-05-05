<?php

return [
	'favicon'		=> 'https://vernon.id/assets/images/favicon.png',
	'logo'			=> 'https://vernon.id/assets/images/logo.png',
	'logo-invert'	=> 'https://vernon.id/assets/images/logo.png',
	'logo-black'    => 'https://vernon.id/assets/images/logo.png',
	'name'			=> 'VERNON.ID x SODA',
	'url'			=> 'https://vernon.id',
	'email'			=> 'hello@vernon.id',
	'whatsapp'		=> '+62.811.3530.030',
	'address'		=> 'Lenmarc Mall Lt. UG no 33,35, KOTA SURABAYA JAWA TIMUR, INDONESIA, 60226',
	'business'		=> 'vernon',
	'db'			=> [
		'tacl' 		=> 'system', 
		'tsub' 		=> 'thunder',
		'tcust'		=> 'system',
		'tfin'		=> 'system',
		'tmf'		=> 'system',
		'tproc'		=> 'system',
		'tsale'		=> 'system',
		'twh'		=> 'system',
		'tswirl'	=> 'system',
	],
	'storage'		=> [
		'tacl' 		=> 'local', 
		'tsub' 		=> 'thunder',
		'tcust'		=> 'local',
		'tfin'		=> 'local',
		'tmf'		=> 'local',
		'tproc'		=> 'local',
		'tsale'		=> 'local',
		'twh'		=> 'local',
		'tswirl'	=> 'local',
	],
    'blacklist'    	=> [
        'host'		=> [
        	'vernon.id',
			'member.vernon.id',
			'owner.vernon.id',
			'thunder.vernon.id',
			'tools.vernon.id',
			'pos.vernon.id',
        ],
    ],
    'whitelist'    	=> [
        'client'	=> [
        	'TMDW01',
        ],
    ],
	'bot'		    => [
		'name'	    => 'Sovia (Soda Virtual Assistant)',
		'email'	    => 'sovia@soda.id',
	],
	'scopes'	=> [
        'tswirl.database.reset'				=> 'Reset Database',
        'tswirl.conflict.stock_overlap'		=> 'Melihat stok rebutan',
	],
	'title'		=> [
		'conflict'			=> [
			'stock_overlap'	=> 'Stok Rebutan',
		]
	],
	'setting'	=> ['business'		=> 'vernon'],
];
