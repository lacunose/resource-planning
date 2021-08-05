<?php

return [
    'scopes'    => [
        'twh.task.index'            => 'Handle Task',
        'twh.document.index'        => 'Handle Dokumen',
        'twh.record.index'          => 'Handle Paket',
        // 'twh.conversion.repack'     => 'Handle konversi untuk repack item',
        // 'twh.conversion.unpack'     => 'Handle konversi untuk unpack item',
        'twh.setting.item'          => 'Mengatur item',
        'twh.task.approved'         => 'Approval surat jalan',
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
            'archived'  => 'Arsip',
        ],
        'conversion'=> [
            'drafted'   => 'Belum Aktif',
            'actived'   => 'Sudah Aktif',
            'archived'  => 'Arsip',
        ],
        'task'  => [
            'opened'    => 'Inbox',
            'processed' => 'Dalam Proses',
            'closed'    => 'Selesai',
            'voided'    => 'Batal',
        ],
        'document'  => [
            'created'   => 'Selesai',
            'voided'    => 'Batal',
        ],
        'record'  => [
            'started'   => 'Mulai',
            'ended'     => 'Selesai',
            'voided'    => 'Batal',
        ],
    ],
    'opsi'      => [
        'method'        => [
            'FEFO'      => 'FEFO',
            'FIFO'      => 'FIFO',
            'LIFO'      => 'LIFO',
        ],
        'task'  => [
            'type'      => [
                'inbound'   => 'Inbound',
                'outbond'   => 'Outbond',
                'daily'     => 'Daily',
                'requisite' => 'Requisite',
                'opname'    => 'Opname',
            ]
        ],
        'document'  => [
            'type'      => [
                'putaway'   => 'Putaway',
                'dispatch'  => 'Dispatch',
                'movement'  => 'Movement',
                'dispose'   => 'Dispose',
                'cutoff'    => 'Cutoff',
            ],
            'note'      => [
                'spoiled'       => 'Basi',
                'expired'       => 'Kadaluarsa',
                'defected'      => 'Cacat',
                'lost'          => 'Hilang',
                'missed'        => 'Tertukar',
                'unidentified'  => 'Tidak jelas',
            ],
        ],
        'record'    => [
            'type'      => [
                'packing'   => 'Packing',
                'shipping'  => 'Shipping',
                'receiving' => 'Receiving',
            ],
        ],
        'step' => [
            'outbond'   => [
                'document'  => 'Stok',
                'record'    => 'Paket',
            ],
            'inbound'   => [
                'document'  => 'Stok',
                'record'    => 'Paket',
            ],
            'requisite' => [
                'document'  => 'Stok',
            ],
            'opname'    => [
                'document'  => 'Stok',
            ],
        ],
        'warehouse'     => [],
        'lot'           => ['default' => 'default', 'pending' => 'pending'],
        'owner'         => ['nakoa' => 'nakoa'],
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
        'task'      => [
            'opened'    => 'warning',
            'processed' => 'warning',
            'closed'    => 'primary',
            'voided'    => 'danger',
        ],
        'document'  => [
            'created'   => 'primary',
            'voided'    => 'danger',
        ],
        'record'    => [
            'started'   => 'warning',
            'ended'     => 'primary',
            'voided'    => 'danger',
        ],
    ],
    'default'   => [],
    'setting'   => [
        'task_batch'=> ['inhouse', 'masuk', 'keluar'],
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
