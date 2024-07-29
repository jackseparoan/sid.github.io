<?php
// -------------------------------------------------------------------------
//
// Letakkan username, password dan database sebetulnya di file ini.
// File ini JANGAN di-commit ke GIT. TAMBAHKAN di .gitignore
// -------------------------------------------------------------------------

// Data Konfigurasi MySQL yang disesuaikan

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = 'eyJpdiI6Impia3JPRW9JZ1BlWnZjMGl3aXFLRGc9PSIsInZhbHVlIjoiMSsxU1JqTEFIY09aSC9QaGhZRmtjQT09IiwibWFjIjoiNTc1NTA5NDU1ZjY3NGNjNzJkYzIzZmE2MjFlYjQ4MTNmYWUyYjdiZTQ5MDZkOWUwNDFiM2RhYjUxNGQwZDEzYyIsInRhZyI6IiJ9';
$db['default']['port']     = 3306;
$db['default']['database'] = 'si-desa';
$db['default']['dbcollat'] = 'utf8_general_ci';

/*
| Untuk setting koneksi database 'Strict Mode'
| Sesuaikan dengan ketentuan hosting
*/
$db['default']['stricton'] = true;