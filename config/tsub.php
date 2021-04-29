<?php

return [
    'support'       => [
        'scopes'    => ['tsale', 'twh', 'tmf', 'tproc', 'tswirl'],
        // 'scopes'    => ['tsale', 'tcust', 'twh', 'tmf', 'tproc', 'tfin', 'tswirl'],
    ],
    'scopes'        => [
        'tsub.subscription.professional'    => 'Handle langganan pro',
        'tsub.subscription.exclusive'       => 'Handle langganan x',
        'tsub.bill.paid'                    => 'Melihat laporan tagihan lunas',
        'tsub.bill.unpaid'                  => 'Melihat laporan tagihan pending',
        'tsub.subscription.paid'            => 'Pelunasan tagihan manual',
        'tsub.setting.package'              => 'Mengatur paket langganan',
    ],
    'logo'      => 'https://basil.id/skin/assets/images/logo/logo-dark.png',
    'name'      => 'PT THUNDER LABS INDONESIA',
    'url'       => 'https://thunderlab.id',
    'email'     => 'hello@thunderlab.id',
    'whatsapp'  => '+62.896.7200.7400',
    'business'  => 'thunderlab',
    'address'   => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65141',
    'glossary'  => [
        'package'       => [
            'unpublished'   => 'Tidak ditampilkan',
            'published'     => 'Ditampilkan',
        ],
        'subscription'  => [
            'actived'       => 'Aktif',
            'inactived'     => 'Tidak aktif',
        ],
        'period'        => [
            'daily'         => 'Hari',
            'monthly'       => 'Bulan',
            'yearly'        => 'Tahun',
        ],
        'domain'        => [
            'tacl'          => 'Akses', 
            'tsub'          => 'Langganan',
            'tsale'         => 'Penjualan', 
            'tcust'         => 'Pelanggan',
            'twh'           => 'Persediaan', 
            'tmf'           => 'Produksi', 
            'tproc'         => 'Pembelian', 
            'tfin'          => 'Keuangan', 
            'tswirl'        => 'Bisnis', 
        ],
    ],
    'opsi'      => [
        'membership'    => [
            'professional'  => 'Pro',
            'exclusive'     => 'X',
        ],
        'period'        => [
            'daily'         => 'Harian',
            'monthly'       => 'Bulanan',
            'yearly'        => 'Tahunan',
        ],
        'flag'          => [
            'feature'       => 'Fitur',
            'rent'          => 'Sewa',
            'support'       => 'Layanan Support',
            // 'penalty'       => 'Denda',
        ],
        'client'        => [
            //THUNDER, MANAGEMENT, MANAGERS, WEB, 01
            'TMDW01'        => 'Web Dashboard Management',
            //THUNDER, OPERATIONAL, GUDANG, WEB, 01
            'TOGW01'        => 'Web Tools Gudang',
            //THUNDER, OPERATIONAL, SALE, DESKTOP WINDOWS, 01
            'TOSW01'        => 'Windows Apps POS',
            //THUNDER, MANAGEMENT, TEAM, ANDROID, 01
            'TMTA01'        => 'Android Apps Team',
            //THUNDER, MANAGEMENT, CUSTOMER, ANDROID, 01
            'TMCA01'        => 'Android Apps Customer',
        ],
    ],
    'color'     => [
        'package'       => [
            'unpublished'   => 'warning',
            'published'     => 'primary',
            'archived'      => 'danger',
        ],
        'subscription'  => [
            'actived'       => 'primary',
            'inactived'     => 'danger',
        ],
    ],
    'setting'   => [
        'due_days'  => 7,
        'per_page'  => 80
    ],
    'title'     => [
        'bill'      => ['unpaid' => 'Tagihan Pending', 'paid' => 'Tagihan Lunas'],
    ],
];
