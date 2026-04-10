<?php

class Mahasiswa
{
    private $nama;
    private $nim;
    private $jurusan;
    private $nilai;

    public function __construct($nama, $nim, $jurusan, $nilai)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->jurusan = $jurusan;
        $this->nilai = $nilai;
    }


    public function getNama()
    {
        return $this->nama;
    }

    public function getNim()
    {
        return $this->nim;
    }

    public function getJurusan()
    {
        return $this->jurusan;
    }

    public function getNilai()
    {
        return $this->nilai;
    }

    public function getInfo()
    {
        echo "Nama: " . $this->nama . "(" . $this->nim . ")" . " - " . $this->jurusan . " - " . "Nilai: " . $this->nilai . " ";
    }

    public function cekLulus()
    {
        return $this->nilai >= 70 ? "LULUS" : "TIDAK LULUS";
    }
}

class DataMahasiswa
{
    private $daftar = [];
    public $no = 0;
    // public $no = 1;


    public function __construct()
    {
        $this->daftar[] = new Mahasiswa("Budi", "001", "Informatika", 85);
        $this->daftar[] = new Mahasiswa("Ani", "002", "Sistem Informasi", 65);
        $this->daftar[] = new Mahasiswa("Citra", "003", "Informatika", 90);
    }

    public function tambahMahasiswa($nama, $nim, $jurusan, $nilai)
    {
        $mahasiswa = new Mahasiswa($nama, $nim, $jurusan, $nilai);
        if (empty($nama) || empty($nim) || empty($jurusan) || empty($nilai)) {
            echo "Semua field harus diisi. Mahasiswa tidak dapat ditambahkan.\n";
            return;
        }
        if (!is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
            echo "Nilai harus berupa angka antara 0 dan 100. \nMahasiswa tidak dapat ditambahkan.\n";
            return;
        }
        if (strlen($nim) > 3 || !is_numeric($nim)) {
            echo "NIM harus berupa angka dan maksimal 3 digit.\n";
            echo "Data tidak dapat ditambahkan.\n";
            return;
        }
        $this->daftar[] = $mahasiswa;
        echo "Mahasiswa berhasil ditambahkan.\n";
    }

    public function tampilkanData()
    {
        if (empty($this->daftar)) {
            echo "Belum ada data mahasiswa yang tersedia.\n";
            return;
        }
        foreach ($this->daftar as $mahasiswa) {
            $no = array_search($mahasiswa, $this->daftar) + 1;
            echo $no . ". ";
            echo $mahasiswa->getInfo() . "[" . $mahasiswa->cekLulus() . "]\n";
        }
    }

    public function cariMahasiswa($nim)
    {
        foreach ($this->daftar as $mahasiswa) {
            if ($mahasiswa->getNim() == $nim) {
                return $mahasiswa;
            }
        }
        echo "Data mahasiswa dengan NIM $nim tidak ditemukan.\n";
        return;
    }
}
$dataMahasiswa = new DataMahasiswa();

function showMenu()
{
    echo "\n" . str_repeat("=", 40) . "\n";
    echo "          📋 DATA MAHASISWA";
    echo "\n" . str_repeat("=", 40) . "\n";
    echo "1. Lihat Semua Mahasiswa\n";
    echo "2. Tambah Mahasiswa\n";
    echo "3. Cari Mahasiswa\n";
    echo "4. Keluar\n";

    echo "\nPilih opsi (1-4): ";
}


while (true) {
    showMenu();
    $handle = fopen("php://stdin", "r");
    $input = trim(fgets($handle));


    switch ($input) {
        case '1':
            echo "\n" . str_repeat("=", 40) . "\n";
            echo "         📋 DAFTAR MAHASISWA";
            echo "\n" . str_repeat("=", 40) . "\n";
            $dataMahasiswa->tampilkanData();
            break;
        case '2':
            echo "Masukkan Nama: ";
            $nama = trim(fgets($handle));
            echo "Masukkan NIM: ";
            $nim = trim(fgets($handle));
            echo "Masukkan Jurusan: ";
            $jurusan = trim(fgets($handle));
            echo "Masukkan Nilai: ";
            $nilai = trim(fgets($handle));
            $dataMahasiswa->tambahMahasiswa($nama, $nim, $jurusan, $nilai);
            break;
        case '3':
            echo "Masukkan NIM yang ingin dicari: ";
            $nimCari = trim(fgets($handle));
            $mahasiswa = $dataMahasiswa->cariMahasiswa($nimCari);
            if ($mahasiswa) {
                echo "NIM: " . $mahasiswa->getNim() . "\n";
                echo "Nama: " . $mahasiswa->getNama() . "\n";
                echo "Jurusan: " . $mahasiswa->getJurusan() . "\n";
                echo "Nilai: " . $mahasiswa->getNilai() . "\n";
                echo "Status: " . $mahasiswa->cekLulus() . "\n";
            }
            break;
        case '4':
            echo "Terima kasih telah menggunakan program ini. Sampai jumpa!\n";
            exit;
        default:
            echo "Opsi tidak valid. Silakan pilih antara 1-4.\n";
    }
}
