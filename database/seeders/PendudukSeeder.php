<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendudukSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {

            $dusuns = ["Bagel", "Mondoteko", "Torejo", "Karangaru", "Puri", "Megah Asri", ];
            $dusunIds = [];
            $rwIds = [];
            $rtIds = [];
            $pendudukIds = [];
            $keluargaIds = [];

            // =====================
            // 1. DUSUN
            // =====================
            foreach($dusuns as $dusun) {
                $dusunIds[] = DB::table('dusun')->insertGetId([
                    'nama_dusun' =>  $dusun,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // =====================
            // 2. RW
            // =====================
            foreach ($dusunIds as $dusunId) {
                for ($i = 1; $i <= 5; $i++) {
                    $rwIds[] = DB::table('rw')->insertGetId([
                        'dusun_id' => $dusunId,
                        'ketua_rw' => 'Ketua RW ' . $i,
                        'no_rw' => '0' . $i,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // =====================
            // 3. RT
            // =====================
            foreach ($rwIds as $rwId) {
                for ($i = 1; $i <= 10; $i++) {
                    $rtIds[] = DB::table('rt')->insertGetId([
                        'rw_id' => $rwId,
                        'ketua_rt' => 'Ketua RT ' . $i,
                        'no_rt' => '0' . $i,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // =====================
            // 4. PENDUDUK
            // =====================
            for ($i = 1; $i <= 1000; $i++) {

                $rtId = $rtIds[array_rand($rtIds)];

                $pendudukIds[] = DB::table('penduduk')->insertGetId([
                    'nik' => '3301' . str_pad($i, 12, '0', STR_PAD_LEFT),
                    'nama_lengkap' => 'Penduduk ' . $i,
                    'jenis_kelamin' => $i % 2 ? 'laki-laki' : 'perempuan',
                    'alamat' => 'Jl. Desa Sejahtera',
                    'tempat_lahir' => 'Rembang',
                    'tanggal_lahir' => now()->subYears(rand(1, 60)),
                    'nama_ibu' => 'Ibu ' . $i,
                    'nama_ayah' => 'Ayah ' . $i,
                    'rt_id' => $rtId,
                    'agama' => 'Islam',
                    'profesi' => 'Wiraswasta',
                    'pendidikan' => 'SMA',
                    'status_kependudukan' => 'aktif',
                    'status_perkawinan' => $i % 3 ? 'Menikah' : 'Belum Menikah',
                    'golongan_darah' => ['A', 'B', 'AB', 'O'][rand(0, 3)],
                    'kewarganegaraan' => 'WNI',
                    'created_at' => fake()->dateTimeBetween('-3 year', 'now'),
                    'updated_at' => now(),
                ]);
            }

            // =====================
            // 5. KELUARGA
            // =====================
            for ($i = 1; $i <= 10; $i++) {

                $kepalaId = $pendudukIds[array_rand($pendudukIds)];

                $rtId = DB::table('penduduk')->where('id', $kepalaId)->value('rt_id');

                $keluargaIds[] = DB::table('keluarga')->insertGetId([
                    'no_kk' => 'KK' . str_pad($i, 6, '0', STR_PAD_LEFT),
                    'kepala_keluarga_id' => $kepalaId,
                    'rt_id' => $rtId,
                    'alamat' => 'Alamat Keluarga ' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // =====================
            // 6. ANGGOTA KELUARGA
            // =====================
            foreach ($pendudukIds as $i => $pendudukId) {

                $keluargaId = $keluargaIds[array_rand($keluargaIds)];
                $pendudukRW = DB::table('keluarga')
                    ->join('penduduk', 'penduduk.id', '=', 'keluarga.kepala_keluarga_id')
                    ->join('rt', 'rt.id', '=', 'penduduk.rt_id')
                    ->join('rw', 'rw.id', '=', 'rt.rw_id')
                    ->value('rw.id');

                // Pastikan anggota keluarga berasal dari RW yang sama

                $hubungan = match (true) {
                    $i < 5 => 'kepala keluarga',
                    $i < 10 => 'istri',
                    default => 'anak',
                };

                DB::table('anggota_keluarga')->insert([
                    'keluarga_id' => $keluargaId,
                    'penduduk_id' => $pendudukId,
                    'hubungan' => $hubungan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // =====================
            // 7. MUTASI + DETAIL
            // =====================
            foreach ($pendudukIds as $pendudukId) {

                $keteranganList = ['pindah masuk', 'pindah keluar', 'meninggal', 'kelahiran'];
                $keterangan = $keteranganList[array_rand($keteranganList)];
                $pendudukPriaRW = DB::table('penduduk')
                    ->join('rt', 'penduduk.rt_id', '=', 'rt.id')
                    ->where('rt.rw_id', DB::table('rt')->where('id', DB::table('penduduk')->where('id', $pendudukId)->value('rt_id'))->value('rw_id'))
                    ->where('jenis_kelamin', 'laki-laki')
                    ->select('penduduk.*')
                    ->get('id');
                $pendudukPRW = DB::table('penduduk')
                    ->join('rt', 'penduduk.rt_id', '=', 'rt.id')
                    ->where('rt.rw_id', DB::table('rt')->where('id', DB::table('penduduk')->where('id', $pendudukId)->value('rt_id'))->value('rw_id'))
                    ->where('jenis_kelamin', 'perempuan')
                    ->select('penduduk.*')
                    ->get('id');

                // RULE MUTASI
                if (in_array($keterangan, ['meninggal', 'pindah keluar'])) {
                    $jenisMutasi = 'pengurangan';
                    $statusPenduduk = 'tidak aktif';
                } else {
                    $jenisMutasi = 'penambahan';
                    $statusPenduduk = 'aktif';
                }

                $mutasiId = DB::table('mutasi_penduduk')->insertGetId([
                    'penduduk_id' => $pendudukId,
                    'jenis_mutasi' => $jenisMutasi,
                    'keterangan' => $keterangan,
                    'tanggal_mutasi' => fake()->dateTimeBetween('-3 year', 'now'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('penduduk')
                    ->where('id', $pendudukId)
                    ->update(['status_kependudukan' => $statusPenduduk]);

                // =====================
                // KEMATIAN
                // =====================
                if ($keterangan === 'meninggal') {
                    DB::table('kematians')->insert([
                        'mutasi_penduduk_id' => $mutasiId,
                        'tanggal_kematian' => now(),
                        'waktu_kematian' => now()->format('H:i:s'),
                        'tanggal_pelaporan' => fake()->dateTimeBetween('-3 year', 'now'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // =====================
                // PERPINDAHAN (FIX RULE)
                // =====================
                if (in_array($keterangan, ['pindah masuk', 'pindah keluar'])) {

                    $rtId = DB::table('penduduk')->where('id', $pendudukId)->value('rt_id');
                    $rwId = DB::table('rt')->where('id', $rtId)->value('rw_id');

                    $noRt = DB::table('rt')->where('id', $rtId)->value('no_rt');
                    $noRw = DB::table('rw')->where('id', $rwId)->value('no_rw');

                    $isMasuk = $keterangan === 'pindah masuk';

                    $klasifikasiList = [
                        'pindah dalam satu desa/kelurahan',
                        'antar desa/kelurahan dalam satu kecamatan',
                        'antar kecamatan dalam satu kabupaten/kota',
                        'antar kabupaten/kota dalam satu provinsi'
                    ];

                    DB::table('perpindahan')->insert([
                        'mutasi_penduduk_id' => $mutasiId,
                        'jenis_perpindahan' => $keterangan,

                        // ASAL
                        'alamat_asal' => $isMasuk ? 'Jl. Luar Desa' : 'Alamat Saat Ini',
                        'rt_asal' => $isMasuk ? null : $noRt,
                        'rw_asal' => $isMasuk ? null : $noRw,
                        'desa_asal' => $isMasuk ? 'Desa Lain' : 'Desa Sekarang',
                        'kecamatan_asal' => 'Kecamatan A',
                        'kabupaten_asal' => 'Rembang',
                        'provinsi_asal' => 'Jawa Tengah',

                        // TUJUAN
                        'alamat_tujuan' => $isMasuk ? 'Alamat Saat Ini' : 'Jl. Luar Desa',
                        'rt_tujuan' => $isMasuk ? $noRt : null,
                        'rw_tujuan' => $isMasuk ? $noRw : null,
                        'desa_tujuan' => $isMasuk ? 'Desa Sekarang' : 'Desa Lain',
                        'kecamatan_tujuan' => 'Kecamatan B',
                        'kabupaten_tujuan' => 'Pati',
                        'provinsi_tujuan' => 'Jawa Tengah',

                        'klasifikasi_perpindahan' => $klasifikasiList[array_rand($klasifikasiList)],
                        'alasan_perpindahan' => ['Kerja', 'Keluarga', 'Pendidikan'][rand(0, 2)],
                        'tanggal_pelaporan' => now()->addDays(rand(1, 30)),

                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // =====================
                // KELAHIRAN
                // =====================
                if ($keterangan === 'kelahiran') {
                    DB::table('kelahiran')->insert([
                        'keluarga_id' => $keluargaIds[array_rand($keluargaIds)],
                        'ayah_id' => $pendudukPriaRW->random()->id,
                        'ibu_id' => $pendudukPRW->random()->id,
                        'mutasi_penduduk_id' => $mutasiId,
                        'nama_lengkap' => 'Bayi ' . Str::random(5),
                        'jenis_kelamin' => rand(0, 1) ? 'laki-laki' : 'perempuan',
                        'tempat_lahir' => 'Rembang',
                        'tanggal_lahir' => Penduduk::inRandomOrder()->first()->tanggal_lahir,
                        'waktu_lahir' => now()->format('H:i:s'),
                        'tanggal_pelaporan' =>  now()->addDays(rand(1, 30)),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}