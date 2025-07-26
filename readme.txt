=== MM Custom Images ===
Contributors: Budi Haryono
Tags: images, custom images, random images, shortcode, image gallery, bulk edit, image manager
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple but powerful plugin to manage and display random images from a custom folder using a shortcode, complete with bulk actions.

== Description ==

"MM Custom Images" provides an easy and efficient way to manage a private collection of images and display one at random on your posts or pages. It's perfect for adding dynamic visual elements to your site without cluttering the main Media Library.

Upon activation, the plugin creates a secure `custom-images` folder in your uploads directory. It then provides a dedicated admin page with a full-featured image gallery manager.

**Key Features:**

*   **Bulk Upload:** Upload multiple images (JPG, PNG, WEBP) at once.
*   **Image Gallery:** View all uploaded images in a clean, responsive grid.
*   **Bulk Actions:** Select multiple images to **Exclude** or **Delete** them simultaneously, saving you valuable time.
*   **Individual Actions:** Quickly delete or exclude/include single images with dedicated buttons.
*   **Exclude from Rotation:** Temporarily "exclude" images from being shown by the shortcode without deleting them.
*   **Secure:** Automatically creates security files (`.htaccess`, `index.php`) to prevent direct folder listing.
*   **Easy to Use:** Simply insert the `[image]` shortcode to display a random, available image.
*   **Responsive:** The output image is automatically responsive and will not break your site layout.

== Installation ==

1.  Upload the `mm-custom-images` folder to the `/wp-content/plugins/` directory.
2.  Activate the plugin through the 'Plugins' menu in WordPress.
3.  A new menu item, "Custom Images," will appear in your WordPress admin sidebar. All management is done from this page.

== Usage ==

1.  **Navigate to the Plugin Page**: From your WordPress admin menu, go to **Custom Images**.

2.  **Upload Images**:
    *   In the "Upload Gambar Baru" section, click "Choose File".
    *   Select one or more image files from your computer (JPG, PNG, or WEBP). Hold Ctrl (Windows) or Cmd (Mac) to select multiple files at once.
    *   Click the "Upload Gambar" button.

3.  **Manage Images in the Gallery**:
    *   **Individual Actions**: Each image has buttons to "Exclude" (or "Include") and "Hapus" (Delete).
    *   **Bulk Actions**:
        1.  Check the box on the images you want to manage, or use the "Pilih Semua" (Select All) checkbox.
        2.  From the "Aksi Massal" (Bulk Actions) dropdown menu at the top of the gallery, choose either "Exclude" or "Hapus".
        3.  Click the "Terapkan" (Apply) button.
        4.  A confirmation prompt will appear if you choose to delete, preventing accidental data loss.

4.  **Display a Random Image**:
    *   Edit any post, page, or widget area that supports shortcodes.
    *   Insert the shortcode `[image]` where you want a random image to appear.
    *   Save your changes. A random image from your "included" collection will be displayed each time the page is loaded.

== Screenshots ==

1.  The main admin page showing the bulk upload form and the image gallery.
2.  The gallery with several images selected, showing the bulk actions dropdown.
3.  The `[image]` shortcode being used in the WordPress block editor.
4.  The final result: a random image displayed on the front end of the website.

== Changelog ==

= 1.0.0 =
*   Initial release.
*   Feature: Plugin automatically creates a secure `/wp-content/uploads/custom-images/` folder on activation.
*   Feature: Dedicated admin page for managing images.
*   Feature: Multi-file upload functionality (JPG, PNG, WEBP).
*   Feature: Image gallery to view all uploaded images.
*   Feature: Ability to Exclude/Include individual images from the random rotation.
*   Feature: Ability to permanently Delete individual images.
*   Feature: Bulk actions to Exclude or Delete multiple images at once.
*   Feature: `[image]` shortcode to display a random, "included" image.
*   Improvement: Added security nonces for all actions.
*   Improvement: Added responsive CSS for the shortcode output to prevent theme overflow.