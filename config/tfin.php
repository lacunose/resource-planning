<?php

return [
    'scopes'    => [
        'tfin.cashier.pemasukan'      => 'Handle transaksi pemasukan',
        'tfin.cashier.pengeluaran'    => 'Handle transaksi pengeluaran',
        'tfin.book.transaksi'         => 'Handle catatan transaksi',
        'tfin.book.memorial'          => 'Handle catatan memorial',
        'tfin.asset.berwujud'         => 'Handle aset berwujud',
        'tfin.asset.tidak_berwujud'   => 'Handle aset tidak berwujud',
        'tfin.laporan.jurnal'         => 'Melihat laporan buku besar',
        'tfin.laporan.neraca'         => 'Melihat laporan neraca',
        'tfin.laporan.labarugi'       => 'Melihat laporan laba/rugi',
        'tfin.setting.coa'            => 'Mengatur Akun Perkiraan',
        'tfin.setting.jurnal'         => 'Mengatur pengaturan jurnal otomatis',
    ],
    'logo'          => 'https://thunderlab.id/storage/app/uploads/public/5f7/ae8/123/5f7ae81237a56599536208.png',
    'name'          => 'THUNDERLAB',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.895.8100.00500',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
    // 'mode'          => 'local',
    'mode'          => 'tenant',
    'get_item'      => 80,
    'glossary'      => [
        'coa'       => [
            'actived'   => 'Aktif',
            'archived'  => 'Arsip',
        ],
        'asset'     => [
            'drafted'   => 'Inbox',
            'actived'   => 'Sudah Aktif',
            'disposed'  => 'Dihapus',
        ],
        'book'      => [
            'drafted'   => 'Inbox',
            'journaled' => 'Sudah Dijurnal',
            'locked'    => 'Sudah Dikunci',
            'archived'  => 'Diarsipkan',
        ],
        'cashier'  => [
            'opened'    => 'Pending',
            'closed'    => 'Lunas',
            'voided'    => 'Batal',
        ],
    ],
    'opsi'          => [
        'period'    => [
            'daily'     => 'Harian',
            'monthly'   => 'Bulanan',
            'yearly'    => 'Tahunan',
        ],
        'method'    => [
            'flat'     => 'Flat',
            'effective'=> 'Efektif',
            'annuity'  => 'Anuitas',
        ],
        'coa_type'  => [
            'CURRENT ASSETS'        => 'CURRENT ASSETS',
            'LONG TERM INVESTMENTS' => 'LONG TERM INVESTMENTS',
            'FIXED ASSETS'          => 'FIXED ASSETS',
            'INTAGIBLE FIXED ASSETS'=> 'INTAGIBLE FIXED ASSETS',
            'CURRENT LIABILITIES'   => 'CURRENT LIABILITIES',
            'LONG TERM LIABILITIES' => 'LONG TERM LIABILITIES',
            'CAPITALS'              => 'CAPITALS',
        ],
        'coa_group'     => [
            'assets'        => 'Aktiva',
            'liabilities'   => 'Pasiva',
            'equity'        => 'Modal',
            'revenues'      => 'Pendapatan',
            'expenses'      => 'Pengeluaran',
        ],
        'flag'    => [
            'plafon'    => 'Pinjaman',
            'interest'  => 'Bunga',
            'fee'       => 'Biaya',
        ],
        'branch'    => [
            'default'   => 'Default',
        ],
    ],
    'color'     => [
        'coa'   => [
            'actived'   => 'primary',
            'archived'  => 'danger',
        ],
        'asset' => [
            'drafted'   => 'warning',
            'actived'   => 'primary',
            'disposed'  => 'danger',
        ],
        'book'  => [
            'drafted'   => 'warning',
            'journaled' => 'warning',
            'locked'    => 'primary',
            'archived'  => 'danger',
        ],
    ],
    'setting'       => [
        'currency'  => 'IDR',
        'per_page'  => 80
    ],
];
