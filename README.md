# Scout Wonder

Aplikasi web sederhana untuk memanajemen data pemain sepak bola muda (Wonderkids). Dibuat untuk memenuhi Tugas ke-1 Pra-Magang Reguler PT Makerindo (Web Programming).

## Fitur Utama (CRUD)
1. **Create**: Menambahkan data pemain baru, foto, serta atribut statistik lengkap (Speed, Passing, dll).
2. **Read**: Menampilkan daftar pemain dengan tampilan kartu interaktif, badge rating (OVR/POT), dan fitur sorting (Highest OVR/Potential).
3. **Update**: Mengedit informasi biodata, posisi, dan statistik pemain.
4. **Delete**: Menghapus data pemain dari database.
5. **Analytics**: Visualisasi statistik pemain menggunakan Radar Chart.

## Teknologi
- **Backend**: PHP Native
- **Database**: MySQL
- **Frontend**: Tailwind CSS (via CDN)
- **Library Tambahan**: Chart.js (untuk grafik statistik)

## Cara Instalasi
1. Clone/Download repository ini ke folder `www` (Laragon) atau `htdocs` (XAMPP).
2. Buat database baru di PHPMyAdmin bernama `db_simplescout_v1`.
3. Import file database (`database.sql`) atau jalankan query SQL pembuatan tabel.
4. Buka browser dan akses `localhost/scout-wonder`.

| index.php  | create.php |
|------------|------------|
|<img width="1919" height="866" alt="image" src="https://github.com/user-attachments/assets/75e389b2-03c2-46a0-8960-2615ed2cdd43" /> |<img width="1919" height="860" alt="image" src="https://github.com/user-attachments/assets/a810e46a-1aa0-45e3-b126-1b5b4acfd462" />|

| detail.php | edit.php   |
|------------|------------|
|<img width="1919" height="848" alt="image" src="https://github.com/user-attachments/assets/539b96c7-9b50-4587-a0a7-444d07a57bff" />|<img width="1919" height="860" alt="image" src="https://github.com/user-attachments/assets/4546287d-9f50-4a91-b0cd-6c107773be41" />|

---
Dibuat sama akuu: Fadli Haidar Nugraha
Mahasiswa Teknik Informatika UIN SGD Bandung
Made With Passion
