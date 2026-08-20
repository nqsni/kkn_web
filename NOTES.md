# Sistem KKN — Panduan Setup & Testing

## Setup Awal (cukup sekali)

### 1. Clone repo
git clone https://github.com/nqsni/kkn_web.git
cd kkn_web

### 2. Install dependency
composer install
npm install && npm run build

### 3. Siapkan file environment
copy .env.example .env
php artisan key:generate

### 4. Buat database
Buat database MySQL kosong (nama bebas, misal `kkn_db`), lalu buka file `.env` dan sesuaikan bagian ini:
DB_DATABASE=kkn_db
DB_USERNAME=root
DB_PASSWORD=

### 5. Migrate + isi data testing otomatis
php artisan migrate:fresh --seed
php artisan storage:link

Perintah ini otomatis bikin 8 akun testing + 1 periode KKN aktif 

### 6. Jalankan server
php artisan serve

### 7. Buka di browser
http://localhost:8000

Kalau semua langkah di atas jalan tanpa error, kamu siap testing.

Halaman `/register` sengaja dimatikan — semua akun cuma bisa dibuat lewat Super Admin (atau otomatis lewat seeder di atas). Kalau kamu buka `/register`, akan muncul halaman "Registrasi Ditutup", itu normal, bukan bug.

## Akun Testing

**Semua akun pakai password yang sama:** `08082026`

| Role | Email | Keterangan |
|---|---|---|
| Super Admin | `admin@mail.com` | Kelola periode, akun, kuota |
| Panitia KKN | `psatu@mail.com` | Validasi proyek |
| Dosen | `dsatu@mail.com` | Pembimbing Kelompok 1 |
| Dosen | `ddua@mail.com` | Pembimbing Kelompok 2 |
| Mahasiswa | `msatu@mail.com` | Kelompok 1 |
| Mahasiswa | `mdua@mail.com` | Kelompok 1 |
| Mahasiswa | `mtiga@mail.com` | Kelompok 2 |
| Mahasiswa | `mempat@mail.com` | Kelompok 2 |

Periode KKN sudah otomatis aktif: **Periode 2028**.

## Skenario Testing

### Skenario 1 — Proyek diajukan Mahasiswa

| # | Login sebagai | Aksi |
|---|---|---|
| 1 | `msatu` | Ajukan proyek KKN, cantumkan `mdua` sebagai anggota tim |
| 2 | `panitia` | Validasi proyek → lolos → assign dosen `dsatu` |
| 3 | `admin` | Buka halaman Kapasitas & Rilis → rilis proyek ke War |
| 4 | `msatu` **atau** `mdua` | Upload proposal (siapa saja anggota tim boleh upload — cukup sekali per proyek) |
| 5 | `dsatu` | Buka Validasi Proposal → beri nilai LRK → ACC |
| 6 | `msatu` | Upload logbook mingguan (punya sendiri) |
| 7 | `mdua` | Upload logbook mingguan (punya sendiri, terpisah dari milik msatu) |
| 8 | `dsatu` | Tinjau logbook masing-masing mahasiswa, beri catatan |
| 9 | `msatu` **atau** `mdua` | Upload laporan akhir |
| 10 | `dsatu` | Beri nilai laporan akhir (jadi sumber nilai LPK) |
| 11 | `dsatu` | Isi Penilaian Akhir (4 kriteria Kinerja) → nilai akhir & mutu otomatis muncul |
| 12 | `msatu` **dan** `mdua` | Cek halaman "Nilai Saya" — harus muncul nilai yang sama |

### Skenario 2 — Proyek diajukan Dosen + fitur War

| # | Login sebagai | Aksi |
|---|---|---|
| 1 | `ddua` | Ajukan proyek sendiri, cantumkan `mtiga` sebagai anggota, set kuota tim 2 (sisa 1 slot kosong) |
| 2 | `panitia` | Validasi proyek → lolos (dosen otomatis `ddua`, tidak perlu assign manual) |
| 3 | `admin` | Rilis proyek ke War |
| 4 | `mempat` | Buka halaman **War** → rebut slot kosong di proyek ini |
| 5 | `mtiga` **atau** `mempat` | Upload proposal |
| 6 | `ddua` | Beri nilai LRK → ACC |
| 7-12 | *(sama seperti Skenario 1, langkah 6-12, ganti nama ke `mtiga`/`mempat`/`ddua`)* | Logbook → Laporan Akhir → Penilaian Akhir → Cek Nilai |

---

## Tips Testing

- **Buka beberapa tab/browser berbeda** (atau mode Incognito) untuk login sebagai user berbeda secara bersamaan — memudahkan lompat antar role tanpa logout-login terus.
- Kalau nemu **halaman putih kosong / error**, cek dulu apakah command di step 5 (`migrate:fresh --seed`) berhasil tanpa error saat dijalankan.
- Kalau lupa alurnya sampai mana, cek badge status di halaman "Proyek KKN Saya" — statusnya berjalan: `Menunggu Validasi` → `Menunggu Rilis Admin` → `Tersedia (War)` / `Tim Lengkap`.

## Catatan Teknis (buat yang penasaran)

- Password akun = tanggal lahir format `ddmmyyyy`, dibuat Super Admin (bukan self-register)
- Semua role di-scope per periode KKN (tabel pivot `periode_user`)
- Nilai LRK (15%) diambil otomatis dari nilai proposal, nilai LPK (15%) dari nilai laporan akhir — dosen cuma input manual 4 kriteria Kinerja (70%) di halaman Penilaian Akhir
- Logbook **tidak ada nilai angka** — cuma upload + catatan/feedback dosen
- 1 mahasiswa hanya boleh aktif di 1 proyek — bisa batalkan proyek sendiri sebelum divalidasi panitia kalau mau ajukan ulang

### Belum dikerjakan
- Dashboard masih tampilan dasar (belum ada ringkasan data)
- Belum ada notifikasi
- Belum ada automated testing
- Belum di-deploy (masih localhost only)