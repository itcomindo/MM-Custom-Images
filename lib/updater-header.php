<?php

/**
 *
 * Silence is golden
 */

defined('ABSPATH') || die('No script kiddies please!');

// ======================================================================
// KONFIGURASI UPDATER - INI SATU-SATUNYA BAGIAN YANG PERLU DIUBAH
// ======================================================================

// Ganti nilai-nilai di bawah ini sesuai dengan plugin baru Anda.
$my_plugin_slug    = 'mm-custom-images'; // Harus sama dengan slug folder/file plugin.
$my_plugin_api_url = 'https://plugins.budiharyono.com/' . $my_plugin_slug . '/info.json';

// ======================================================================
// KODE PEMANGGIL UPDATER - JANGAN UBAH BAGIAN DI BAWAH INI
// ======================================================================

// 1. Muat pustaka updater.
require_once __DIR__ . '/lib/updater.php';

// 2. Daftarkan hook aktivasi yang memanggil metode statis dari pustaka.
//    Ini mencegah konflik nama fungsi.
register_activation_hook(__FILE__, ['My_Plugin_Updater_Library', 'on_activation']);

// 3. Inisialisasi updater jika di area admin.
if (is_admin()) {
    new My_Plugin_Updater_Library(__FILE__, $my_plugin_slug, $my_plugin_api_url);
}
