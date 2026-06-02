<?php

namespace App\Services;

class FuzzySugenoService
{
    public function calculate(float $permintaan, float $persediaan): float
    {
        // 1. Fuzzifikasi Permintaan
        $muPermintaanKecil = $this->permintaanKecil($permintaan);
        $muPermintaanSedang = $this->permintaanSedang($permintaan);
        $muPermintaanBesar = $this->permintaanBesar($permintaan);

        // 2. Fuzzifikasi Persediaan
        $muPersediaanSedikit = $this->persediaanSedikit($persediaan);
        $muPersediaanSedang = $this->persediaanSedang($persediaan);
        $muPersediaanBanyak = $this->persediaanBanyak($persediaan);

        // Nilai Output (Z)
        $zSedikit = 1996;
        $zSedang = 2275;
        $zBanyak = 2579;

        // 3. Evaluasi Rules (Alpha Predicate)
        // Rule 1: IF Permintaan Kecil AND Persediaan Sedikit THEN Produksi Sedikit
        $alpha1 = min($muPermintaanKecil, $muPersediaanSedikit);
        $z1 = $zSedikit;

        // Rule 2: IF Permintaan Kecil AND Persediaan Sedang THEN Produksi Sedikit
        $alpha2 = min($muPermintaanKecil, $muPersediaanSedang);
        $z2 = $zSedikit;

        // Rule 3: IF Permintaan Kecil AND Persediaan Banyak THEN Produksi Sedikit
        $alpha3 = min($muPermintaanKecil, $muPersediaanBanyak);
        $z3 = $zSedikit;

        // Rule 4: IF Permintaan Sedang AND Persediaan Sedikit THEN Produksi Sedikit
        $alpha4 = min($muPermintaanSedang, $muPersediaanSedikit);
        $z4 = $zSedikit;

        // Rule 5: IF Permintaan Sedang AND Persediaan Sedang THEN Produksi Sedang
        $alpha5 = min($muPermintaanSedang, $muPersediaanSedang);
        $z5 = $zSedang;

        // Rule 6: IF Permintaan Sedang AND Persediaan Banyak THEN Produksi Sedang
        $alpha6 = min($muPermintaanSedang, $muPersediaanBanyak);
        $z6 = $zSedang;

        // Rule 7: IF Permintaan Besar AND Persediaan Sedikit THEN Produksi Sedikit
        $alpha7 = min($muPermintaanBesar, $muPersediaanSedikit);
        $z7 = $zSedikit;

        // Rule 8: IF Permintaan Besar AND Persediaan Sedang THEN Produksi Sedang
        $alpha8 = min($muPermintaanBesar, $muPersediaanSedang);
        $z8 = $zSedang;

        // Rule 9: IF Permintaan Besar AND Persediaan Banyak THEN Produksi Banyak
        $alpha9 = min($muPermintaanBesar, $muPersediaanBanyak);
        $z9 = $zBanyak;

        // 4. Defuzzifikasi (Weighted Average)
        $totalAlphaZ = ($alpha1 * $z1) + ($alpha2 * $z2) + ($alpha3 * $z3) +
                       ($alpha4 * $z4) + ($alpha5 * $z5) + ($alpha6 * $z6) +
                       ($alpha7 * $z7) + ($alpha8 * $z8) + ($alpha9 * $z9);

        $totalAlpha = $alpha1 + $alpha2 + $alpha3 + 
                      $alpha4 + $alpha5 + $alpha6 + 
                      $alpha7 + $alpha8 + $alpha9;

        if ($totalAlpha == 0) {
            return 0; // Menghindari division by zero
        }

        return $totalAlphaZ / $totalAlpha;
    }

    private function permintaanKecil(float $x): float
    {
        if ($x <= 1030) return 1;
        if ($x > 1030 && $x <= 1310) return (1310 - $x) / 280;
        return 0;
    }

    private function permintaanSedang(float $x): float
    {
        if ($x <= 1030 || $x >= 1589) return 0;
        if ($x > 1030 && $x <= 1310) return ($x - 1030) / 280;
        if ($x > 1310 && $x < 1589) return (1589 - $x) / 279;
        return 0;
    }

    private function permintaanBesar(float $x): float
    {
        if ($x <= 1310) return 0;
        if ($x > 1310 && $x <= 1589) return ($x - 1310) / 279;
        return 1;
    }

    private function persediaanSedikit(float $y): float
    {
        if ($y <= 607) return 1;
        if ($y > 607 && $y <= 750) return (750 - $y) / 143;
        return 0;
    }

    private function persediaanSedang(float $y): float
    {
        if ($y <= 607 || $y >= 894) return 0;
        if ($y > 607 && $y <= 750) return ($y - 607) / 143;
        if ($y > 750 && $y < 894) return (894 - $y) / 144;
        return 0;
    }

    private function persediaanBanyak(float $y): float
    {
        if ($y <= 750) return 0;
        if ($y > 750 && $y <= 894) return ($y - 750) / 144;
        return 1;
    }
}
