<?php

return [
	'favicon'		=> 'https://soda.id/favicon.png',
	'logo'			=> 'https://soda.id/logo-soda.png',
	'logo-invert'	=> 'https://soda.id/logo-soda-white.png',
	'logo-black'    => 'https://soda.id/logo-soda-block.png',
	'name'			=> 'SODA.ID by THUNDERLAB',
	'url'			=> 'https://soda.id',
	'email'			=> 'hello@soda.id',
	'whatsapp'		=> '+62.896.7200.7400',
	'address'		=> 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
	'db'			=> [
		'tacl' 		=> 'system', 
		'tsub' 		=> 'system',
		'tcust'		=> 'tenant',
		'tfin'		=> 'tenant',
		'tmf'		=> 'tenant',
		'tproc'		=> 'tenant',
		'tsale'		=> 'tenant',
		'twh'		=> 'tenant',
		'tswirl'	=> 'tenant',
	],
	'storage'		=> [
		'tacl' 		=> 'local', 
		'tsub' 		=> 'local',
		'tcust'		=> 'tenant',
		'tfin'		=> 'tenant',
		'tmf'		=> 'tenant',
		'tproc'		=> 'tenant',
		'tsale'		=> 'tenant',
		'twh'		=> 'tenant',
		'tswirl'	=> 'tenant',
	],
	'queue'			=> [
		'tacl' 		=> 'database', 
		'tsub' 		=> 'database',
		'tcust'		=> 'database',
		'tfin'		=> 'database',
		'tmf'		=> 'database',
		'tproc'		=> 'database',
		'tsale'		=> 'database',
		'twh'		=> 'database',
		'tswirl'	=> 'database',
	],
	'skin'	=> [
		'tacl' 		=> 'v1', 
		'tsub' 		=> 'v1',
		'tcust'		=> 'v1',
		'tfin'		=> 'v1',
		'tmf'		=> 'v1',
		'tproc'		=> 'v1',
		'tsale'		=> 'v1',
		'twh'		=> 'v1',
		'tswirl'	=> 'v1',
	],
    'blacklist'    	=> [
        'host'		=> [
        	'soda.id',
			'member.soda.id',
			'owner.soda.id',
			'thunder.soda.id',
			'tools.soda.id',
			'pos.soda.id',
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
