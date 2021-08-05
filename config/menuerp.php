<?php

return [
	'dashboard'	=> [
		'PENJUALAN'		=> [
			'Transaksi'	=> [[
				'title'	=> 'Penjualan',
				'url'	=> 'tsale.transaction.index',
				'param' => ['mode' => 'penjualan', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.penjualan',
			]],
			'Pengaturan Bisnis' => [[
				'title'	=> 'Katalog',
				'url'	=> 'tsale.catalog.index',
				'param' => ['status' => 'published'],
				'scope'	=> 'tsale.catalog.setting',
			], [
				'title'	=> 'Promo Produk',
				'url'	=> 'tsale.promo.index',
				'param' => ['mode' => 'catalog', 'status' => 'activated'],
				'scope'	=> 'tsale.promo.catalog',
			], [
				'title'	=> 'Promo Transaksi',
				'url'	=> 'tsale.promo.index',
				'param' => ['mode' => 'transaction', 'status' => 'activated'],
				'scope'	=> 'tsale.promo.transaction',
			], [
				'title'	=> 'Template Note',
				'url'	=> 'tsale.note.get',
				'param' => [],
				'scope'	=> 'tsale.setting.note',
			], [
				'title'	=> 'Preferensi Pembayaran',
				'url'	=> 'tsale.pay.get',
				'param' => [],
				'scope'	=> 'tsale.setting.pay',
			]],
			'Pengaturan Outlet' => [[
				'title'	=> 'Katalog',
				'url'	=> 'tsale.catalog.listing',
				'param' => [],
				'scope'	=> 'tsale.catalog.listing',
			],[
				'title'	=> 'Promo',
				'url'	=> 'tsale.promo.listing',
				'param' => [],
				'scope'	=> 'tsale.promo.listing',
			]],
		],
		'PERSEDIAAN'	=> [
			'Dokumen'	=> [[
				'title'	=> 'Tugas',
				'url'	=> 'twh.task.index',
				'param' => ['status' => 'opened'],
				'scope'	=> 'twh.task.index',
			], [
				'title'	=> 'Stok',
				'url'	=> 'twh.document.index',
				'param' => ['status' => 'created'],
				'scope'	=> 'twh.document.index',
			]],
			'Pengaturan Bisnis' => [[
				'title'	=> 'Item',
				'url'	=> 'twh.item.index',
				'param' => ['status' => 'submitted'],
				'scope'	=> 'twh.setting.item',
			]],
		],
		'PEMBELIAN'		=> [
			'Data' 		=> [[
				'title'	=> 'Pembelian',
				'url'	=> 'tproc.transaction.index',
				'param' => ['mode' => 'pembelian', 'status' => 'opened'],
				'scope'	=> 'tproc.transaction.pembelian',
			]],
		],
		'BISNIS'		=> [
			'Data' 		=> [[
				'title'	=> 'Stok Rebutan',
				'url'	=> 'tswirl.conflict.index',
				'param' => ['mode' => 'stock_overlap'],
				'scope'	=> 'tswirl.conflict.stock_overlap',
			]],
		],
	],
	'thunder'	=> [
		'Pengaturan' => [[
			'title'	=> 'Pengguna',
			'url'	=> 'tacl.user.index',
			'param' => ['sort[name]' => 'asc'],
			'scope'	=> 'tacl.setting.user',
		]],
	],
	'glossary'		=> [
		'tacl'      => 'Akses', 
        'tsub'      => 'Langganan',
        'tsale'     => 'Penjualan', 
        'tcust'     => 'Pelanggan',
        'twh'       => 'Persediaan', 
        'tmf'       => 'Produksi', 
        'tproc'     => 'Pembelian', 
        'tfin'      => 'Keuangan', 
        'tswirl'    => 'Bisnis', 
	],
];
