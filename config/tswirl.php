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
];
