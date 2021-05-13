<?php

return [
    'scopes'    => [
        'tsale.transaction.penjualan'   => 'Handle transaksi penjualan',
        'tsale.promo.transaction'       => 'Mengatur promo transaksi',
        'tsale.promo.catalog'           => 'Mengatur promo produk',
        'tsale.catalog.setting'         => 'Mengatur katalog',
        // 'tsale.promo.listing'           => 'Mengatur promo outlet',
        // 'tsale.catalog.listing'         => 'Mengatur katalog outlet',
        'tsale.setting.pay'             => 'Mengatur metode pembayaran',
        'tsale.setting.note'            => 'Mengatur template note',
        'tsale.transaction.voided'      => 'Approval void transaksi',
    ],
    'logo'      => 'https://thunderlab.id/storage/app/uploads/public/5f7/ae8/123/5f7ae81237a56599536208.png',
    'name'      => 'THUNDERLAB',
    'url'       => 'https://thunderlab.id',
    'email'     => 'hello@thunderlab.id',
    'whatsapp'  => '+62.895.8100.00500',
    'address'   => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
    'glossary'  => [
        'catalog'       => [
            'unpublished'   => 'Tidak ditampilkan',
            'published'     => 'Ditampilkan',
        ],
        'promo'         => [
            'inactivated'   => 'Tidak diaktifkan',
            'activated'     => 'Diaktifkan',
        ],
        'transaction'  => [
            'opened'        => 'Inbox',
            'processed'     => 'Dalam Proses',
            'closed'        => 'Selesai',
            'voided'        => 'Dibatalkan',
        ],
        'flag'              => [
            'catalog'           => 'Katalog',
            'deposit'           => 'Titipan',
            'promo_catalog'     => 'Promo Produk',
            'promo_transaction' => 'Promo Transaksi',
            'service'           => 'Layanan',
            'tax'               => 'Pajak',
        ],
        'step'          => [
            'created'   => 'Baru',
            'updated'   => 'Update',
            'reopend'   => 'Diulang',
            'confirmed' => 'Konfirmasi',
            'delivered' => 'Dikirim',
            'paid'      => 'Dibayar',
            'returned'  => 'Dikembalikan (full retur)',
            'closed'    => 'Selesai',
            'voided'    => 'Dibatalkan',
        ],
    ],
    'opsi'      => [
        'period'            => [
            'daily'         => 'Harian',
            'monthly'       => 'Bulanan',
            'yearly'        => 'Tahunan',
        ],
        'day'   => [
            '*'             => 'Hari',
            'sunday'        => 'Minggu',
            'monday'        => 'Senin',
            'tuesday'       => 'Selasa',
            'wednesday'     => 'Rabu',
            'thursday'      => 'Kamis',
            'friday'        => 'Jumat',
            'saturday'      => 'Sabtu',
        ],
        'type'  => [
            'free'          => 'Tanpa Resep',
            'item'          => 'Stok',
            'good'          => 'Menu',
        ],
        'promo' => [
            'transaction'   => [
                'ENTERTAIN'     => 'Voucher entertain',
                'MEMBERSHIP'    => 'Voucher member',
                'COUPON'        => 'Kupon belanja',
            ],
            'catalog'       => [
                'DISCOUNT'      => 'Diskon',
                'BUY_AND_PAY'   => 'Beli x, Bayar y',
                'BUY_AND_SAVE'  => 'Beli x, Diskon y',
            ],
        ],
        'step' => [
            'processed'     => [
                'delivered'     => 'Dikirim',
                'paid'          => 'Dibayar',
                'returned'      => 'Dikembalikan (full retur)',
            ],
        ],
        'event' => [
            'opened'        => [
                'created'   => 'Baru',
                'updated'   => 'Update',
                'reopend'   => 'Diulang',
            ],
            'processed'     => [
                'confirmed' => 'Dikonfirmasi',
                'delivered' => 'Dikirim',
                'paid'      => 'Dibayar',
                'returned'  => 'Dikembalikan (full retur)',
            ],
            'closed'        => [],
            'voided'        => [],
        ],
        'marketplace'       => [
            'pos'           => 'POS',
            // 'shopee'        => 'SHOPEE',
            // 'tokopedia'     => 'TOKOPEDIA',
            // 'lazada'        => 'LAZADA',
            // 'bukalapak'     => 'BUKALAPAK',
            // 'jdid'          => 'JDID',
            // 'blibli'        => 'BLIBLI',
        ],
        'outlet'            => [],
        'flag'              => [
            'catalog'           => 'Katalog',
            'deposit'           => 'Titipan',
            'promo_catalog'     => 'Promo Produk',
            'promo_transaction' => 'Promo Transaksi',
            // 'service'           => 'Layanan',
            // 'tax'               => 'Pajak',
        ],
        'tax'               => [
            // 'PPN'           => 10,
            // 'PB1'           => 10,
        ],
        'service'           => [
            // 'Charge'       => 10,
            // 'Pengiriman'    => 0,
        ],
        'deposit'           => [
            'Ongkir'        => 0,
            'Asuransi'      => 0,
            'Ganti Uang'    => 100,
        ],
        'can_print'         => [
            0               => 'Bermasalah',
            1               => 'Tidak Bermasalah',
        ],
        'item_model'        => 'Lacunose\\Warehouse\\Models\\Item',
        'item_url'          => '/api/warehouse/item/submitted',
        'catalog_url'       => '/api/sale/catalog/published',
        'promo_url'         => '/api/sale/promo/published',
        'good_model'        => 'Lacunose\\Manufacture\\Models\\Good',
        'good_url'          => '/api/manufacture/good/published',
    ],
    'color' => [
        'catalog'       => [
            'unpublished'   => 'warning',
            'published'     => 'primary',
            'archived'      => 'danger',
        ],
        'promo'         => [
            'inactivated'   => 'warning',
            'activated'     => 'primary',
        ],
        'transaction'   => [
            'opened'        => 'warning',
            'processed'     => 'warning',
            'closed'        => 'primary',
            'voided'        => 'danger',
        ],
    ],
    'default'       => [
        'order'     => ['warehouse' => 'nakoa', 'is_printed' => true],
    ],
    'setting'       => [
        'business'  => 'nakoa',
        'per_page'  => 80,
    ],
    'title'         => [
        'report'    => [
            'customer'  => 'Pelanggan',
            'catalog'   => 'Trend produk',
            'palate'    => 'Preferensi produk',
            'sold'      => 'Penjualan (produk)',
            'category'  => 'Penjualan (kategori)',
            'payment'   => 'Penjualan (pembayaran)',
        ],
    ],
];
