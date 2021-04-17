<?php

return [
	'favicon'		=> 'https://nakoa.id/favicon.ico',
	'logo'			=> 'https://nakoa.id/_nuxt/img/f1e1311.png',
	'logo-invert'	=> 'https://nakoa.id/_nuxt/img/f1e1311.png',
	'logo-black'    => 'https://nakoa.id/_nuxt/img/f1e1311.png',
	'name'			=> 'NAKOA.ID x BASIL',
	'url'			=> 'https://nakoa.id',
	'email'			=> 'hello@nakoa.id',
	'whatsapp'		=> '+62.811.3530.030',
	'address'		=> 'Lenmarc Mall Lt. UG no 33,35, KOTA SURABAYA JAWA TIMUR, INDONESIA, 60226',
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
        	'nakoa.id',
			'member.nakoa.id',
			'ownerx.nakoa.id',
			'thunder.nakoa.id',
			'tools.nakoa.id',
			'pos.nakoa.id',
        ],
    ],
    'whitelist'    	=> [
        'client'	=> [
        	'TMDW01',
        ],
    ],
	'bot'		    => [
		'name'	    => 'Silvia (Basil Virtual Assistant)',
		'email'	    => 'silvia@basil.id',
	],
	'scopes'	=> [
        'tswirl.conflict.stock_overlap'		=> 'Melihat stok rebutan',
	],
	'title'		=> [
		'conflict'			=> [
			'stock_overlap'	=> 'Stok Rebutan',
		]
	],
];
