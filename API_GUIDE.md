# API Program Donasi

API ini menyediakan data JSON publik untuk program donasi aktif. Tidak memerlukan
login dan tidak mengubah alur website yang sudah ada.

Base URL lokal: `http://127.0.0.1:8000`

## Daftar program aktif

```http
GET /api/programs
Accept: application/json
```

Contoh respons:

```json
{
  "data": [
    {
      "id": 1,
      "title": "Pendidikan untuk Anak Pelosok",
      "category": "Pendidikan",
      "description": "Membantu anak-anak mendapatkan akses pendidikan.",
      "image": "https://example.com/program.jpg",
      "target_amount": 120000000,
      "raised_amount": 50000,
      "status": "active"
    }
  ]
}
```

## Detail program

```http
GET /api/programs/{id}
Accept: application/json
```

ID yang tidak ditemukan atau program yang sudah ditutup menghasilkan respons
`404 Not Found`.

## Menjalankan dan mencoba

Jalankan migrasi bila database lokal belum disiapkan, lalu hidupkan Laravel:

```bash
php artisan migrate --seed
php artisan serve
```

Import `postman/Donasi API.postman_collection.json` ke Postman, lalu jalankan
request daftar program atau detail program. Ganti nilai `programId` untuk mencoba
detail program yang berbeda.
