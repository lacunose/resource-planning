<?php

return [
    'scopes'        => [
        'tcust.account.data'        => 'Handle data akun',
        'tcust.account.verified'    => 'Verifikasi transaksi manual',
        'tcust.setting.customer'    => 'Mengatur anggota',
        'tcust.setting.program'     => 'Mengatur program',
        'tcust.log.verified'        => 'Melihat transaksi verified',
        'tcust.log.pending'         => 'Melihat transaksi pending',

    ],
    'logo'          => 'https://basil.id/skin/assets/images/logo/logo-dark.png',
    'name'          => 'PT THUNDER LABS INDONESIA',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.896.7200.7400',
    'business'      => 'thunderlab',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65141',
    // 'mode'          => 'local',
    'mode'          => 'tenant',
    'glossary'      => [
        'customer'  => [
            'actived'    => 'Aktif',
            'inactived'  => 'Tidak aktif',
        ],
        'program'   => [
            'unpublished'   => 'Tidak ditampilkan',
            'published'     => 'Ditampilkan',
        ],
        'account'  => [
            'opened'    => 'Aktif',
            'closed'    => 'Tidak aktif',
        ],
        'period'        => [
            'never'     => '-',
            'daily'     => 'Hari',
            'monthly'   => 'Bulan',
            'yearly'    => 'Tahun',
        ],
    ],
    'opsi'              => [
        'mode'          => [
            'point'     => 'Point',
            'deposit'   => 'Deposit',
        ],
        'period'        => [
            'never'     => '-',
            'daily'     => 'Harian',
            'monthly'   => 'Bulanan',
            'yearly'    => 'Tahunan',
        ],
        'trigger'       => [
            'tsale.transaction.closed'  => 'Belanja',
            'tcust.account.verified'    => 'Saldo Akun Bertambah',
        ],
        'param'         => [
            'tsale.transaction.closed'  => [
                'ux_bill'   => 'Total belanja',
                'ux_paid'   => 'Total bayar',
            ],
            'tcust.account.verified'    => [
                'verified_balance'      => 'Total point terverifikasi',
            ],
        ],
        'target'        => [
            'tcust.account.granted'     => 'Tambahkan Saldo Akun',
            'tsale.promo.duplicated'    => 'Redeem Voucher',
        ],
        'field'         => [
            'tcust.account.granted'  => [
                'currency'  => 'Currency',
            ],
            'tsale.promo.duplicated'  => [
                'code'      => 'Kode',
            ],
        ],
        'currency'      => [
            'nakoin'    => 'nakoin',
            'idr'       => 'idr',
        ],
        'catalog_url'   => '/api/sale/katalog/published',
        'program_url'   => '/api/customer/program/published',
        'mark'          => [
            'favorite'  => 'Favorit',
            'wishlist'  => 'Wishlist',
        ],
    ],
    'color'         => [
        'customer'      => [
            'actived'       => 'primary',
            'inactived'     => 'danger',
        ],
        'program'           => [
            'unpublished'   => 'warning',
            'published'     => 'primary',
            'archived'      => 'danger',
        ],
        'account'       => [
            'opened'    => 'primary',
            'closed'    => 'danger',
        ],
    ],
    'setting'       => [
        'due_days'  => 7,
        'per_page'  => 80
    ],
    'title'         => [
        'log'       => ['pending' => 'Transaksi Pending', 'verified' => 'Transaksi Verifikasi'],
    ],
];
