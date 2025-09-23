<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $name = "Della Marcelina";
        $birthDate = Carbon::create(2006, 9, 17);
        $tglHarusWisuda = Carbon::create(2028, 10, 30);

        $my_age = $birthDate->age; // hitung umur otomatis
        $hobbies = ["Membaca", "Menulis", "Coding", "Olahraga", "Mendengarkan Musik"];
        $time_to_study_left = now()->diffInDays($tglHarusWisuda);
        $current_semester = 3;
        $future_goal = "Menjadi Software Engineer";

        // Cek semester
        if ($current_semester < 3) {
            $semester_info = "Masih Awal, Kejar TAK";
        } else {
            $semester_info = "Jangan main-main, kurangi malas!";
        }

        // Passing data ke view
        return view('pegawai.index', [
            'name' => $name,
            'my_age' => $my_age,
            'hobbies' => $hobbies,
            'tgl_harus_wisuda' => $tglHarusWisuda->toDateString(),
            'time_to_study_left' => $time_to_study_left,
            'current_semester' => $current_semester,
            'semester_info' => $semester_info,
            'future_goal' => $future_goal
        ]);
    }
}
