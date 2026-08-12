<?php

namespace App\Services;

use App\Models\NilaiAkhir;
use App\Models\PenilaianKinerja;
use App\Models\PenilaianLpk;
use App\Models\PenilaianLrk;
use App\Models\ProyekKkn;

class PenilaianService
{
    const BOBOT_LRK = 0.15;
    const BOBOT_KINERJA = 0.70;
    const BOBOT_LPK = 0.15;

    const BOBOT_PELAKSANAAN = 0.30;
    const BOBOT_DISIPLIN = 0.15;
    const BOBOT_KERJASAMA = 0.15;
    const BOBOT_PENGHAYATAN = 0.10;

    public function hitungNilaiKinerja(float $pelaksanaan, float $disiplin, float $kerjasama, float $penghayatan): float
    {
        $total = ($pelaksanaan * self::BOBOT_PELAKSANAAN)
            + ($disiplin * self::BOBOT_DISIPLIN)
            + ($kerjasama * self::BOBOT_KERJASAMA)
            + ($penghayatan * self::BOBOT_PENGHAYATAN);

        return round($total / self::BOBOT_KINERJA, 2);
    }

    public function hitungNilaiAkhir(float $nilaiLrk, float $nilaiKinerja, float $nilaiLpk): float
    {
        $nilaiAkhir = ($nilaiLrk * self::BOBOT_LRK)
            + ($nilaiKinerja * self::BOBOT_KINERJA)
            + ($nilaiLpk * self::BOBOT_LPK);

        return round($nilaiAkhir, 2);
    }

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
     * Proses penilaian akhir. LRK diambil dari proposal.nilai,
     * LPK diambil dari laporan_akhir.nilai. Dosen hanya input Kinerja.
     */
    public function prosesPenilaianAkhir(ProyekKkn $proyek, array $data): NilaiAkhir
    {
        $proyek->loadMissing('proposal', 'laporanAkhir');

        if (!$proyek->proposal || $proyek->proposal->nilai === null) {
            throw new \Exception('Nilai LRK belum tersedia. Pastikan proposal sudah di-ACC dengan nilai.');
        }

        if (!$proyek->laporanAkhir || $proyek->laporanAkhir->nilai === null) {
            throw new \Exception('Nilai LPK belum tersedia. Pastikan laporan akhir sudah dinilai.');
        }

        $nilaiLrk = $proyek->proposal->nilai;
        $nilaiLpk = $proyek->laporanAkhir->nilai;

        // Simpan salinan ke tabel penilaian_lrk & penilaian_lpk (untuk konsistensi struktur lama)
        PenilaianLrk::updateOrCreate(
            ['proyek_kkn_id' => $proyek->id],
            ['nilai' => $nilaiLrk]
        );

        PenilaianKinerja::updateOrCreate(
            ['proyek_kkn_id' => $proyek->id],
            [
                'pelaksanaan' => $data['pelaksanaan'],
                'disiplin' => $data['disiplin'],
                'kerjasama' => $data['kerjasama'],
                'penghayatan' => $data['penghayatan'],
            ]
        );

        PenilaianLpk::updateOrCreate(
            ['proyek_kkn_id' => $proyek->id],
            ['nilai' => $nilaiLpk]
        );

        $nilaiKinerja = $this->hitungNilaiKinerja(
            $data['pelaksanaan'],
            $data['disiplin'],
            $data['kerjasama'],
            $data['penghayatan']
        );

        $nilaiAkhir = $this->hitungNilaiAkhir($nilaiLrk, $nilaiKinerja, $nilaiLpk);
        $nilaiMutu = $this->konversiNilaiMutu($nilaiAkhir);

        return NilaiAkhir::updateOrCreate(
            ['proyek_kkn_id' => $proyek->id],
            [
                'nilai_lrk' => $nilaiLrk,
                'nilai_kinerja' => $nilaiKinerja,
                'nilai_lpk' => $nilaiLpk,
                'nilai_akhir' => $nilaiAkhir,
                'nilai_mutu' => $nilaiMutu,
            ]
        );
    }
}