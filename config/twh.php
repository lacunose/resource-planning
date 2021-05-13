<?php

return [
    'scopes'    => [
<<<<<<< HEAD
        'twh.document.masuk'        => 'Handle stok masuk',
        'twh.document.keluar'       => 'Handle stok keluar',
        'twh.document.inhouse'      => 'Handle stok inhouse',
=======
        'twh.task.index'            => 'Handle Task',
        'twh.document.index'        => 'Handle Dokumen',
        'twh.record.index'          => 'Handle Paket',
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
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
<<<<<<< HEAD
        'twh.document.approved'     => 'Approval surat jalan',
=======
        'twh.task.approved'         => 'Approval surat jalan',
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
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
<<<<<<< HEAD
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
            'unpacking' => 'Sortir',
            'packing'   => 'Pengemasan',
            'shipped'   => 'Pengiriman',
=======
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
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
        ],
    ],
    'opsi'      => [
        'method'        => [
            'FEFO'      => 'FEFO',
            'FIFO'      => 'FIFO',
            'LIFO'      => 'LIFO',
        ],
<<<<<<< HEAD
        'type'          => [
            'masuk'     => [
                'receiving'     => 'Receiving',
                'restock_order' => 'Restock Order',
                'sales_returned'=> 'Sales Returned',
            ],
            'keluar'    => [
                'delivery_order'    => 'Delivery Order',
                'dispatch_note'     => 'Dispatch Note',
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
=======
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
        'lot'           => ['kitchen' => 'kitchen', 'pending' => 'pending'],
        'owner'         => ['nakoa' => 'nakoa'],
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
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
<<<<<<< HEAD
        'document'      => [
=======
        'task'      => [
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
            'opened'    => 'warning',
            'processed' => 'warning',
            'closed'    => 'primary',
            'voided'    => 'danger',
        ],
<<<<<<< HEAD
    ],
    'default'   => [
        'stock'     => ['owner' => 'nakoa'],
    ],
    'setting'   => [
        'document_batch'=> ['inhouse', 'masuk', 'keluar'],
=======
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
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
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
