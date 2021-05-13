<?php

return [
	'name'          => 'PT THUNDER LABS INDONESIA',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.896.7200.7400',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65141',
<<<<<<< HEAD
	'support'		=> ['tacl', 'tsub'],
=======
	'support'		=> ['tacl'],
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
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
			'tmf.opsi.station'		=> 'Station',
			'tproc.opsi.branch'		=> 'Divisi Pembelian',
			'tfin.opsi.branch'		=> 'Divisi Keuangan',
		],
	]
];
