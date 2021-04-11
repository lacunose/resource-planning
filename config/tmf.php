<?php

return [
    'scopes'    => [
        'tmf.document.persediaan'   => 'Handle pesanan untuk persediaan',
        'tmf.document.penjualan'    => 'Handle pesanan untuk penjualan',
        'tmf.document.checker'      => 'Handle checker pesanan',
        'tmf.laporan.station'       => 'Melihat laporan performa station',
        'tmf.laporan.ratio'         => 'Melihat laporan rasio menu',
        'tmf.menu.setting'          => 'Mengatur menu',
        'tmf.document.archived'       => 'Approval void document',
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
        'menu'      => [
            'unpublished'   => 'Tidak ditampilkan',
            'published'     => 'Ditampilkan',
        ],
        'document'     => [
            'drafted'   => 'Belum Dikerjakan',
            'submitted' => 'Sedang Dikerjakan',
            'locked'    => 'Sudah Dikerjakan',
            'archived'  => 'Dibatalkan',
        ],
    ],
    'opsi'  => [
        'period'        => [
            'daily'     => 'Harian',
            'monthly'   => 'Bulanan',
            'yearly'    => 'Tahunan',
        ],
        'day'           => [
            '*'         => 'Hari',
            'sunday'    => 'Minggu',
            'monday'    => 'Senin',
            'tuesday'   => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday'  => 'Kamis',
            'friday'    => 'Jumat',
            'saturday'  => 'Sabtu',
        ],
        'type'          => [
            'free'      => 'Produk Saja',
            'item'      => 'Item Stok',
            'menu'      => 'Station Menu',
        ],
        'warehouse'         => [],
        'item_model'        => 'Lacunose\\Warehouse\\Models\\Item',
        'item_url'          => '/api/warehouse/item/submitted',
        'menu_url'          => '/api/manufacture/menu/submitted',
    ],
    'color' => [
        'menu'              => [
            'unpublished'   => 'warning',
            'published'     => 'primary',
            'archived'      => 'danger',
        ],
        'document'          => [
            'drafted'       => 'warning',
            'submitted'     => 'warning',
            'locked'        => 'primary',
            'archived'      => 'danger',
        ],
    ],
    'default'       => [
        'document'  => ['warehouse' => 'nakoa', 'is_printed' => true],
    ],
    'setting'       => [
        'per_page'  => 80,
    ],
    'title'         => [
        'report'    => ['station' => 'Perfroma Station', 'ratio' => 'Rasio Menu'],
    ],
];
