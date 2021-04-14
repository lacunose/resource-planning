<?php

return [
    'scopes'    => [
        'tfin.cashier.pemasukan'      => 'Handle transaksi pemasukan',
        'tfin.cashier.pengeluaran'    => 'Handle transaksi pengeluaran',
        'tfin.book.transaksi'         => 'Handle catatan transaksi',
        'tfin.book.memorial'          => 'Handle catatan memorial',
        'tfin.asset.depresiasi'       => 'Handle otomasi depresiasi',
        'tfin.asset.amortisasi'       => 'Handle otomasi amortisasi',
        'tfin.report.jurnal'         => 'Melihat report buku besar',
        'tfin.report.neraca'         => 'Melihat report neraca',
        'tfin.report.labarugi'       => 'Melihat report laba/rugi',
        'tfin.setting.coa'            => 'Mengatur Akun Perkiraan',
        'tfin.setting.jurnal'         => 'Mengatur pengaturan jurnal otomatis',
    ],
    'logo'          => 'https://thunderlab.id/storage/app/uploads/public/5f7/ae8/123/5f7ae81237a56599536208.png',
    'name'          => 'THUNDERLAB',
    'url'           => 'https://thunderlab.id',
    'email'         => 'hello@thunderlab.id',
    'whatsapp'      => '+62.895.8100.00500',
    'address'       => 'VERNON BUILDING, Jln. Letjen Sutoyo No. 102A, Kota Malang, Jawa Timur, Indonesia 65145',
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
        'currency'  => [
            'IDR'       => 'IDR',
        ],
        'method'    => [
            'flat'     => 'Flat',
            'effective'=> 'Efektif',
            'annuity'  => 'Anuitas',
        ],
        'coa_tag'   => [
            'Kas & Bank'    => 'Kas & Bank',
            'Akun Piutang'  => 'Akun Piutang',
            'Persediaan'    => 'Persediaan',
            'Aktiva Lancar Lainnya'     => 'Aktiva Lancar Lainnya',
            'Aktiva Tetap'              => 'Aktiva Tetap',
            'Depresiasi & Amortisasi'   => 'Depresiasi & Amortisasi',
            'Aktiva Lainnya'            => 'Aktiva Lainnya',
            'Akun Hutang'               => 'Akun Hutang',
            'Kewajiban Lancar Lainnya'  => 'Kewajiban Lancar Lainnya',
            'Kewajiban Jangka Panjang'  => 'Kewajiban Jangka Panjang',
            'Ekuitas'                   => 'Ekuitas',
            'Pendapatan'                => 'Pendapatan',
            'Harga Pokok Penjualan'     => 'Harga Pokok Penjualan',
            'Beban'                     => 'Beban',
            'Pendapatan Lainnya'        => 'Pendapatan Lainnya',
            'Beban Lainnya'             => 'Beban Lainnya',
        ],
        'coa_group'     => [
            'asset'         => 'Aktiva',
            'liability'     => 'Pasiva',
            'equity'        => 'Modal',
            'revenue'       => 'Pendapatan',
            'expense'       => 'Pengeluaran',
        ],
        'flag'    => [
            'fee'       => 'Biaya',
            'plafon'    => 'Pinjaman',
            'interest'  => 'Bunga',
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
        'round'     => 100,
        'per_page'  => 80
    ],
];
