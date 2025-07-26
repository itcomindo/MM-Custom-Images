# MM Custom Images

**Contributors:** Budi Haryono  
**Tags:** images, custom images, random images, shortcode, image gallery, bulk edit, image manager  
**Requires at least:** 5.0  
**Tested up to:** 6.5  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html

Plugin sederhana namun kuat untuk mengelola dan menampilkan gambar acak dari folder khusus menggunakan shortcode, lengkap dengan fitur aksi massal.

![MM Custom Images](https://plugins.budiharyono.com/images/custom-images.png)

---

### Deskripsi

"MM Custom Images" menyediakan cara yang mudah dan efisien untuk mengelola koleksi gambar pribadi dan menampilkannya secara acak di postingan atau halaman Anda. Ini adalah solusi sempurna untuk menambahkan elemen visual yang dinamis ke situs Anda tanpa memenuhi Pustaka Media utama.

Saat diaktifkan, plugin akan membuat folder `custom-images` yang aman di dalam direktori `uploads` Anda. Plugin ini juga menyediakan halaman admin khusus dengan manajer galeri gambar berfitur lengkap.

### Fitur Utama

*   **Upload Massal:** Upload banyak gambar (JPG, PNG, WEBP) sekaligus.
*   **Galeri Gambar:** Lihat semua gambar yang diunggah dalam format grid yang bersih dan responsif.
*   **Aksi Massal:** Pilih beberapa gambar untuk **Exclude** (Kecualikan) atau **Hapus** secara bersamaan, menghemat waktu Anda.
*   **Aksi Individual:** Hapus atau kecualikan/sertakan gambar dengan cepat melalui tombol khusus di setiap item.
*   **Kecualikan dari Rotasi:** "Kecualikan" gambar untuk sementara agar tidak ditampilkan oleh shortcode, tanpa perlu menghapusnya.
*   **Aman:** Otomatis membuat file keamanan (`.htaccess`, `index.php`) untuk mencegah orang melihat isi folder secara langsung.
*   **Mudah Digunakan:** Cukup masukkan shortcode `[image]` untuk menampilkan gambar acak yang tersedia.
*   **Responsif:** Gambar yang dihasilkan oleh shortcode secara otomatis responsif dan tidak akan merusak tata letak situs Anda.

---

### Instalasi

1.  Upload folder `mm-custom-images` ke direktori `/wp-content/plugins/` Anda.
2.  Aktifkan plugin melalui menu 'Plugins' di dasbor WordPress.
3.  Menu baru bernama **"Custom Images"** akan muncul di sidebar admin Anda. Semua pengelolaan dilakukan dari halaman ini.

---

### Cara Penggunaan

1.  **Buka Halaman Plugin**
    *   Dari menu admin WordPress Anda, klik **Custom Images**.

2.  **Upload Gambar**
    *   Di bagian "Upload Gambar Baru", klik "Choose File".
    *   Pilih satu atau beberapa file gambar dari komputer Anda. Tahan tombol **Ctrl** (di Windows) atau **Command** (di Mac) untuk memilih banyak file sekaligus.
    *   Klik tombol "Upload Gambar".

3.  **Kelola Gambar di Galeri**
    *   **Aksi Individual**: Setiap gambar memiliki tombol untuk "Exclude" (atau "Include") dan "Hapus".
    *   **Aksi Massal**:
        1.  Centang kotak pada gambar yang ingin Anda kelola, atau gunakan kotak centang "Pilih Semua".
        2.  Dari menu dropdown "Aksi Massal" di bagian atas galeri, pilih "Exclude" atau "Hapus".
        3.  Klik tombol "Terapkan".
        4.  Sebuah konfirmasi akan muncul jika Anda memilih untuk menghapus, untuk mencegah kehilangan data yang tidak disengaja.

4.  **Tampilkan Gambar Acak**
    *   Edit Postingan, Halaman, atau area widget apa pun yang mendukung shortcode.
    *   Ketikkan shortcode `[image]` di tempat Anda ingin gambar acak muncul.
    *   Simpan perubahan Anda. Gambar acak dari koleksi Anda yang "disertakan" (included) akan ditampilkan setiap kali halaman dimuat.

---

### Contoh Output HTML

Shortcode `[image]` akan menghasilkan struktur HTML seperti ini:

```html
<div class="mm-custom-image">
    <img src="http://domain-anda.com/wp-content/uploads/custom-images/nama-gambar-acak.jpg" alt="Judul Post Anda" title="Judul Post Anda" loading="lazy">
</div>