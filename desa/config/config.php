<?php
// ----------------------------------------------------------------------------
// Konfigurasi aplikasi dalam berkas ini merupakan setting konfigurasi tambahan
// SID. Letakkan setting konfigurasi ini di desa/config/config.php.
// ----------------------------------------------------------------------------

// Uncomment jika situs ini untuk demo. Pada demo, user admin tidak bisa dihapus
// dan username/password tidak bisa diubah

$config['demo_mode'] = true;

// Setting ini untuk menentukan user yang dipercaya. User dengan id di setting ini
// dapat membuat artikel berisi video yang aktif ditampilkan di Web.
// Misalnya, ganti dengan id = 1 jika ingin membuat pengguna admin sebagai pengguna terpecaya.
$config['user_admin'] = 0;

// Untuk menghindari masalah keamanan, Anda mungkin ingin mengonfigurasi daftar "host tepercaya".
// Contoh: ['localhost', 'my-development.com', 'my-production.com', 'subdomain.domain.com']
$config['trusted_hosts'] = [];
