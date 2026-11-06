<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummySiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = [
            [
                'nis' => '24001',
                'nisn' => '0091234501',
                'nik' => '3508121405110001',
                'nama' => 'Ahmad Fauzi',
                'kelas' => '7A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Lumajang',
                'tanggal_lahir' => '2011-05-14',
                'alamat' => 'Jl. Merdeka No. 12, Klakah',
                'nama_wali' => 'Bambang Sudarsono',
                'kontak_wali' => '081234567891',
                'status' => 'aktif',
            ],
            [
                'nis' => '24002',
                'nisn' => '0091234502',
                'nik' => '3508126208110002',
                'nama' => 'Siti Nurhaliza',
                'kelas' => '7A',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Lumajang',
                'tanggal_lahir' => '2011-08-22',
                'alamat' => 'Desa Duren, Kec. Klakah',
                'nama_wali' => 'H. Mahfud',
                'kontak_wali' => '081234567892',
                'status' => 'aktif',
            ],
            [
                'nis' => '24003',
                'nisn' => '0091234503',
                'nik' => '3508121002110003',
                'nama' => 'Muhammad Rizky Pratama',
                'kelas' => '7B',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Probolinggo',
                'tanggal_lahir' => '2011-02-10',
                'alamat' => 'Jl. Raya Klakah No. 45',
                'nama_wali' => 'Agus Pratama',
                'kontak_wali' => '081234567893',
                'status' => 'aktif',
            ],
            [
                'nis' => '24004',
                'nisn' => '0091234504',
                'nik' => '3508124511110004',
                'nama' => 'Aisyah Azzahra',
                'kelas' => '7B',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Lumajang',
                'tanggal_lahir' => '2011-11-05',
                'alamat' => 'Jl. Melati No. 8, Randuagung',
                'nama_wali' => 'Drs. Supardi',
                'kontak_wali' => '081234567894',
                'status' => 'aktif',
            ],
            [
                'nis' => '24005',
                'nisn' => '0091234505',
                'nik' => '3508121809100005',
                'nama' => 'Bima Aditya Saputra',
                'kelas' => '8A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jember',
                'tanggal_lahir' => '2010-09-18',
                'alamat' => 'Desa Mlawang, Kec. Klakah',
                'nama_wali' => 'Joko Susilo',
                'kontak_wali' => '081234567895',
                'status' => 'aktif',
            ],
        ];

        foreach ($siswas as $data) {
            $siswa = Siswa::updateOrCreate(['nis' => $data['nis']], $data);

            // Cari atau buat User dengan username = NISN
            $user = User::where('siswa_id', $siswa->id)->first();

            if ($user) {
                $user->update([
                    'name'     => $data['nama'],
                    'username' => $data['nisn'],
                    'email'    => 'siswa.' . $data['nisn'] . '@smp.sch.id',
                    'password' => Hash::make($data['nik']),
                    'role'     => 'siswa',
                    'siswa_id' => $siswa->id,
                ]);
            } else {
                User::create([
                    'name'     => $data['nama'],
                    'username' => $data['nisn'],
                    'email'    => 'siswa.' . $data['nisn'] . '@smp.sch.id',
                    'password' => Hash::make($data['nik']),
                    'role'     => 'siswa',
                    'siswa_id' => $siswa->id,
                ]);
            }
        }
    }
}
