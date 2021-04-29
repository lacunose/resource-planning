<?php

return [
	'dashboard'	=> [
		'PENJUALAN'		=> [
			'Data' 		=> [[
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
			'Laporan Marketing' => [[
				'title'	=> 'Pelanggan',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'customer', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.customer',
			], [
				'title'	=> 'Trend Produk',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'catalog', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.catalog',
			], [
				'title'	=> 'Preferensi Produk',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'palate', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.palate',
			]],
			'Laporan Penjualan' => [[
				'title'	=> 'Produk',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'sold', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.sold',
			], [
				'title'	=> 'Kategori',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'category', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.category',
			], [
				'title'	=> 'Pembayaran',
				'url'	=> 'tsale.report.index',
				'param' => ['group' => 'payment', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tsale.report.payment',
			]],
		],
		'PERSEDIAAN'	=> [
			'Data'		=> [[
				'title'	=> 'Stok Masuk',
				'url'	=> 'twh.document.index',
				'param' => ['cause' => 'masuk', 'status' => 'opened'],
				'scope'	=> 'twh.document.masuk',
			], [
				'title'	=> 'Stok Keluar',
				'url'	=> 'twh.document.index',
				'param' => ['cause' => 'keluar', 'status' => 'opened'],
				'scope'	=> 'twh.document.keluar',
			], [
				'title'	=> 'Stok Inhouse',
				'url'	=> 'twh.document.index',
				'param' => ['cause' => 'inhouse', 'status' => 'opened'],
				'scope'	=> 'twh.document.inhouse',
			]],
			'Pengaturan Bisnis' => [[
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
			'Laporan Stok' => [[
				'title'	=> 'Kartu Stok',
				'url'	=> 'twh.report.stock',
				'param' => [],
				'scope'	=> 'twh.report.stock',
			], [
				'title'	=> 'Stok Keluar (Basi)',
				'url'	=> 'twh.report.index',
				'param' => ['group' => 'spoiled'],
				'scope'	=> 'twh.report.spoiled',
			], [
				'title'	=> 'Stok Keluar (Kadaluarsa)',
				'url'	=> 'twh.report.index',
				'param' => ['group' => 'expired'],
				'scope'	=> 'twh.report.expired',
			], [
				'title'	=> 'Stok Keluar (Cacat)',
				'url'	=> 'twh.report.index',
				'param' => ['group' => 'defected'],
				'scope'	=> 'twh.report.defected',
			], [
				'title'	=> 'Stok Keluar (Hilang)',
				'url'	=> 'twh.report.index',
				'param' => ['group' => 'lost'],
				'scope'	=> 'twh.report.lost',
			], [
				'title'	=> 'Stok Keluar (Tidak jelas)',
				'url'	=> 'twh.report.index',
				'param' => ['group' => 'unidentified'],
				'scope'	=> 'twh.report.unidentified',
			]],
			'Laporan Performa' => [[
				'title'	=> 'Packing',
				'url'	=> 'twh.report.timer',
				'param' => ['group' => 'packing'],
				'scope'	=> 'twh.timer.packing',
			], [
				'title'	=> 'Unpacking',
				'url'	=> 'twh.report.timer',
				'param' => ['group' => 'unpacking'],
				'scope'	=> 'twh.timer.unpacking',
			]],
			'Rekomendasi' => [[
				'title'	=> 'Opname',
				'url'	=> 'twh.report.opname',
				'param' => [],
				'scope'	=> 'twh.report.opname',
			], [
				'title'	=> 'Pembelian',
				'url'	=> 'twh.report.procure',
				'param' => [],
				'scope'	=> 'twh.report.procure',
			]],
		],
		'PRODUKSI'		=> [
			'Data'		=> [[
				'title'	=> 'Checker',
				'url'	=> 'tmf.checker.index',
				'param' => ['status' => 'requested'],
				'scope'	=> 'tmf.checker.index',
			], [
				'title'	=> 'Requisition',
				'url'	=> 'tmf.requisition.index',
				'param' => ['status' => 'opened'],
				'scope'	=> 'tmf.requisition.index',
			]],
			'Pengaturan Bisnis' 	=> [[
				'title'	=> 'Menu',
				'url'	=> 'tmf.good.index',
				'param' => ['status' => 'published'],
				'scope'	=> 'tmf.good.setting',
			], [
				'title'	=> 'Bahan / Tenaga',
				'url'	=> 'tmf.resource.index',
				'param' => ['status' => 'published'],
				'scope'	=> 'tmf.resource.setting',
			]],
			'Pengaturan Station'	=> [[
				'title'	=> 'Bahan / Tenaga',
				'url'	=> 'tmf.resource.listing',
				'param' => [],
				'scope'	=> 'tmf.resource.listing',
			]],
			'Laporan Bahan' => [[
				'title'	=> 'Penggunaan',
				'url'	=> 'tmf.report.index',
				'param' => ['group' => 'usage', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tmf.report.usage',
			], [
				'title'	=> 'Koreksi Penggunaan',
				'url'	=> 'tmf.report.index',
				'param' => ['group' => 'correction', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tmf.report.correction',
			]],
			'Laporan Performa' => [[
				'title'	=> 'Pembuatan',
				'url'	=> 'tmf.report.index',
				'param' => ['group' => 'processed', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tmf.report.processed',
			]],
		],
		'PEMBELIAN'		=> [
			'Data' 		=> [[
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
			'Laporan Riwayat' => [[
				'title'	=> 'Harga Barang',
				'url'	=> 'tproc.report.index',
				'param' => ['group' => 'price', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tproc.report.price',
			]],
			'Laporan Pembelian' => [[
				'title'	=> 'Vendor',
				'url'	=> 'tproc.report.index',
				'param' => ['group' => 'vendor', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tproc.report.vendor',
			], [
				'title'	=> 'Settlement Pembelian',
				'url'	=> 'tproc.report.index',
				'param' => ['group' => 'payment', 'filter[date_gte]' => date('Y-m-d')],
				'scope'	=> 'tproc.report.payment',
			]],
		],
		// 'PELANGGAN'		=> [
		// 	'Data' 		=> [[
		// 		'title'	=> 'Akun',
		// 		'url'	=> 'tcust.account.index',
		// 		'param' => ['status' => 'opened'],
		// 		'scope'	=> 'tcust.account.data',
		// 	]],
		// 	'Pengaturan' => [[
		// 		'title'	=> 'Anggota',
		// 		'url'	=> 'tcust.customer.index',
		// 		'param' => ['status' => 'actived', 'sort[name]' => 'asc'],
		// 		'scope'	=> 'tcust.setting.customer',
		// 	], [
		// 		'title'	=> 'Program',
		// 		'url'	=> 'tcust.program.index',
		// 		'param' => ['status' => 'published'],
		// 		'scope'	=> 'tcust.setting.program',
		// 	]],
		// 	'Laporan' => [[
		// 		'title'	=> 'Transaksi Pending',
		// 		'url'	=> 'tcust.report.log',
		// 		'param' => ['mode' => 'pending'],
		// 		'scope'	=> 'tcust.log.pending',
		// 	], [
		// 		'title'	=> 'Transaksi Verifikasi',
		// 		'url'	=> 'tcust.report.log',
		// 		'param' => ['mode' => 'verified'],
		// 		'scope'	=> 'tcust.log.verified',
		// 	]],
		// ],
		// 'KEUANGAN'		=> [
		// 	'Kasir' 	=> [[
		// 		'title'	=> 'Pemasukan',
		// 		'url'	=> 'tfin.cashier.index',
		// 		'param' => ['mode' => 'pemasukan', 'status' => 'opened'],
		// 		'scope'	=> 'tfin.cashier.pemasukan',
		// 	], [
		// 		'title'	=> 'Pengeluaran',
		// 		'url'	=> 'tfin.cashier.index',
		// 		'param' => ['mode' => 'pengeluaran', 'status' => 'opened'],
		// 		'scope'	=> 'tfin.cashier.pengeluaran',
		// 	]],
		// 	'Catatan' 	=> [[
		// 		'title'	=> 'Transaksi',
		// 		'url'	=> 'tfin.book.index',
		// 		'param' => ['cause' => 'transaksi', 'status' => 'drafted'],
		// 		'scope'	=> 'tfin.book.transaksi',
		// 	], [
		// 		'title'	=> 'Memorial',
		// 		'url'	=> 'tfin.book.index',
		// 		'param' => ['cause' => 'memorial', 'status' => 'drafted'],
		// 		'scope'	=> 'tfin.book.memorial',
		// 	]],
		// 	'Pengaturan' => [[
		// 		'title'	=> 'Akun',
		// 		'url'	=> 'tfin.coa.index',
		// 		'param' => ['status' => 'actived'],
		// 		'scope'	=> 'tfin.setting.coa',
		// 	], [
		// 		'title'	=> 'Depresiasi',
		// 		'url'	=> 'tfin.asset.index',
		// 		'param' => ['type' => 'depresiasi', 'status' => 'drafted'],
		// 		'scope'	=> 'tfin.asset.depresiasi',
		// 	], [
		// 		'title'	=> 'Amortisasi',
		// 		'url'	=> 'tfin.asset.index',
		// 		'param' => ['type' => 'amortisasi', 'status' => 'drafted'],
		// 		'scope'	=> 'tfin.asset.amortisasi',
		// 	]],
		// 	'Laporan' 	=> [[
		// 		'title'	=> 'Buku Besar',
		// 		'url'	=> 'tfin.report.journal',
		// 		'param' => ['filter[date_gte]' => date('Y-m-d')],
		// 		'scope'	=> 'tfin.report.jurnal',
		// 	], [
		// 		'title'	=> 'Neraca',
		// 		'url'	=> 'tfin.report.neraca',
		// 		'param' => ['date' => date('Y-m-d'), 'mode' => 'ringkas'],
		// 		'scope'	=> 'tfin.report.neraca',
		// 	], [
		// 		'title'	=> 'Laba / Rugi',
		// 		'url'	=> 'tfin.report.labarugi',
		// 		'param' => ['date' => date('Y-m-d'), 'mode' => 'ringkas'],
		// 		'scope'	=> 'tfin.report.labarugi',
		// 	]]
		// ],
		'BISNIS'		=> [
			'Laporan'	=> [[
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
