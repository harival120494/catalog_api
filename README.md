Tahap Installasi Back End
===========================

1. Clone catalog API
2. Buat database dengan nama "catalog"
3. Rename file .env-example menjadi .env
4. Jalankan perintah "composer update"
5. jalankan perintah "php artisan migrate"
6. jalankan perintah "php artisan passport:client --personal"
7. Jalankan perintah "php artisan migrate --seed"
7. Jalankan perintah "php artisan serve --host=192.168.100.16 --port=8000"
Note : ganti alamat ip host dengan alamat IP komputer atau laptop,
tujuan nya adalah, agar host bisa di akses melalui aplikasi mobile front end
dalam satu jaringan.


Teknologi Yang digunakan 
========================
Laravel Passport
