<?php

namespace App\Services;

use App\Models\NilaiAkhir;
use App\Models\PenilaianKinerja;
use App\Models\PenilaianLpk;
use App\Models\PenilaianLrk;
use App\Models\ProyekKkn;

class PenilaianService
{
    // Bobot komponen utama
    const BOBOT_LRK = 0.15;
    const BOBOT_KINERJA = 0.70;
    const BOBOT_LPK = 0.15;

    // Bobot sub-kriteria kinerja (total = 0.70, dinormalisasi ke skala 100)
    const BOBOT_PELAKSANAAN = 0.30;
    const BOBOT_DISIPLIN = 0.15;
    const BOBOT_KERJASAMA = 0.15;
    const BOBOT_PENGHAYATAN = 0.10;

    /**
     * Hitung nilai kinerja gabungan (skala 0-100) dari 4 kriteria.
     */
    public function hitungNilaiKinerja(float $pelaksanaan, float $disiplin, float $kerjasama, float $penghayatan): float
    {
        $total = ($pelaksanaan * self::BOBOT_PELAKSANAAN)
            + ($disiplin * self::BOBOT_DISIPLIN)
            + ($kerjasama * self::BOBOT_KERJASAMA)
            + ($penghayatan * self::BOBOT_PENGHAYATAN);

        // total bobot sub-kriteria = 0.70, dinormalisasi jadi skala 0-100
        return round($total / self::BOBOT_KINERJA, 2);
    }

    /**
     * Hitung nilai akhir dari LRK, Kinerja, LPK (masing-masing skala 0-100).
     */
    public function hitungNilaiAkhir(float $nilaiLrk, float $nilaiKinerja, float $nilaiLpk): float
    {
        $nilaiAkhir = ($nilaiLrk * self::BOBOT_LRK)
            + ($nilaiKinerja * self::BOBOT_KINERJA)
            + ($nilaiLpk * self::BOBOT_LPK);

        return round($nilaiAkhir, 2);
    }

    /**
     * Konversi Nilai Angka (NA) ke Nilai Mutu (NM).
     */
    public function konversiNilaiMutu(float $na): string
    {
        return match (true) {
            $na >= 85 => 'A',
            $na >= 78 => 'AB',
            $na >= 70 => 'B',
            $na >= 63 => 'BC',
            $na >= 55 => 'C',
            $na >= 40 => 'D',
            default => 'E',
        };
    }

    /**
     * Proses lengkap: simpan LRK, Kinerja, LPK, lalu hitung & simpan Nilai Akhir.
     */
    public function prosesPenilaianAkhir(ProyekKkn $proyek, array $data): NilaiAkhir
    {
        // Simpan/update LRK
        PenilaianLrk::updateOrCreate(
            ['proyek_kkn_id' => $proyek->id],
            ['nilai' => $data['nilai_lrk']]
        );

        // Simpan/update Kinerja
        PenilaianKinerja::updateOrCreate(
            ['proyek_kkn_id' => $proyek->id],
            [
                'pelaksanaan' => $data['pelaksanaan'],
                'disiplin' => $data['disiplin'],
                'kerjasama' => $data['kerjasama'],
                'penghayatan' => $data['penghayatan'],
            ]
        );

        // Simpan/update LPK
        PenilaianLpk::updateOrCreate(
            ['proyek_kkn_id' => $proyek->id],
            ['nilai' => $data['nilai_lpk']]
        );

        // Hitung nilai kinerja gabungan
        $nilaiKinerja = $this->hitungNilaiKinerja(
            $data['pelaksanaan'],
            $data['disiplin'],
            $data['kerjasama'],
            $data['penghayatan']
        );

        // Hitung nilai akhir
        $nilaiAkhir = $this->hitungNilaiAkhir($data['nilai_lrk'], $nilaiKinerja, $data['nilai_lpk']);

        // Konversi ke mutu
        $nilaiMutu = $this->konversiNilaiMutu($nilaiAkhir);

        // Simpan/update Nilai Akhir
        return NilaiAkhir::updateOrCreate(
            ['proyek_kkn_id' => $proyek->id],
            [
                'nilai_lrk' => $data['nilai_lrk'],
                'nilai_kinerja' => $nilaiKinerja,
                'nilai_lpk' => $data['nilai_lpk'],
                'nilai_akhir' => $nilaiAkhir,
                'nilai_mutu' => $nilaiMutu,
            ]
        );
    }
}