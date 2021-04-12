<?php

return [
	'dashboard'	=> [
		'PENJUALAN'		=> [
			'Transaksi' => [[
				'title'	=> 'POS',
				'url'	=> 'tsale.transaction.index',
				'param' => ['marketplace' => 'pos', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.pos',
			], [
				'title'	=> 'SHOPEE',
				'url'	=> 'tsale.transaction.index',
				'param' => ['marketplace' => 'shopee', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.shopee',
			], [
				'title'	=> 'TOKOPEDIA',
				'url'	=> 'tsale.transaction.index',
				'param' => ['marketplace' => 'tokopedia', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.tokopedia',
			], [
				'title'	=> 'LAZADA',
				'url'	=> 'tsale.transaction.index',
				'param' => ['marketplace' => 'lazada', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.lazada',
			], [
				'title'	=> 'BUKALAPAK',
				'url'	=> 'tsale.transaction.index',
				'param' => ['marketplace' => 'bukalapak', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.bukalapak',
			], [
				'title'	=> 'JD.ID',
				'url'	=> 'tsale.transaction.index',
				'param' => ['marketplace' => 'jdid', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.jdid',
			], [
				'title'	=> 'BLIBLI',
				'url'	=> 'tsale.transaction.index',
				'param' => ['marketplace' => 'blibli', 'status' => 'opened'],
				'scope'	=> 'tsale.transaction.blibli',
			]],
			'Pengaturan' => [[
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
			'Outlet' => [[
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
			'Laporan' => [[
				'title'	=> 'Trend Produk',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'catalog', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.catalog',
			], [
				'title'	=> 'Penjualan Produk',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'sold', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.sold',
			], [
				'title'	=> 'Penjualan Produk (Berdasarkan Kategori)',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'category', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.category',
			], [
				'title'	=> 'Pelanggan',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'customer', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.customer',
			], [
				'title'	=> 'Preferensi Produk',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'palate', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.palate',
			], [
				'title'	=> 'Settlement Penjualan',
				'url'	=> 'tsale.laporan.index',
				'param' => ['group' => 'payment', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.laporan.payment',
			]],
		],
		'PELANGGAN'		=> [
			'Data' 		=> [[
				'title'	=> 'Akun',
				'url'	=> 'tcust.account.index',
				'param' => ['status' => 'opened'],
				'scope'	=> 'tcust.account.data',
			]],
			'Pengaturan' => [[
				'title'	=> 'Anggota',
				'url'	=> 'tcust.customer.index',
				'param' => ['status' => 'actived', 'sort[name]' => 'asc'],
				'scope'	=> 'tcust.setting.customer',
			], [
				'title'	=> 'Program',
				'url'	=> 'tcust.program.index',
				'param' => ['status' => 'published'],
				'scope'	=> 'tcust.setting.program',
			]],
			'Laporan' => [[
				'title'	=> 'Transaksi Pending',
				'url'	=> 'tcust.laporan.log',
				'param' => ['mode' => 'pending'],
				'scope'	=> 'tcust.log.pending',
			], [
				'title'	=> 'Transaksi Verifikasi',
				'url'	=> 'tcust.laporan.log',
				'param' => ['mode' => 'verified'],
				'scope'	=> 'tcust.log.verified',
			]],
		],
		'PERSEDIAAN'	=> [
			'Stok' 		=> [[
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
				'title'	=> 'Inhouse',
				'url'	=> 'twh.document.index',
				'param' => ['cause' => 'inhouse', 'status' => 'drafted'],
				'scope'	=> 'twh.document.inhouse',
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
				'title'	=> 'Rekomendasi Opname',
				'url'	=> 'twh.laporan.opname',
				'param' => [],
				'scope'	=> 'twh.laporan.opname',
			], [
				'title'	=> 'Rekomendasi PO',
				'url'	=> 'twh.laporan.procure',
				'param' => [],
				'scope'	=> 'twh.laporan.procure',
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
		'PRODUKSI'		=> [
			'Pesanan'	=> [[
				'title'	=> 'Persediaan',
				'url'	=> 'tmf.document.index',
				'param' => ['mode' => 'persediaan', 'status' => 'drafted'],
				'scope'	=> 'tmf.document.persediaan',
			], [
				'title'	=> 'Penjualan',
				'url'	=> 'tmf.document.index',
				'param' => ['mode' => 'penjualan', 'status' => 'drafted'],
				'scope'	=> 'tmf.document.penjualan',
			], [
				'title'	=> 'Checker',
				'url'	=> 'tmf.checker.index',
				'param' => ['status' => 'requested'],
				'scope'	=> 'tmf.document.checker',
			]],
			'Pengaturan' => [[
				'title'	=> 'Menu',
				'url'	=> 'tmf.menu.index',
				'param' => ['status' => 'published'],
				'scope'	=> 'tmf.menu.setting',
			]],
			'Laporan' => [[
				'title'	=> 'Performa Station',
				'url'	=> 'tmf.laporan.index',
				'param' => ['group' => 'station', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tmf.laporan.station',
			], [
				'title'	=> 'Rasio Menu',
				'url'	=> 'tmf.laporan.index',
				'param' => ['group' => 'ratio', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tmf.laporan.ratio',
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
				'param' => ['group' => 'price', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tproc.laporan.price',
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
				'title'	=> 'Depresiasi',
				'url'	=> 'tfin.asset.index',
				'param' => ['type' => 'depresiasi', 'status' => 'drafted'],
				'scope'	=> 'tfin.asset.depresiasi',
			], [
				'title'	=> 'Amortisasi',
				'url'	=> 'tfin.asset.index',
				'param' => ['type' => 'amortisasi', 'status' => 'drafted'],
				'scope'	=> 'tfin.asset.amortisasi',
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
	'thunder'	=> [
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
	'glossary'		=> [
		'management'=> 'Manajemen', 
		'tacl'		=> 'Akses', 
		'twh'		=> 'Persediaan', 
		'tmf'		=> 'Produksi', 
		'tsale'		=> 'Penjualan', 
	    'tcust'     => 'Pelanggan',
		'tproc'		=> 'Pembelian', 
		'tfin'		=> 'Keuangan', 
		'tsub'		=> 'Langganan',
	],
];
