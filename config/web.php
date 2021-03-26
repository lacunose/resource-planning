<?php

return [
	'favicon'		=> 'https://basil.id/favicon.png',
	'logo'			=> 'http://basil.id/logo-basil.png',
	'logo-invert'	=> 'http://basil.id/logo-basil-white.png',
	'logo-black'    => 'http://basil.id/logo-basil-block.png',
	'name'			=> 'BASIL.ID by THUNDERLAB',
	'url'			=> 'https://basil.id',
	'email'			=> 'hello@basil.id',
	'whatsapp'		=> '+62.896.7200.7400',
	'address'		=> 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
	'user'			=> ['conn' => 'system'],
	'sub'			=> ['conn' => 'system'],
	'dashboard_navbar'	=> [
		'PENJUALAN'		=> [
			'Transaksi' => [[
				'title'	=> 'POS',
				'url'	=> 'tsale.transaction.index',
				'param' => ['marketplace' => 'pos', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.pos',
			]],
			'Pengaturan' => [[
				'title'	=> 'Produk',
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
			]],
			'Outlet' => [[
				'title'	=> 'Katalog',
				'url'	=> 'tsale.catalog.listing',
				'param' => [],
				'scope'	=> 'tsale.catalog.listing',
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
			'Laporan' => [[
				'title'	=> 'Trend Produk',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'catalog', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.catalog',
			], [
				'title'	=> 'Pelanggan',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'customer', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.customer',
			], [
				'title'	=> 'Settlement Penjualan',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'payment', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.payment',
			]],
		],
		'GUDANG'	=> [
			'Stok' 	=> [[
				'title'	=> 'Masuk',
				'url'	=> 'twh.document.index',
				'param' => ['cause' => 'masuk', 'status' => 'drafted'],
				'scope'	=> 'twh.document.masuk',
			], [
				'title'	=> 'Keluar',
				'url'	=> 'twh.document.index',
				'param' => ['cause' => 'keluar', 'status' => 'drafted'],
				'scope'	=> 'twh.document.keluar',
			], [
				'title'	=> 'Opname',
				'url'	=> 'twh.document.index',
				'param' => ['cause' => 'opname', 'status' => 'drafted'],
				'scope'	=> 'twh.document.opname',
			], [
				'title'	=> 'Konversi',
				'url'	=> 'twh.document.index',
				'param' => ['cause' => 'konversi', 'status' => 'drafted'],
				'scope'	=> 'twh.document.konversi',
			]],
			'Pengaturan' => [[
				'title'	=> 'Item',
				'url'	=> 'twh.item.index',
				'param' => ['status' => 'submitted'],
				'scope'	=> 'twh.setting.item',
			], [
				'title'	=> 'Produksi',
				'url'	=> 'twh.recipe.index',
				'param' => ['type' => 'produksi', 'status' => 'actived'],
				'scope'	=> 'twh.recipe.produksi',
			], [
				'title'	=> 'Unpack',
				'url'	=> 'twh.recipe.index',
				'param' => ['type' => 'unpack', 'status' => 'actived'],
				'scope'	=> 'twh.recipe.unpack',
			]],
			'Laporan' => [[
				'title'	=> 'Kartu Stok',
				'url'	=> 'twh.laporan.stock',
				'param' => [],
				'scope'	=> 'twh.laporan.stock',
			], [
				'title'	=> 'Statistik Stok',
				'url'	=> 'twh.laporan.stat',
				'param' => [],
				'scope'	=> 'twh.laporan.stat',
			], [
				'title'	=> 'Kepemilikan Stok',
				'url'	=> 'twh.laporan.index',
				'param' => ['group' => 'owner'],
				'scope'	=> 'twh.laporan.owner',
			], [
				'title'	=> 'Performance Packer',
				'url'	=> 'twh.laporan.timer',
				'param' => ['group' => 'packing'],
				'scope'	=> 'twh.timer.packing',
			]],
		],
		'PEMBELIAN'		=> [
			'Transaksi' => [[
				'title'	=> 'Pembelian',
				'url'	=> 'tproc.transaction.index',
				'param' => ['mode' => 'pembelian', 'status' => 'opened'],
				'scope'	=> 'tproc.transaction.pembelian',
			], [
				'title'	=> 'Konsinyasi',
				'url'	=> 'tproc.transaction.index',
				'param' => ['mode' => 'konsinyasi', 'status' => 'opened'],
				'scope'	=> 'tproc.transaction.konsinyasi',
			]],
			'Laporan' => [[
				'title'	=> 'Harga Barang',
				'url'	=> 'tproc.laporan.index',
				'param' => ['group' => 'item', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tproc.laporan.item',
			], [
				'title'	=> 'Settlement Pembelian',
				'url'	=> 'tproc.laporan.index',
				'param' => ['group' => 'payment', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tproc.laporan.payment',
			]],
		],
		'KEUANGAN'		=> [
			'Kasir' 	=> [[
				'title'	=> 'Pemasukan',
				'url'	=> 'tfin.cashier.index',
				'param' => ['mode' => 'pemasukan', 'status' => 'opened'],
				'scope'	=> 'tfin.cashier.pemasukan',
			], [
				'title'	=> 'Pengeluaran',
				'url'	=> 'tfin.cashier.index',
				'param' => ['mode' => 'pengeluaran', 'status' => 'opened'],
				'scope'	=> 'tfin.cashier.pengeluaran',
			]],
			'Catatan' 	=> [[
				'title'	=> 'Transaksi',
				'url'	=> 'tfin.book.index',
				'param' => ['cause' => 'transaksi', 'status' => 'drafted'],
				'scope'	=> 'tfin.book.transaksi',
			], [
				'title'	=> 'Memorial',
				'url'	=> 'tfin.book.index',
				'param' => ['cause' => 'memorial', 'status' => 'drafted'],
				'scope'	=> 'tfin.book.memorial',
			]],
			'Pengaturan' => [[
				'title'	=> 'Akun',
				'url'	=> 'tfin.coa.index',
				'param' => ['status' => 'actived'],
				'scope'	=> 'tfin.setting.coa',
			], [
				'title'	=> 'Aset Berwujud',
				'url'	=> 'tfin.asset.index',
				'param' => ['type' => 'berwujud', 'status' => 'drafted'],
				'scope'	=> 'tfin.asset.berwujud',
			], [
				'title'	=> 'Aset Tidak Berwujud',
				'url'	=> 'tfin.asset.index',
				'param' => ['type' => 'tidak_berwujud', 'status' => 'drafted'],
				'scope'	=> 'tfin.asset.tidak_berwujud',
			]],
			'Laporan' 	=> [[
				'title'	=> 'Buku Besar',
				'url'	=> 'tfin.laporan.journal',
				'param' => ['filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tfin.laporan.jurnal',
			], [
				'title'	=> 'Neraca',
				'url'	=> 'tfin.laporan.neraca',
				'param' => ['date' => date('Y-m-d'), 'mode' => 'ringkas'],
				'scope'	=> 'tfin.laporan.neraca',
			], [
				'title'	=> 'Laba / Rugi',
				'url'	=> 'tfin.laporan.labarugi',
				'param' => ['date' => date('Y-m-d'), 'mode' => 'ringkas'],
				'scope'	=> 'tfin.laporan.labarugi',
			]]
		],
		'MANAJEMEN'		=> [
			'Stok'		=> [[
				'title'	=> 'Stok Ditahan',
				'url'	=> 'app.onhold.get',
				'param' => [],
				'scope'	=> 'app.stock.onhold',
			],[
				'title'	=> 'Stok Rebutan',
				'url'	=> 'app.conflict.get',
				'param' => ['topic' => 'stock_overlap'],
				'scope'	=> 'app.conflict.stock_overlap',
			]],
		],
	],
	'thunder_navbar'	=> [
		'Langganan' => [[
			'title'	=> 'PRO',
			'url'	=> 'tsub.subscription.index',
			'param' => ['membership' => 'professional', 'status' => 'inactived'],
			'scope'	=> 'tsub.subscription.professional',
		], [
			'title'	=> 'X',
			'url'	=> 'tsub.subscription.index',
			'param' => ['membership' => 'exclusive', 'status' => 'inactived'],
			'scope'	=> 'tsub.subscription.exclusive',
		]],
		'Pengaturan' => [[
			'title'	=> 'Pengguna',
			'url'	=> 'tacl.user.index',
			'param' => ['sort[name]' => 'asc'],
			'scope'	=> 'tacl.setting.user',
		], [
			'title'	=> 'Paket Langganan',
			'url'	=> 'tsub.package.index',
			'param' => ['status' => 'published'],
			'scope'	=> 'tsub.setting.package',
		]],
		'Laporan' => [[
			'title'	=> 'Tagihan Pending',
			'url'	=> 'tsub.laporan.bill',
			'param' => ['mode' => 'unpaid'],
			'scope'	=> 'tsub.bill.unpaid',
		], [
			'title'	=> 'Tagihan Lunas',
			'url'	=> 'tsub.laporan.bill',
			'param' => ['mode' => 'paid'],
			'scope'	=> 'tsub.bill.paid',
		]],
	],
	'translator'	=> [
		'tfin_twh_cause'	=> [
			'masuk'			=> 'transaksi',
			'keluar'		=> 'transaksi',
		],
		'tfin_twh_type'		=> [
			'masuk'			=> 'receiving',
			'keluar'		=> 'surat_jalan',
		],
	],
	'agent'		=> [
		'chatbot'	=> 'silvia@basil.id'	
	],
	'setting'		=> [
		'wh_usage_cutoff'	=> 'daily',	
		// 'wh_usage_cutoff'	=> 'transaction'	
	],
	'glossary'		=> [
		'management'=> 'Manajemen', 
		'tacl'		=> 'Akses', 
		'tfin'		=> 'Keuangan', 
		'twh'		=> 'Gudang', 
		'tsale'		=> 'Penjualan', 
		'tsub'		=> 'Langganan',
	],
];
