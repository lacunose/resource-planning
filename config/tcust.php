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
            'tcust.account.verified'    => 'Total Point',
        ],
        'param'       => [
            'ux_bill'           => 'Total belanja',
            'ux_paid'           => 'Total bayar',
            'verified_balance'  => 'Total point terverifikasi',
        ],
        'target'       => [
            'tcust.account.verified'    => 'Berikan Point',
            'tsale.promo.duplicated'    => 'Redeem Voucher (Coupon, Gift Card, Warranty)',
        ],
        'field'       => [
            'currency'  => 'Currency',
            'code'      => 'Kode',
        ],
        'currency'      => [
            'nakoin'    => 'nakoin',
            'idr'       => 'idr',
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
