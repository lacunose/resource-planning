<?php

return [
    'scopes'    => [
        'twh.document.masuk'    => 'Handle stok masuk',
        'twh.document.keluar'   => 'Handle stok keluar',
        'twh.document.inhouse'  => 'Handle stok inhouse',
        'twh.conversion.repack' => 'Handle konversi untuk repack item',
        'twh.conversion.unpack' => 'Handle konversi untuk unpack item',
        'twh.report.opname'     => 'Melihat laporan rekomendasi opname',
        'twh.report.procure'    => 'Melihat laporan rekomendasi po',
        'twh.report.stock'      => 'Melihat laporan kartu stok',
        'twh.report.owner'      => 'Melihat laporan kepemilikan stok',
        'twh.timer.packing'     => 'Melihat laporan performa packing',
        'twh.timer.unpacking'   => 'Melihat laporan performa unpacking',
        'twh.setting.item'      => 'Mengatur item',
        'twh.document.submitted'=> 'Approval surat jalan',
    ],
    'logo'          => 'https://thunderlab.id/storage/app/uploads/public/5f7/ae8/123/5f7ae81237a56599536208.png',
    'name'          => 'THUNDERLAB',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.895.8100.00500',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
    'glossary'      => [
        'item'      => [
            'drafted'   => 'Belum Aktif',
            'submitted' => 'Sudah Aktif',
            'archived'  => 'Diarsipkan',
        ],
        'conversion'    => [
            'drafted'   => 'Inbox',
            'actived'   => 'Sudah Aktif',
            'archived'  => 'Diarsipkan',
        ],
        'document'  => [
            'masuk'         => [
                'drafted'   => 'Inbox',
                'stocked'   => 'Sudah Dibuka',
                'submitted' => 'Sudah Dilabeli',
                'locked'    => 'Sudah Selesai',
                'archived'  => 'Diarsipkan',
            ],
            'keluar'        => [
                'drafted'   => 'Inbox',
                'stocked'   => 'Sudah Disiapkan',
                'submitted' => 'Sudah Dicek',
                'locked'    => 'Sudah Selesai',
                'archived'  => 'Diarsipkan',
            ],
            'inhouse'       => [
                'drafted'   => 'Inbox',
                'stocked'   => 'Sudah Dicatat',
                'submitted' => 'Sudah Dicek',
                'locked'    => 'Sudah Selesai',
                'archived'  => 'Diarsipkan',
            ],
        ],
    ],
    'opsi'  => [
        'method'    => [
            'FEFO'      => 'FEFO',
            'FIFO'      => 'FIFO',
            'LIFO'      => 'LIFO',
        ],
        'warehouse'     => [],
        'item_url'      => '/api/warehouse/item/submitted',
    ],
    'color' => [
        'item'          => [
            'drafted'   => 'warning',
            'submitted' => 'primary',
            'archived'  => 'danger',
        ],
        'conversion'        => [
            'drafted'   => 'warning',
            'actived'   => 'primary',
            'archived'  => 'danger',
        ],
        'document'      => [
            'drafted'   => 'warning',
            'stocked'   => 'warning',
            'submitted' => 'warning',
            'locked'    => 'primary',
            'archived'  => 'danger',
        ],
    ],
    'default'     => [
        'stock'   => ['owner' => 'default'],
    ],
    'setting'     => [
        'document_batch'    => ['opname', 'masuk', 'keluar'],
        'per_page'          => 80
    ],
    'title'       => [
        'timer'   => ['packing' => 'Perfomance Packer'],
        'report'  => ['owner' => 'Kepemilikan Stok'],
    ],
];
