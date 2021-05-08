<?php

return [
	'favicon'		=> 'https://basil.id/favicon.png',
	'logo'			=> 'https://basil.id/logo-basil.png',
	'logo-invert'	=> 'https://basil.id/logo-basil-white.png',
	'logo-black'    => 'https://basil.id/logo-basil-block.png',
	'name'			=> 'BASIL.ID by THUNDERLAB',
	'url'			=> 'https://basil.id',
	'email'			=> 'hello@basil.id',
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
	'bladev'		=> [
		'tacl' 		=> 'v2', 
		'tsub' 		=> 'v2',
		'tcust'		=> 'v2',
		'tfin'		=> 'v2',
		'tmf'		=> 'v2',
		'tproc'		=> 'v2',
		'tsale'		=> 'v2',
		'twh'		=> 'v2',
		'tswirl'	=> 'v2',
	],
    'blacklist'    	=> [
        'host'		=> [
        	'nakoa.id',
			'member.nakoa.id',
			'owner.nakoa.id',
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
        'tswirl.database.reset'				=> 'Reset Database',
        'tswirl.conflict.stock_overlap'		=> 'Melihat stok rebutan',
	],
	'title'		=> [
		'conflict'			=> [
			'stock_overlap'	=> 'Stok Rebutan',
		]
	],
	'setting'	=> ['business'		=> 'nakoa'],
];
