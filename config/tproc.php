<?php

return [
    'scopes'    => [
        'tproc.transaction.pembelian' => 'Handle transaksi pembelian',
        'tproc.transaction.konsinyasi'=> 'Handle transaksi konsinyasi',
        'tproc.laporan.item'          => 'Melihat laporan harga barang',
        'tproc.laporan.payment'       => 'Melihat laporan settlement pembelian',
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
        'batch_pos'         => [],
        'batch_ecommerce'   => [
        ],
        'method'    => [
            ['method'    => 'Cash', 'min_amount' => 0],
            ['method'    => 'Transfer', 'min_amount' => 0],
        ],
        'item_url'          => '/api/warehouse/item/submitted',
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
        'order'     => ['warehouse' => 'vernon'],
    ],
    'setting'       => [
        'per_page'  => 80
    ],
    'title'         => [
        'report'    => ['payment' => 'Settlement Penjualan', 'item' => 'Harga Barang'],
    ],
];
