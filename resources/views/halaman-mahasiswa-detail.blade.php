<html>
<head>
    <title>Data Pegawai</title>
</head>
<body>
    <h1>Profil Saya</h1>
    <p><b>Nama:</b> {{ $name }}</p>
    <p><b>Umur:</b> {{ $my_age }} tahun</p>
    <p><b>Hobi:</b></p>
    <ul>
        @foreach ($hobbies as $hobi)
            <li>{{ $hobi }}</li>
        @endforeach
    </ul>
    <p><b>Tanggal Harus Wisuda:</b> {{ $tgl_harus_wisuda }}</p>
    <p><b>Sisa Hari Menuju Wisuda:</b> {{ $time_to_study_left }} hari</p>
    <p><b>Semester Saat Ini:</b> {{ $current_semester }}</p>
    <p><b>Info Semester:</b> {{ $info_semester }}</p>
    <p><b>Cita-cita:</b> {{ $future_goal }}</p>
</body>
</html>
