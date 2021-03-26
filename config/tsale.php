<?php

return [
    'scopes'    => [
        'tsale.transaction.pos'       => 'Handle transaksi pos',
        'tsale.transaction.shopee'    => 'Handle transaksi shopee',
        'tsale.transaction.tokopedia' => 'Handle transaksi tokopedia',
        'tsale.transaction.lazada'    => 'Handle transaksi lazada',
        'tsale.transaction.bukalapak' => 'Handle transaksi bukalapak',
        'tsale.transaction.jdid'      => 'Handle transaksi jdid',
        'tsale.transaction.blibli'    => 'Handle transaksi blibli',
        'tsale.laporan.catalog'       => 'Melihat laporan trend produk',
        'tsale.laporan.customer'      => 'Melihat laporan pelanggan',
        'tsale.laporan.payment'       => 'Melihat laporan settlement penjualan',
        'tsale.promo.transaction'     => 'Mengatur promo transaksi',
        'tsale.promo.catalog'         => 'Mengatur promo produk',
        'tsale.catalog.setting'       => 'Mengatur produk',
        'tsale.catalog.listing'       => 'Mengatur catalog',
        'tsale.setting.pay'           => 'Mengatur metode pembayaran',
        'tsale.setting.note'          => 'Mengatur template note',
        'tsale.transaction.voided'    => 'Approval void transaksi',
    ],
    'logo'          => 'https://thunderlab.id/storage/app/uploads/public/5f7/ae8/123/5f7ae81237a56599536208.png',
    'name'          => 'THUNDERLAB',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.895.8100.00500',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
    // 'mode'          => 'local',
    'mode'          => 'tenant',
    'glossary'      => [
        'catalog'   => [
            'unpublished'   => 'Tidak ditampilkan',
            'published'     => 'Ditampilkan',
        ],
        'promo'   => [
            'inactivated'   => 'Tidak diaktifkan',
            'activated'     => 'Diaktifkan',
        ],
        'transaction'  => [
            'opened'    => 'Inbox',
            'processed' => 'Dalam Proses',
            'closed'    => 'Selesai',
            'voided'    => 'Dibatalkan',
        ],
    ],
    'opsi'  => [
        'period'    => [
            'daily'     => 'Harian',
            'monthly'   => 'Bulanan',
            'yearly'    => 'Tahunan',
        ],
        'day'       => [
            '*'         => 'Hari',
            'sunday'    => 'Minggu',
            'monday'    => 'Senin',
            'tuesday'   => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday'  => 'Kamis',
            'friday'    => 'Jumat',
            'saturday'  => 'Sabtu',
        ],
        'promo'     => [
            'transaction'=> [
                'ENTERTAIN'                 => 'Voucher entertain',
                'MEMBERSHIP'                => 'Diskon member',
                'COUPON'                    => 'Kupon belanja',
            ],
            'catalog'   => [
                'DISCOUNT'                  => 'Diskon',
                'BUY_AND_PAY'               => 'Beli x, Bayar y',
                'BUY_AND_SAVE'              => 'Beli x, Diskon y',
            ],
        ],
        'marketplace'       => [
            'pos'           => 'POS',
        ],
        'outlet'            => [],
        'flag'              => [
            'service'           => 'Jasa',
            'catalog'           => 'Katalog',
            'promo_catalog'     => 'Promo Produk',
            'promo_transaction' => 'Promo Transaksi',
            'deposit'           => 'Deposit',
            'tax'               => 'Pajak',
        ],
        'tax'               => [
            // 'ppn'           => 10,
            'pb1'           => 10,
        ],
        'service'           => [
            'service'       => 10,
        ],
        'can_print'         => [
            0               => 'Bermasalah',
            1               => 'Tidak Bermasalah',
        ],
        'item_model'        => 'Lacunose\\Warehouse\\Models\\Item',
        'item_url'          => '/api/warehouse/item/submitted',
        'catalog_url'       => '/api/sale/katalog/published',
    ],
    'color' => [
        'catalog'           => [
            'unpublished'   => 'warning',
            'published'     => 'primary',
            'archived'      => 'danger',
        ],
        'promo'           => [
            'inactivated'   => 'warning',
            'activated'     => 'primary',
        ],
        'transaction'  => [
            'opened'    => 'warning',
            'processed' => 'warning',
            'closed'    => 'primary',
            'voided'    => 'danger',
        ],
    ],
    'default'       => [
        'order'     => ['warehouse' => 'nakoa', 'is_printed' => true],
    ],
    'setting'       => [
        'per_page'  => 80,
    ],
    'title'         => [
        'report'    => ['catalog' => 'Trend Produk', 'payment' => 'Settlement Penjualan', 'customer' => 'Pelanggan'],
    ],
];
