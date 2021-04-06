<?php

return [
	'name'          => 'PT THUNDER LABS INDONESIA',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.896.7200.7400',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65141',
    'mode'			=> 'local',
    // 'mode'		=> 'tenant',
	'support'		=> ['tacl', 'tsub'],
	'setting'		=> [
		'reserved_hosts' 		=> [
			'soda.id',
			'member.soda.id',
			'owner.soda.id',
			'thunder.soda.id',
			'tools.soda.id',
			// 'localhost',
			// 'member.localhost',
			// 'owner.localhost',
			// 'thunder.localhost',
			// 'tools.localhost',
		],
		'dashboard'	=> 'STMDW01'
	],
	'scopes'		=> [
        'tacl.setting.user'	=> 'Mengatur user',
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
