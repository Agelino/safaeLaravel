<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // KITA HAPUS DULU DATA LAMA BIAR GAK DOUBLE
        // Book::truncate(); // (Opsional: nyalakan ini jika mau database bersih tiap di-seed)

        $books = [
            [
                'title' => 'Buku Laravel Pemula', 
                'author' => 'Ahmad Budi', 
                'genre' => 'Pemrograman', 
                'year' => 2023, 
                'status' => 'approved',
                // GANTI NAMA FILE INI SESUAI FILE ASLI DI FOLDER PUBLIC/UPLOADS KAMU
                'image_path' => 'uploads/682cb38eb964.jpg', 
                'content' => "Laravel adalah framework PHP yang sangat populer di dunia pengembangan web modern. Buku ini dirancang khusus untuk pemula yang ingin memahami konsep dasar MVC (Model-View-Controller) dengan cara yang menyenangkan. 

Pada bab pertama, pembaca akan diajak untuk melakukan instalasi lingkungan kerja menggunakan Composer dan XAMPP. Kita akan membahas struktur folder Laravel yang seringkali membingungkan bagi pemula, mulai dari folder 'app', 'routes', hingga 'resources'. Tidak hanya teori, buku ini menyajikan studi kasus nyata membuat aplikasi 'To-Do List' sederhana.

Bab selanjutnya membahas tentang Eloquent ORM, fitur andalan Laravel yang membuat interaksi dengan database menjadi sangat mudah. Anda tidak perlu lagi menulis query SQL yang panjang dan rumit; cukup gunakan sintaks PHP yang elegan. Kita juga akan membahas fitur Blade Templating Engine yang memungkinkan kita membuat tampilan website yang dinamis namun tetap rapi dan terstruktur.

Di akhir buku, terdapat proyek akhir membuat Website Toko Online sederhana lengkap dengan fitur keranjang belanja dan checkout. Buku ini adalah panduan wajib bagi siapa saja yang ingin berkarir sebagai Backend Developer."
            ],
            [
                'title' => 'Misteri Hutan Tua', 
                'author' => 'Dian Sastro', 
                'genre' => 'Novel', 
                'year' => 2021, 
                'status' => 'approved',
                'image_path' => 'uploads/682cb77dca2fa.jpg',
                'content' => "Angin malam berhembus dingin menusuk tulang ketika Rara melangkahkan kakinya memasuki perbatasan Hutan Tua. Penduduk desa sudah memperingatkannya berulang kali: 'Jangan pernah masuk ke sana setelah matahari terbenam.' Namun, rasa penasaran dan tekad untuk menemukan adiknya yang hilang mengalahkan rasa takutnya.

Pohon-pohon beringin raksasa tampak seperti raksasa yang sedang tertidur, akar-akarnya menjuntai seolah siap menjerat siapa saja yang lengah. Rara menyalakan senter kecilnya, cahayanya hanya mampu menembus kegelapan sejauh beberapa meter. Tiba-tiba, terdengar suara gemerisik dari balik semak belukar. Bukan suara hewan biasa, melainkan suara langkah kaki yang berat dan menyeret.

Jantung Rara berdegup kencang. Ia teringat legenda tentang Penjaga Hutan, sosok mistis yang konon menjaga keseimbangan alam namun tidak segan menghukum manusia yang serakah. Apakah adiknya diculik oleh sosok itu? Atau ada rahasia lain yang lebih gelap yang disembunyikan oleh tetua desa selama ini?

Novel ini mengajak pembaca menyelami ketegangan psikologis dan misteri supranatural yang mencekam. Setiap halaman membuka lapisan rahasia baru, membuat Anda tidak akan bisa berhenti membaca hingga halaman terakhir."
            ],
            [
                'title' => 'Resep Masakan Nusantara', 
                'author' => 'Chef Juna', 
                'genre' => 'Hobi', 
                'year' => 2022, 
                'status' => 'pending',
                'image_path' => 'uploads/682fc75a21a02.jpg',
                'content' => "Indonesia dikenal sebagai surga kuliner dengan ribuan resep tradisional yang diwariskan turun-temurun. Buku 'Resep Masakan Nusantara' ini merangkum 50 resep terbaik dari Sabang sampai Merauke, yang telah disesuaikan dengan teknik memasak modern tanpa menghilangkan cita rasa aslinya.

Kita akan mulai dari Sumatera dengan Rendang Daging yang kaya rempah. Rahasia membuat rendang yang empuk dan tahan lama akan dikupas tuntas di sini, mulai dari pemilihan kelapa untuk santan hingga teknik pengapian yang tepat. Bergeser ke Jawa, kita akan belajar membuat Soto Lamongan dengan koya udang yang gurih, serta Gudeg Jogja yang manis legit namun tidak membuat eneg.

Tidak ketinggalan, masakan khas Indonesia Timur seperti Ikan Kuah Kuning dan Papeda juga dibahas dengan detail. Chef Juna memberikan tips khusus bagaimana cara mengolah sagu agar teksturnya pas, tidak terlalu cair dan tidak terlalu keras. 

Buku ini dilengkapi dengan foto-foto makanan yang menggugah selera dan QR Code yang terhubung ke video tutorial memasak. Sangat cocok untuk ibu rumah tangga, anak kost, maupun koki profesional yang ingin memperdalam khazanah kuliner Indonesia."
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
        Book::factory(20)->create();
    }
}