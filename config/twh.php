<?php

return [
    'scopes'    => [
        'twh.document.masuk'        => 'Handle stok masuk',
        'twh.document.keluar'       => 'Handle stok keluar',
        'twh.document.inhouse'      => 'Handle stok inhouse',
        'twh.conversion.repack'     => 'Handle konversi untuk repack item',
        'twh.conversion.unpack'     => 'Handle konversi untuk unpack item',
        'twh.report.opname'         => 'Melihat laporan rekomendasi opname',
        'twh.report.procure'        => 'Melihat laporan rekomendasi po',
        'twh.report.stock'          => 'Melihat laporan kartu stok',
        'twh.report.spoiled'        => 'Melihat laporan item keluar (Basi)',
        'twh.report.expired'        => 'Melihat laporan item keluar (Kadaluarsa)',
        'twh.report.defected'       => 'Melihat laporan item keluar (Cacat)',
        'twh.report.lost'           => 'Melihat laporan item keluar (Hilang)',
        'twh.report.unidentified'   => 'Melihat laporan item keluar (Tidak jelas)',
        'twh.timer.packing'         => 'Melihat laporan performa packing',
        'twh.timer.unpacking'       => 'Melihat laporan performa unpacking',
        'twh.setting.item'          => 'Mengatur item',
        'twh.document.approved'     => 'Approval surat jalan',
    ],
    'logo'      => 'https://thunderlab.id/storage/app/uploads/public/5f7/ae8/123/5f7ae81237a56599536208.png',
    'name'      => 'THUNDERLAB',
    'url'       => 'https://thunderlab.id',
    'email'     => 'hello@thunderlab.id',
    'whatsapp'  => '+62.895.8100.00500',
    'address'   => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
    'glossary'  => [
        'item'      => [
            'drafted'   => 'Belum Aktif',
            'submitted' => 'Sudah Aktif',
            'archived'  => 'Diarsipkan',
        ],
        'conversion'=> [
            'drafted'   => 'Inbox',
            'actived'   => 'Sudah Aktif',
            'archived'  => 'Diarsipkan',
        ],
        'document'  => [
            'masuk'     => [
                'opened'    => 'Inbox',
                'processed' => 'Dalam Proses',
                'closed'    => 'Selesai',
                'voided'    => 'Dibatalkan',
            ],
            'keluar'    => [
                'opened'    => 'Inbox',
                'processed' => 'Dalam Proses',
                'closed'    => 'Selesai',
                'voided'    => 'Dibatalkan',
            ],
            'inhouse'   => [
                'opened'    => 'Inbox',
                'processed' => 'Dalam Proses',
                'closed'    => 'Selesai',
                'voided'    => 'Dibatalkan',
            ],
        ],
        'timer'     => [
            'packing'   => 'Pengemasan',
            'shipped'   => 'Pengiriman',
        ],
    ],
    'opsi'      => [
        'method'        => [
            'FEFO'      => 'FEFO',
            'FIFO'      => 'FIFO',
            'LIFO'      => 'LIFO',
        ],
        'type'          => [
            'masuk'     => [
                'receiving'     => 'Receiving',
                'restock_order' => 'Restock Order',
                'sales_returned'=> 'Sales Returned',
            ],
            'keluar'    => [
                'delivery_order'    => 'Delivery Order',
                'store_requisition' => 'Store Requisition',
                'procure_returned'  => 'Procure Returned',
            ],
            'inhouse'   => [
                'opname'        => 'Opname',
                'movement'      => 'Movement',
            ],
        ],
        'step' => [
            'processed'     => [
                'approved'  => 'Persetujuan',
                'stocked'   => 'Pencatatan',
                'declined'  => 'Penolakan',
            ],
        ],
        'note'          => [
            'spoiled'       => 'Basi',
            'expired'       => 'Kadaluarsa',
            'defected'      => 'Cacat',
            'lost'          => 'Hilang',
            'missed'        => 'Tertukar',
            'unidentified'  => 'Tidak jelas',
        ],
        'warehouse'     => [],
        'item_url'      => '/api/warehouse/item/submitted',
        'material_url'  => '/api/manufacture/resource/submitted',
    ],
    'color'     => [
        'item'          => [
            'drafted'   => 'warning',
            'submitted' => 'primary',
            'archived'  => 'danger',
        ],
        'conversion'    => [
            'drafted'   => 'warning',
            'actived'   => 'primary',
            'archived'  => 'danger',
        ],
        'document'      => [
            'opened'    => 'warning',
            'processed' => 'warning',
            'closed'    => 'primary',
            'voided'    => 'danger',
        ],
    ],
    'default'   => [
        'stock'     => ['owner' => 'default'],
    ],
    'setting'   => [
        'document_batch'=> ['inhouse', 'masuk', 'keluar'],
        'per_page'      => 80
    ],
    'title'     => [
        'timer'     => [
            'packing'       => 'Perfoma Packing',
            'unpacking'     => 'Perfoma Unpacking',
        ],
        'report'    => [
            'spoiled'       => 'Item Basi',
            'expired'       => 'Item Kadaluarsa',
            'defected'      => 'Item Cacat',
            'lost'          => 'Item Hilang',
            'missed'        => 'Item Tertukar',
            'unidentified'  => 'Item Tidak jelas',
        ],
    ],
];
