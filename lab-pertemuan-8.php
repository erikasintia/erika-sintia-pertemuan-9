<?php
// LAB 9 — Exception (bagian PHPUnit dikerjakan lokal, kirim tautan repositori)
// Spesifikasi:
//  - NilaiTidakValidException & SaldoTidakCukupException extends Exception
//  - Siswa(): setNilai(int) melempar NilaiTidakValidException jika di luar 0–100
//  - Rekening(float $saldo): tarik(float) melempar SaldoTidakCukupException; getSaldo(): float

class NilaiTidakValidException extends Exception
{
}

class SaldoTidakCukupException extends Exception
{
}

class Siswa
{
    private int $nilai = 0;

    public function setNilai(int $nilai): void
    {
        if ($nilai < 0 || $nilai > 100) {
            throw new NilaiTidakValidException("Error: Nilai {$nilai} tidak valid. Nilai harus antara 0 dan 100.");
        }
        
        $this->nilai = $nilai;
    }

    public function getNilai(): int
    {
        return $this->nilai;
    }
}

class Rekening
{
    public function __construct(private float $saldo = 0)
    {
    }

    public function tarik(float $jumlah): void
    {
        if ($jumlah > $this->saldo) {
            throw new SaldoTidakCukupException("Error: Saldo tidak cukup. Saldo saat ini: {$this->saldo}, ditarik: {$jumlah}");
        }
     
        $this->saldo -= $jumlah;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }
}

// ==========================================
// PENGUJIAN
// ==========================================

try {
    $siswa = new Siswa();
    $siswa->setNilai(150); 
} catch (NilaiTidakValidException $e) {
    echo 'Tertangkap: ' . $e->getMessage() . PHP_EOL;
}

echo "------------------------\n"; // Pemisah agar output lebih rapi

try {
    $rekening = new Rekening(50000); 
    echo "Saldo awal: " . $rekening->getSaldo() . PHP_EOL;
    $rekening->tarik(100000); 
} catch (SaldoTidakCukupException $e) {
    echo 'Tertangkap: ' . $e->getMessage() . PHP_EOL;
}