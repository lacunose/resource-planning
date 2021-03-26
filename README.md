## SETUP PROJECT

1. run 
 `composer install`
2. run for fresh install
 `git submodule update --init --recursive`
 or 
 `git submodule update --recursive --remote`
3. run 
 `php artisan migrate`
4. run
 `php artisan db:seed`
5. run
 `npm install`

## STRUCTURE

1. dashboard thunder, untuk subs di thunder.localhost:8000
2. dashboard owner, untuk setting tenant di owner.localhost:8000
3. dashboard tenant, sementara default di localhost:8000
4. laravel mix untuk tools sementara di tools.localhost:8000


## BUAT PRICING - PLAN

1. buka http://thunder.localhost:8777
2. login dengan password default
3. menu -> langganan -> paket langganan
4. isi paket + publish



## CONTOH SUBSCRIBE BARU

1. buka http://localhost:8777/registering
2. isi data + submit
3. check email untuk verifikasi
4. buka http://localhost:8777/login
5. login dengan credentials yang tadi daftar
6. buka http://localhost:8777/subscribing
7. isi data subs + submit
8. check email untuk login ke dashboard owner
9. kalau fail login buka http://owner.localhost:8777
10. pilih menu {domain}.localhost -> tagihan
11. lakukan pembayaran sesuai step midtrans



## CONTOH TAMBAH AKSES USER

1. buka http://owner.localhost:8777
2. pilih menu {domain}.localhost -> akses
3. isi data user
4. cek email untuk terima akses (kayak github)
   - Kalau user baru direct ke laman register + verifikasi
   - Kalau user lama direct ke laman verifikasi
5. Setujui (ada privacy policy + terms & condition)

