<?php

namespace App\Imports;

use App\Models\Penduduk;
use App\Models\RT;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PendudukImport implements ToCollection
{
    public array $errors = [];

    /**
     * HEADER WAJIB
     */
    protected array $requiredHeaders = [
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'no_rt',
        'no_rw',
        'nama_dusun',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_ibu',
        'nama_ayah',
        'agama',
        'profesi',
        'pendidikan',
        'status_perkawinan',
        'golongan_darah',
        'kewarganegaraan',
    ];

    public function collection(Collection $rows)
    {
        // ============================================
        // VALIDASI FILE
        // ============================================
        if ($rows->count() < 1) {

            $this->errors[] = 'File Excel kosong';

            return;
        }

        // ============================================
        // AMBIL HEADER
        // ============================================
        $headerRow = $rows->first()->toArray();

        // ============================================
        // NORMALISASI HEADER
        // ============================================
        $headers = [];

        foreach ($headerRow as $index => $header) {

            $header = strtolower(trim($header));

            $header = str_replace(
                [' ', '.', '/', '\\', '-'],
                '_',
                $header
            );

            $header = preg_replace('/_+/', '_', $header);

            $headers[$index] = $header;
        }

        // ============================================
        // VALIDASI HEADER
        // ============================================
        foreach ($this->requiredHeaders as $required) {

            if (!in_array($required, $headers)) {

                $this->errors[] =
                    "Header '$required' tidak ditemukan";
            }
        }

        // ============================================
        // JIKA ADA ERROR HEADER
        // ============================================
        if (count($this->errors) > 0) {
            return;
        }

        // ============================================
        // HAPUS HEADER
        // ============================================
        $rows->shift();

        // ============================================
        // LOOP DATA
        // ============================================
        foreach ($rows as $index => $row) {

            $baris = $index + 2;

            // ============================================
            // UBAH KE ARRAY
            // ============================================
            $row = $row->toArray();

            // ============================================
            // AUTO MAPPING
            // ============================================
            $data = [];

            foreach ($headers as $i => $headerName) {

                $data[$headerName] =
                    trim((string)($row[$i] ?? ''));
            }

            // ============================================
            // SKIP BARIS KOSONG
            // ============================================
            if (
                empty($data['nik']) &&
                empty($data['nama_lengkap'])
            ) {
                continue;
            }

            // ============================================
            // VALIDASI WAJIB
            // ============================================
            if (
                empty($data['nik']) ||
                empty($data['nama_lengkap'])
            ) {

                $this->errors[] =
                    "Baris $baris: NIK / Nama kosong";

                continue;
            }

            // ============================================
            // VALIDASI DUPLIKAT NIK
            // ============================================
            if (
                Penduduk::where('nik', $data['nik'])->exists()
            ) {

                $this->errors[] =
                    "Baris $baris: NIK sudah terdaftar";

                continue;
            }

            // ============================================
            // NORMALISASI JK
            // ============================================
            $jenisKelamin =
                strtolower(trim($data['jenis_kelamin']));

            $jenisKelamin =
                str_replace(
                    ['_', ' '],
                    '-',
                    $jenisKelamin
                );

            $jkMap = [

                'laki-laki' => 'laki-laki',
                'lakilaki' => 'laki-laki',

                'perempuan' => 'perempuan',
            ];

            $jenisKelamin =
                $jkMap[$jenisKelamin] ?? null;

            if (!$jenisKelamin) {

                $this->errors[] =
                    "Baris $baris: Jenis kelamin tidak valid";

                continue;
            }

            // ============================================
            // NORMALISASI STATUS KAWIN
            // ============================================
            $status =
                strtolower(trim($data['status_perkawinan']));

            $status = str_replace('_', ' ', $status);

            $statusMap = [

                'aktif' => 'Belum Menikah',

                'belum menikah' => 'Belum Menikah',

                'menikah' => 'Menikah',

                'cerai mati' => 'Cerai Mati',

                'cerai hidup' => 'Cerai Hidup',
            ];

            $status =
                $statusMap[$status] ?? null;

            if (!$status) {

                $this->errors[] =
                    "Baris $baris: Status perkawinan tidak valid";

                continue;
            }

            // ============================================
            // FORMAT TANGGAL
            // ============================================
            try {

                $tanggalInput =
                    trim($data['tanggal_lahir']);

                // =====================================
                // FORMAT EXCEL ANGKA
                // =====================================
                if (is_numeric($tanggalInput)) {

                    $tanggal =
                        Date::excelToDateTimeObject(
                            $tanggalInput
                        )->format('Y-m-d');
                }

                // =====================================
                // FORMAT STRING
                // =====================================
                else {

                    $tanggalInput =
                        str_replace(
                            '/',
                            '-',
                            $tanggalInput
                        );

                    // 02-12-26
                    if (
                        preg_match(
                            '/^\d{2}-\d{2}-\d{2}$/',
                            $tanggalInput
                        )
                    ) {

                        $tanggal =
                            Carbon::createFromFormat(
                                'd-m-y',
                                $tanggalInput
                            )->format('Y-m-d');
                    }

                    // 02-12-2026
                    elseif (
                        preg_match(
                            '/^\d{2}-\d{2}-\d{4}$/',
                            $tanggalInput
                        )
                    ) {

                        $tanggal =
                            Carbon::createFromFormat(
                                'd-m-Y',
                                $tanggalInput
                            )->format('Y-m-d');
                    }

                    // 2026-12-02
                    elseif (
                        preg_match(
                            '/^\d{4}-\d{2}-\d{2}$/',
                            $tanggalInput
                        )
                    ) {

                        $tanggal =
                            Carbon::parse(
                                $tanggalInput
                            )->format('Y-m-d');
                    }

                    else {

                        throw new \Exception(
                            'Format tanggal tidak dikenali'
                        );
                    }
                }
            } catch (\Exception $e) {

                $this->errors[] =
                    "Baris $baris: Format tanggal salah";

                continue;
            }

            // ============================================
            // VALIDASI GOL DARAH
            // ============================================
            $golongan =
                strtoupper(
                    trim(
                        $data['golongan_darah']
                    )
                );

            if (
                !in_array(
                    $golongan,
                    ['A', 'B', 'AB', 'O', '-']
                )
            ) {

                $this->errors[] =
                    "Baris $baris: Golongan darah tidak valid";

                continue;
            }

            // ============================================
            // VALIDASI KEWARGANEGARAAN
            // ============================================
            $kewarganegaraan =
                strtoupper(
                    trim(
                        $data['kewarganegaraan']
                    )
                );

            if (
                !in_array(
                    $kewarganegaraan,
                    ['WNI', 'WNA']
                )
            ) {

                $this->errors[] =
                    "Baris $baris: Kewarganegaraan tidak valid";

                continue;
            }

            // ============================================
            // NORMALISASI DUSUN
            // ============================================
            $namaDusun =
                strtolower(
                    trim($data['nama_dusun'])
                );

            // ============================================
            // CARI RT
            // ============================================
            $rt = RT::whereRaw(
                    'CAST(no_rt AS UNSIGNED) = ?',
                    [(int) $data['no_rt']]
                )

                ->whereHas('rw', function ($q) use ($data, $namaDusun) {

                    $q->whereRaw(
                        'CAST(no_rw AS UNSIGNED) = ?',
                        [(int) $data['no_rw']]
                    )

                    ->whereHas(
                        'dusun',
                        function ($d) use ($namaDusun) {

                            $d->whereRaw(
                                'LOWER(TRIM(nama_dusun)) = ?',
                                [$namaDusun]
                            );
                        }
                    );
                })

                ->first();

            // ============================================
            // VALIDASI RT
            // ============================================
            if (!$rt) {

                $this->errors[] =
                    "Baris $baris: RT / RW / Dusun tidak ditemukan";

                continue;
            }

            // ============================================
            // SIMPAN DATA
            // ============================================
            try {

                Penduduk::create([

                    'nik' =>
                        trim($data['nik']),

                    'nama_lengkap' =>
                        trim($data['nama_lengkap']),

                    'jenis_kelamin' =>
                        $jenisKelamin,

                    'alamat' =>
                        trim($data['alamat']),

                    'tempat_lahir' =>
                        trim($data['tempat_lahir']),

                    'tanggal_lahir' =>
                        $tanggal,

                    'nama_ibu' =>
                        trim($data['nama_ibu']),

                    'nama_ayah' =>
                        trim($data['nama_ayah']),

                    'rt_id' =>
                        $rt->id,

                    'agama' =>
                        trim($data['agama']),

                    'profesi' =>
                        trim($data['profesi']),

                    'pendidikan' =>
                        trim($data['pendidikan']),

                    'status_kependudukan' =>
                        'aktif',

                    'status_perkawinan' =>
                        $status,

                    'golongan_darah' =>
                        $golongan,

                    'kewarganegaraan' =>
                        $kewarganegaraan,
                ]);

            } catch (\Exception $e) {

                $this->errors[] =
                    "Baris $baris: " .
                    $e->getMessage();
            }
        }
    }
}