<?php

return [
    'scopes'    => [
        'tproc.transaction.pembelian'   => 'Handle transaksi pembelian',
        'tproc.transaction.konsinyasi'  => 'Handle transaksi konsinyasi',
        'tproc.transaction.voided'      => 'Approval void transaksi',
    ],
    'logo'          => 'https://thunderlab.id/storage/app/uploads/public/5f7/ae8/123/5f7ae81237a56599536208.png',
    'name'          => 'THUNDERLAB',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.895.8100.00500',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
    'glossary'      => [
        'transaction'  => [
            'opened'    => 'Inbox',
            'processed' => 'Dalam Proses',
            'closed'    => 'Selesai',
            'voided'    => 'Dibatalkan',
        ],
        'step'          => [
            'created'   => 'Baru',
            'updated'   => 'Update',
            'reopened'  => 'Diulang',
            'confirmed' => 'Konfirmasi',
            'delivered' => 'Diterima',
            'paid'      => 'Dibayar',
            'returned'  => 'Dikembalikan (retur)',
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
        'step' => [
            'processed'     => [
                'delivered'     => 'Dikirim',
                'paid'          => 'Dibayar',
                'returned'      => 'Dikembalikan (retur)',
            ],
        ],
        'event' => [
            'opened'        => [
                'created'   => 'Baru',
                'updated'   => 'Update',
                'reopened'  => 'Diulang',
            ],
            'processed'     => [
                'confirmed' => 'Dikonfirmasi',
                'delivered' => 'Diterima',
                'paid'      => 'Dibayar',
                'returned'  => 'Dikembalikan (retur)',
            ],
            'closed'        => [],
            'voided'        => [],
        ],
        'mode'          => [
            'pembelian'     => 'Pembelian',
            'konsinyasi'    => 'Konsinyasi',
        ],
        'branch'    => [],
        'flag'          => [
            'misc'      => 'Lainnya',
            'catalog'   => 'Stok',
            // 'asset'     => 'Inventaris',
            // 'deposit'           => 'Deposit',
            // 'tax'               => 'Pajak',
        ],
        'can_print'         => [
            0               => 'Bermasalah',
            1               => 'Tidak Bermasalah',
        ],
        'method'            => [[
            'method'        => 'Cash',
            'min_amount'    => 0,
        ],[
            'method'        => 'Bank Transfer',
            'min_amount'    => 0,
        ]],
        'item_model'        => 'Lacunose\\Warehouse\\Models\\Item',
        'item_url'          => '/api/warehouse/item/submitted',
        'catalog_url'       => '/api/warehouse/item/submitted',
    ],
    'color' => [
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
        'report'    => [
            'vendor'    => 'Vendor', 
            'price'     => 'Harga Barang', 
            'payment'   => 'Settlement Pembelian'
        ],
    ],
];
