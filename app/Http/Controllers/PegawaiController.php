<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    public function index()
    {
        // Hitung umur
        $tglLahir = Carbon::createFromDate(2000, 1, 1); // Ganti dengan tanggal lahir Anda
        $umur = $tglLahir->age;

        // Hitung sisa hari menuju wisuda
        $tglWisuda = Carbon::createFromDate(2027, 8, 30); // Ganti dengan tanggal wisuda target
        $sisaHari = Carbon::now()->diffInDays($tglWisuda);

        // Tentukan semester saat ini
        $semester = 5; // Ganti dengan semester Anda saat ini

        // Tentukan informasi berdasarkan semester
        if ($semester < 3) {
            $infoSemester = "Masih Awal, Kejar TAK";
        } else {
            $infoSemester = "Jangan main-main, kurang-kurangi main game!";
        }

        $data = [
            'name' => 'Nama Saya', // Ganti dengan nama Anda
            'my_age' => $umur,
            'hobbies' => ['Membaca', 'Menulis', 'Mendengarkan Musik', 'Bermain Game', 'Memasak'],
            'tgl_harus_wisuda' => '30 Agustus 2027', // Ganti dengan tanggal wisuda Anda
            'time_to_study_left' => $sisaHari,
            'current_semester' => $semester,
            'info_semester' => $infoSemester,
            'future_goal' => 'Menjadi programmer handal dan sukses',
        ];

        return view('halaman-mahasiswa-detail', $data);
    }
}

