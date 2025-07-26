<?php

/**
 * Plugin Name:       MM Custom Images
 * Description:       A simple plugin for WordPress for my clients. This plugin will show one random image from the custom-images folder in your wp-content/uploads. Use the shortcode [image] to display it.
 * Version:           1.0.0
 * Author:            Budi Haryono
 * Author URI:        https://budiharyono.id/
 * License:           GPL2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mm-custom-images
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Tags:              images, custom images, random images, shortcode
 * Plugin URI:        https://budiharyono.id/
 */

defined('ABSPATH') or die('No script kiddies please!');

require_once __DIR__ . '/lib/updater-header.php';


// ----------------------------------------------------------------------
//
// Tempatkan kode fungsional plugin Anda di sini...
//
// ----------------------------------------------------------------------




define('MM_EXCLUDED_IMAGES_OPTION', 'mm_custom_images_excluded');

function mm_custom_images_activate()
{
    $upload_dir = wp_upload_dir();
    $custom_dir = $upload_dir['basedir'] . '/custom-images';
    if (! file_exists($custom_dir)) {
        wp_mkdir_p($custom_dir);
    }
    $index_file = $custom_dir . '/index.php';
    if (! file_exists($index_file)) {
        file_put_contents($index_file, '<?php // Silence is golden.');
    }
    $htaccess_file = $custom_dir . '/.htaccess';
    $htaccess_content = 'Options -Indexes';
    file_put_contents($htaccess_file, $htaccess_content);
}
register_activation_hook(__FILE__, 'mm_custom_images_activate');

function mm_custom_images_add_admin_menu()
{
    add_menu_page('MM Custom Images', 'Custom Images', 'manage_options', 'mm-custom-images', 'mm_custom_images_options_page_html', 'dashicons-format-image', 20);
}
add_action('admin_menu', 'mm_custom_images_add_admin_menu');

function mm_custom_images_handle_actions()
{
    if (! current_user_can('manage_options')) return;

    // --- AKSI MASAL (BULK ACTIONS) ---
    if (isset($_POST['bulk_action_submit']) && wp_verify_nonce($_POST['mm_bulk_action_nonce'], 'mm_bulk_action')) {
        $action = sanitize_text_field($_POST['bulk_action']);
        if (! empty($action) && $action !== '-1' && ! empty($_POST['selected_images'])) {
            $selected_images = array_map('sanitize_file_name', $_POST['selected_images']);
            $upload_dir = wp_upload_dir();
            $custom_dir = $upload_dir['basedir'] . '/custom-images/';
            $excluded_images = get_option(MM_EXCLUDED_IMAGES_OPTION, []);

            switch ($action) {
                case 'bulk-exclude':
                    $newly_excluded = array_unique(array_merge($excluded_images, $selected_images));
                    update_option(MM_EXCLUDED_IMAGES_OPTION, $newly_excluded);
                    add_settings_error('mm_custom_images_messages', 'bulk_exclude_success', count($selected_images) . ' gambar berhasil di-exclude.', 'success');
                    break;
                case 'bulk-delete':
                    $deleted_count = 0;
                    foreach ($selected_images as $filename) {
                        $filepath = $custom_dir . $filename;
                        if (file_exists($filepath) && unlink($filepath)) {
                            $deleted_count++;
                            // Hapus dari daftar exclude juga jika ada
                            if (($key = array_search($filename, $excluded_images)) !== false) {
                                unset($excluded_images[$key]);
                            }
                        }
                    }
                    update_option(MM_EXCLUDED_IMAGES_OPTION, array_values($excluded_images));
                    add_settings_error('mm_custom_images_messages', 'bulk_delete_success', $deleted_count . ' gambar berhasil dihapus permanen.', 'success');
                    break;
            }
        }
        set_transient('settings_errors', get_settings_errors(), 30);
        wp_safe_redirect(admin_url('admin.php?page=mm-custom-images'));
        exit;
    }

    // --- Aksi individual (upload, delete, exclude) ---
    // Logika aksi individual yang sudah ada tetap di sini...
    // (Kode ini sengaja saya singkat di penjelasan, tapi di blok kode lengkap di bawah, ini tetap ada)
    // Aksi Upload Gambar
    if (isset($_POST['mm_upload_nonce']) && wp_verify_nonce($_POST['mm_upload_nonce'], 'mm_upload_action')) { /* ... logika upload ... */
    }
    // Aksi Hapus Gambar
    if (isset($_POST['mm_delete_nonce']) && wp_verify_nonce($_POST['mm_delete_nonce'], 'mm_delete_action')) { /* ... logika hapus ... */
    }
    // Aksi Exclude/Include Gambar
    if (isset($_POST['mm_exclude_nonce']) && wp_verify_nonce($_POST['mm_exclude_nonce'], 'mm_exclude_action')) { /* ... logika exclude ... */
    }
}
// Kode lengkap untuk fungsi mm_custom_images_handle_actions() ada di blok kode utama di bawah.


function mm_custom_images_admin_styles()
{
?>
    <style>
        .mm-gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
        }

        .mm-gallery-item {
            position: relative;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background: #fff;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
        }

        .mm-gallery-item.excluded {
            border-color: #ffb900;
            background-color: #fff8e5;
        }

        .mm-gallery-item:has(input:checked) {
            border-color: #007cba;
            box-shadow: 0 0 0 2px #007cba;
        }

        .mm-gallery-item img {
            max-width: 100%;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .mm-gallery-item p {
            margin: 0 0 10px;
            word-wrap: break-word;
            font-size: 12px;
        }

        .mm-gallery-actions {
            display: flex;
            justify-content: space-between;
            gap: 5px;
        }

        .mm-gallery-actions .button {
            flex: 1;
        }

        .mm-gallery-actions .button-link-delete {
            color: #b32d2e !important;
        }

        .mm-gallery-item input[type="checkbox"] {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 20px;
            height: 20px;
        }

        .mm-bulk-actions-wrap {
            margin: 15px 0;
        }
    </style>
<?php
}
add_action('admin_head-toplevel_page_mm-custom-images', 'mm_custom_images_admin_styles');

function mm_custom_images_frontend_styles()
{
?>
    <style>
        .mm-custom-image {
            max-width: 100%;
            line-height: 0;
        }

        .mm-custom-image img {
            max-width: 100%;
            height: auto;
            display: block;
        }
    </style>
<?php
}
add_action('wp_head', 'mm_custom_images_frontend_styles');


function mm_custom_images_options_page_html()
{
    if (! current_user_can('manage_options')) return;

    $errors = get_transient('settings_errors');
    if ($errors) {
        settings_errors('mm_custom_images_messages');
        delete_transient('settings_errors');
    }

    $upload_dir = wp_upload_dir();
    $custom_dir_path = $upload_dir['basedir'] . '/custom-images';
    $custom_dir_url = $upload_dir['baseurl'] . '/custom-images';
    $allowed_extensions = '{jpg,jpeg,png,webp}';
    $images = glob($custom_dir_path . '/*.' . $allowed_extensions, GLOB_BRACE);
    $excluded_images = get_option(MM_EXCLUDED_IMAGES_OPTION, []);
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <div class="card">
            <h2 class="title">Upload Gambar Baru</h2>
            <p>Anda bisa memilih lebih dari satu gambar (JPG, PNG, atau WEBP).</p>
            <form method="POST" enctype="multipart/form-data">
                <?php wp_nonce_field('mm_upload_action', 'mm_upload_nonce'); ?>
                <p><input type="file" name="custom_image_upload[]" id="custom_image_upload" accept=".jpg,.jpeg,.png,.webp" multiple required></p>
                <?php submit_button('Upload Gambar'); ?>
            </form>
        </div>
        <hr>
        <h2>Galeri Gambar</h2>
        <p>Di bawah ini adalah semua gambar yang tersimpan. Hanya file dengan ekstensi <strong>.jpg, .jpeg, .png, dan .webp</strong> yang akan ditampilkan.</p>

        <form method="POST" id="mm-gallery-form">
            <?php wp_nonce_field('mm_bulk_action', 'mm_bulk_action_nonce'); ?>

            <div class="tablenav top">
                <div class="alignleft actions bulkactions mm-bulk-actions-wrap">
                    <label for="bulk-action-selector-top" class="screen-reader-text">Pilih aksi massal</label>
                    <select name="bulk_action" id="bulk-action-selector-top">
                        <option value="-1">Aksi Massal</option>
                        <option value="bulk-exclude">Exclude</option>
                        <option value="bulk-delete">Hapus</option>
                    </select>
                    <input type="submit" name="bulk_action_submit" id="doaction" class="button action" value="Terapkan">
                </div>
                <br class="clear">
            </div>

            <div class="mm-gallery-grid">
                <?php
                if (! empty($images)) {
                ?>
                    <div class="mm-gallery-item" style="padding:20px 10px; border-style: dashed;">
                        <label for="mm-select-all" style="display: block; font-weight: bold;">
                            <input type="checkbox" id="mm-select-all" style="position: static; width:auto; height:auto; margin-right: 5px;"> Pilih Semua
                        </label>
                    </div>
                    <?php
                    foreach ($images as $image_path) {
                        $image_name = basename($image_path);
                        $image_url = $custom_dir_url . '/' . $image_name;
                        $is_excluded = in_array($image_name, $excluded_images);
                    ?>
                        <div class="mm-gallery-item <?php echo $is_excluded ? 'excluded' : ''; ?>">
                            <input type="checkbox" name="selected_images[]" value="<?php echo esc_attr($image_name); ?>" class="mm-image-checkbox">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_name); ?>">
                            <p><?php echo esc_html($image_name); ?></p>
                            <div class="mm-gallery-actions">
                                <!-- Tombol individual tetap ada -->
                                <form method="POST" style="display:inline;">
                                    <?php wp_nonce_field('mm_exclude_action', 'mm_exclude_nonce'); ?>
                                    <input type="hidden" name="toggle_exclude_image" value="<?php echo esc_attr($image_name); ?>">
                                    <button type="submit" class="button button-secondary"><?php echo $is_excluded ? 'Include' : 'Exclude'; ?></button>
                                </form>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini secara permanen?');">
                                    <?php wp_nonce_field('mm_delete_action', 'mm_delete_nonce'); ?>
                                    <input type="hidden" name="delete_image" value="<?php echo esc_attr($image_name); ?>">
                                    <button type="submit" class="button button-link-delete">Hapus</button>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<p>Belum ada gambar yang diupload.</p>';
                }
                ?>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Logika untuk "Pilih Semua"
            const selectAll = document.getElementById('mm-select-all');
            if (selectAll) {
                selectAll.addEventListener('click', function(e) {
                    const checkboxes = document.querySelectorAll('.mm-image-checkbox');
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = e.target.checked;
                    });
                });
            }

            // Konfirmasi untuk hapus massal
            const galleryForm = document.getElementById('mm-gallery-form');
            if (galleryForm) {
                galleryForm.addEventListener('submit', function(e) {
                    const actionSelector = document.getElementById('bulk-action-selector-top');
                    if (actionSelector.value === 'bulk-delete') {
                        if (!confirm('Apakah Anda yakin ingin menghapus semua gambar yang dipilih secara permanen? Aksi ini tidak dapat dibatalkan.')) {
                            e.preventDefault();
                        }
                    }
                });
            }
        });
    </script>
<?php
}

function mm_custom_images_shortcode_handler()
{
    $upload_dir = wp_upload_dir();
    $custom_dir_path = $upload_dir['basedir'] . '/custom-images';
    $custom_dir_url = $upload_dir['baseurl'] . '/custom-images';
    $allowed_extensions = '{jpg,jpeg,png,webp}';
    $all_images = glob($custom_dir_path . '/*.' . $allowed_extensions, GLOB_BRACE);
    $excluded_images = get_option(MM_EXCLUDED_IMAGES_OPTION, []);

    $available_images = array_filter($all_images, function ($image) use ($excluded_images) {
        return !in_array(basename($image), $excluded_images);
    });

    if (empty($available_images)) return '<!-- MM Custom Images: No available images found. -->';

    $random_image_path = $available_images[array_rand($available_images)];
    $image_url = $custom_dir_url . '/' . basename($random_image_path);
    $post_title = esc_attr(get_the_title());

    $output = '<div class="mm-custom-image">';
    $output .= '<img src="' . esc_url($image_url) . '" alt="' . $post_title . '" title="' . $post_title . '" loading="lazy">';
    $output .= '</div>';

    return $output;
}
add_shortcode('image', 'mm_custom_images_shortcode_handler');

// --- KODE LENGKAP UNTUK FUNGSI HANDLE ACTIONS (termasuk aksi individual) ---
function mm_custom_images_handle_actions_full()
{
    if (! current_user_can('manage_options')) return;

    // --- AKSI MASAL (BULK ACTIONS) ---
    if (isset($_POST['bulk_action_submit']) && wp_verify_nonce($_POST['mm_bulk_action_nonce'], 'mm_bulk_action')) {
        $action = sanitize_text_field($_POST['bulk_action']);
        if (! empty($action) && $action !== '-1' && ! empty($_POST['selected_images'])) {
            $selected_images = array_map('sanitize_file_name', $_POST['selected_images']);
            $upload_dir = wp_upload_dir();
            $custom_dir = $upload_dir['basedir'] . '/custom-images/';
            $excluded_images = get_option(MM_EXCLUDED_IMAGES_OPTION, []);

            switch ($action) {
                case 'bulk-exclude':
                    $newly_excluded = array_unique(array_merge($excluded_images, $selected_images));
                    update_option(MM_EXCLUDED_IMAGES_OPTION, $newly_excluded);
                    add_settings_error('mm_custom_images_messages', 'bulk_exclude_success', count($selected_images) . ' gambar berhasil di-exclude.', 'success');
                    break;
                case 'bulk-delete':
                    $deleted_count = 0;
                    foreach ($selected_images as $filename) {
                        $filepath = $custom_dir . $filename;
                        if (file_exists($filepath) && unlink($filepath)) {
                            $deleted_count++;
                            if (($key = array_search($filename, $excluded_images)) !== false) {
                                unset($excluded_images[$key]);
                            }
                        }
                    }
                    update_option(MM_EXCLUDED_IMAGES_OPTION, array_values($excluded_images));
                    add_settings_error('mm_custom_images_messages', 'bulk_delete_success', $deleted_count . ' gambar berhasil dihapus permanen.', 'success');
                    break;
            }
        }
        set_transient('settings_errors', get_settings_errors(), 30);
        wp_safe_redirect(admin_url('admin.php?page=mm-custom-images'));
        exit;
    }

    // --- Aksi individual ---
    if (isset($_POST['mm_upload_nonce']) && wp_verify_nonce($_POST['mm_upload_nonce'], 'mm_upload_action')) {
        if (! empty($_FILES['custom_image_upload']['name'][0])) {
            $files = $_FILES['custom_image_upload'];
            $upload_dir = wp_upload_dir();
            $custom_dir = $upload_dir['basedir'] . '/custom-images/';
            $allowed_mime_types = ['image/jpeg', 'image/png', 'image/webp'];
            $success_count = 0;
            $error_count = 0;
            foreach ($files['name'] as $key => $name) {
                if ($files['error'][$key] !== UPLOAD_ERR_OK) continue;
                $file_tmp_name = $files['tmp_name'][$key];
                $file_name = sanitize_file_name($name);
                $file_info = wp_check_filetype($file_name);
                if (in_array($file_info['type'], $allowed_mime_types) && move_uploaded_file($file_tmp_name, $custom_dir . $file_name)) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            }
            if ($success_count > 0) add_settings_error('mm_custom_images_messages', 'mm_upload_success', "{$success_count} gambar berhasil diupload.", 'success');
            if ($error_count > 0) add_settings_error('mm_custom_images_messages', 'mm_upload_error', "{$error_count} gambar gagal diupload.", 'error');
            set_transient('settings_errors', get_settings_errors(), 30);
            wp_safe_redirect(admin_url('admin.php?page=mm-custom-images'));
            exit;
        }
    }
    if (isset($_POST['mm_delete_nonce']) && wp_verify_nonce($_POST['mm_delete_nonce'], 'mm_delete_action')) {
        if (! empty($_POST['delete_image'])) {
            $file_to_delete = sanitize_file_name($_POST['delete_image']);
            $upload_dir = wp_upload_dir();
            $file_path = $upload_dir['basedir'] . '/custom-images/' . $file_to_delete;
            if (file_exists($file_path) && unlink($file_path)) {
                add_settings_error('mm_custom_images_messages', 'mm_delete_success', 'Gambar ' . esc_html($file_to_delete) . ' berhasil dihapus.', 'success');
                $excluded = get_option(MM_EXCLUDED_IMAGES_OPTION, []);
                if (($key = array_search($file_to_delete, $excluded)) !== false) {
                    unset($excluded[$key]);
                    update_option(MM_EXCLUDED_IMAGES_OPTION, $excluded);
                }
            } else {
                add_settings_error('mm_custom_images_messages', 'mm_delete_error', 'Gagal menghapus gambar.', 'error');
            }
            set_transient('settings_errors', get_settings_errors(), 30);
            wp_safe_redirect(admin_url('admin.php?page=mm-custom-images'));
            exit;
        }
    }
    if (isset($_POST['mm_exclude_nonce']) && wp_verify_nonce($_POST['mm_exclude_nonce'], 'mm_exclude_action')) {
        if (! empty($_POST['toggle_exclude_image'])) {
            $file_to_toggle = sanitize_file_name($_POST['toggle_exclude_image']);
            $excluded_images = get_option(MM_EXCLUDED_IMAGES_OPTION, []);
            $key = array_search($file_to_toggle, $excluded_images);
            if ($key !== false) {
                unset($excluded_images[$key]);
                add_settings_error('mm_custom_images_messages', 'mm_exclude_toggle', 'Gambar ' . esc_html($file_to_toggle) . ' sekarang akan ditampilkan (Included).', 'success');
            } else {
                $excluded_images[] = $file_to_toggle;
                add_settings_error('mm_custom_images_messages', 'mm_exclude_toggle', 'Gambar ' . esc_html($file_to_toggle) . ' tidak akan ditampilkan (Excluded).', 'warning');
            }
            update_option(MM_EXCLUDED_IMAGES_OPTION, array_values($excluded_images));
            set_transient('settings_errors', get_settings_errors(), 30);
            wp_safe_redirect(admin_url('admin.php?page=mm-custom-images'));
            exit;
        }
    }
}
// Ganti pemanggilan fungsi lama dengan yang baru
remove_action('admin_init', 'mm_custom_images_handle_actions'); // Hapus hook lama jika ada
add_action('admin_init', 'mm_custom_images_handle_actions_full'); // Tambah hook baru