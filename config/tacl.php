<?php

return [
	'name'          => 'PT THUNDER LABS INDONESIA',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.896.7200.7400',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65141',
	'support'		=> ['tacl', 'tsub'],
	'scopes'		=> [
        'tacl.setting.user'	=> 'Mengatur user',
	],
	'whitelist'    	=> [
        'client'		=> [
        	'dashboard'	=> 'TMDW01',
			'customer'	=> 'TMTA01',
        ],
    ],
	'opsi'			=> [
		'level'		=> [
			'member'		=> 'Anggota',
			'owner'			=> 'Pemilik',
			'thunder'		=> 'Thunder',
		],
		'role'		=> [
			'tsale.opsi.outlet'		=> 'Outlet',
			'twh.opsi.warehouse'	=> 'Gudang',
			'tfin.opsi.branch'		=> 'Unit',
		],
	]
];
