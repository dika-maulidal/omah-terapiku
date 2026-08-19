### Langkah-langkah Setup Proyek (untuk README)

1. Clone repositori ini ke komputer lokal: git clone <URL_REPOSITORY_KAMU> cd rekam-medis
    
2. Install dependency PHP: composer install
    
3. Copy file .env.example menjadi .env:
    
    - Di Windows (CMD): copy .env.example .env
        
    - Di Git Bash / Terminal: cp .env.example .env
        
4. Buka file .env, lalu atur nama database MySQL kamu di bagian ini: DB_DATABASE=rekam_medis DB_USERNAME=root DB_PASSWORD=
    
    (Jangan lupa buat database kosong dengan nama 'rekam_medis' di phpMyAdmin/MySQL).
    
5. Generate app key Laravel: php artisan key:generate
    
6. Jalankan migration dan seeder untuk membuat tabel + akun dummy: php artisan migrate:fresh --seed
    
7. Buat folder storage link (biar gambar/file upload bisa diakses): php artisan storage:link
    
8. Jalankan aplikasi: php artisan serve
    

### Data Akun Login Dummy

Semua password default-nya adalah: password

- Admin: admin@rekammedis.local
    
- Petugas Registrasi: registrasi@rekammedis.local
    
- Dokter: dokter@rekammedis.local
    
- Petugas Obat: obat@rekammedis.local