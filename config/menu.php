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
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'catalog', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.catalog',
			], [
				'title'	=> 'Pelanggan',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'customer', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.customer',
			], [
				'title'	=> 'Preferensi Produk',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'palate', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.palate',
			], [
				'title'	=> 'Penjualan (Produk)',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'sold', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.sold',
			], [
				'title'	=> 'Penjualan (Kategori)',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'category', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.category',
			], [
				'title'	=> 'Penjualan (Pembayaran)',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'payment', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.payment',
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
				'url'	=> 'tcust.report.log',
				'param' => ['mode' => 'pending'],
				'scope'	=> 'tcust.log.pending',
			], [
				'title'	=> 'Transaksi Verifikasi',
				'url'	=> 'tcust.report.log',
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
				'title'	=> 'Repack',
				'url'	=> 'twh.conversion.index',
				'param' => ['type' => 'repack', 'status' => 'actived'],
				'scope'	=> 'twh.conversion.repack',
			], [
				'title'	=> 'Unpack',
				'url'	=> 'twh.conversion.index',
				'param' => ['type' => 'unpack', 'status' => 'actived'],
				'scope'	=> 'twh.conversion.unpack',
			]],
			'Laporan' => [[
				'title'	=> 'Kartu Stok',
				'url'	=> 'twh.report.stock',
				'param' => [],
				'scope'	=> 'twh.report.stock',
			], [
				'title'	=> 'Rekomendasi Opname',
				'url'	=> 'twh.report.opname',
				'param' => [],
				'scope'	=> 'twh.report.opname',
			], [
				'title'	=> 'Rekomendasi PO',
				'url'	=> 'twh.report.procure',
				'param' => [],
				'scope'	=> 'twh.report.procure',
			], [
				'title'	=> 'Kepemilikan Stok',
				'url'	=> 'twh.report.index',
				'param' => ['group' => 'owner'],
				'scope'	=> 'twh.report.owner',
			], [
				'title'	=> 'Performance Packer',
				'url'	=> 'twh.report.timer',
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
				'url'	=> 'tmf.report.index',
				'param' => ['group' => 'station', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tmf.report.station',
			], [
				'title'	=> 'Rasio Menu',
				'url'	=> 'tmf.report.index',
				'param' => ['group' => 'ratio', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tmf.report.ratio',
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
				'url'	=> 'tproc.report.index',
				'param' => ['group' => 'price', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tproc.report.price',
			], [
				'title'	=> 'Settlement Pembelian',
				'url'	=> 'tproc.report.index',
				'param' => ['group' => 'payment', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tproc.report.payment',
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
				'url'	=> 'tfin.report.journal',
				'param' => ['filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tfin.report.jurnal',
			], [
				'title'	=> 'Neraca',
				'url'	=> 'tfin.report.neraca',
				'param' => ['date' => date('Y-m-d'), 'mode' => 'ringkas'],
				'scope'	=> 'tfin.report.neraca',
			], [
				'title'	=> 'Laba / Rugi',
				'url'	=> 'tfin.report.labarugi',
				'param' => ['date' => date('Y-m-d'), 'mode' => 'ringkas'],
				'scope'	=> 'tfin.report.labarugi',
			]]
		],
		'BISNIS'		=> [
			'Stok'		=> [[
				'title'	=> 'Stok Rebutan',
				'url'	=> 'tswirl.conflict.index',
				'param' => ['topic' => 'stock_overlap'],
				'scope'	=> 'tswirl.conflict.stock_overlap',
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
			'url'	=> 'tsub.report.bill',
			'param' => ['mode' => 'unpaid'],
			'scope'	=> 'tsub.bill.unpaid',
		], [
			'title'	=> 'Tagihan Lunas',
			'url'	=> 'tsub.report.bill',
			'param' => ['mode' => 'paid'],
			'scope'	=> 'tsub.bill.paid',
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
