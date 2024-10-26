<?php
// Harga tiket
$hargaDewasa = 50000;
$hargaAnak = 30000;
$tambahanAkhirPekan = 10000;
$diskonBatas = 150000;
$diskonPersen = 10;

// Fungsi untuk menghitung total harga
function hitungTotalHarga($jenisTiket, $jumlah, $hari) {
    global $hargaDewasa, $hargaAnak, $tambahanAkhirPekan;
    
    $hargaPerTiket = ($jenisTiket == 'dewasa') ? $hargaDewasa : $hargaAnak;
    
    if (strtolower($hari) == "sabtu" || strtolower($hari) == "minggu") {
        $hargaPerTiket += $tambahanAkhirPekan;
    }
    
    $totalHarga = $hargaPerTiket * $jumlah;
    
    return $totalHarga; // Hanya mengembalikan total harga
}

// Fungsi untuk menampilkan menu utama
function tampilkanMenu() {
    echo "\n=== Sistem Pemesanan Tiket Bioskop ===\n";
    echo "1. Lihat Jenis dan Harga Tiket\n";
    echo "2. Beli Tiket\n";
    echo "3. Keluar\n";
    echo "Pilih opsi: ";
}

// Fungsi untuk menampilkan jenis tiket dan harga
function lihatHargaTiket() {
    global $hargaDewasa, $hargaAnak, $tambahanAkhirPekan;
    echo "\n--------------------------------------------------------";
    echo "\n***\t\t\t\tJenis dan Harga Tiket\t\t\t\t***\n";
    echo "\n\tTiket Dewasa: Rp " . number_format($hargaDewasa, 0, ',', '.') . "\n";
    echo "\tTiket Anak: Rp " . number_format($hargaAnak, 0, ',', '.') . "\n";
    echo "\tTambahan Biaya Akhir Pekan: Rp " . number_format($tambahanAkhirPekan, 0, ',', '.') . " per tiket\n";
    echo "--------------------------------------------------------\n";
}

// Fungsi untuk membersihkan layar
function clearScreen() {
    // Untuk Windows
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        // Untuk Linux dan Mac
        system('clear');
    }
}

// Fungsi untuk validasi input jumlah tiket
function validasiJumlahTiket($prompt) {
    do {
        echo $prompt;
        $input = trim(fgets(STDIN));
        
        if (!is_numeric($input) || $input < 0) {
            echo "Silakan masukkan angka untuk jumlah tiket yang ingin Anda beli!\n\n"; // Peringatan jika bukan angka
        }
    } while (!is_numeric($input) || $input < 0); // Pastikan input adalah angka dan tidak negatif
    return (int)$input;
}

// Fungsi untuk validasi hari pemesanan
function validasiHariPembelian() {
    $hariValid = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];
    do {
        echo "Masukkan hari pemesanan (Senin - Minggu): ";
        $hari = trim(fgets(STDIN));
        
        if (!in_array(strtolower($hari), $hariValid)) {
            echo "Masukkan nama hari dengan benar untuk melanjutkan.\n\n"; // Peringatan jika hari tidak valid
        }
    } while (!in_array(strtolower($hari), $hariValid)); // Pastikan hari yang dimasukkan valid
    return $hari;
}

// Fungsi untuk membeli tiket
function beliTiket() {
    global $diskonBatas, $diskonPersen;
    
    echo "\n";
    $jumlahDewasa = validasiJumlahTiket("Masukkan jumlah tiket dewasa: ");
    $jumlahAnak = validasiJumlahTiket("Masukkan jumlah tiket anak: ");
    $hari = validasiHariPembelian();

    $totalDewasa = hitungTotalHarga('dewasa', $jumlahDewasa, $hari);
    $totalAnak = hitungTotalHarga('anak', $jumlahAnak, $hari);

    $totalSeb = $totalDewasa + $totalAnak; // Total sebelum diskon
    
    echo "\n----------------------------------------------------";
    echo "\n***\t\t  Rincian Pemesanan Tiket Bioskop  \t\t***\n\n";
    echo "\t\tTiket Dewasa: Rp " . number_format($totalDewasa, 0, ',', '.') . "\n";
    echo "\t\tTiket Anak: Rp " . number_format($totalAnak, 0, ',', '.') . "\n";
    // Hanya tampilkan harga sebelum diskon jika total lebih dari diskon batas
    if ($totalSeb > $diskonBatas) {
        echo "\t\tTotal Sebelum Diskon: Rp " . number_format($totalSeb, 0, ',', '.') . "\n";
    }

    // Total setelah diskon
    $totalSetelahDiskon = $totalSeb; // Mulai dari total sebelum diskon
    if ($totalSeb > $diskonBatas) {
        $diskon = $totalSeb * ($diskonPersen / 100);
        $totalSetelahDiskon -= $diskon; // Terapkan diskon
        echo "\t\tDiskon 10% Diterapkan: Rp " . number_format($diskon, 0, ',', '.') . "\n";
    }
    
    echo "----------------------------------------------------";
    echo "\n|\t\t\t   Total Akhir: Rp " . number_format($totalSetelahDiskon, 0, ',', '.') . "   \t\t\t|\n";
    echo "----------------------------------------------------";
    echo "\n\nTerima kasih sudah membeli tiket di Bioskop Kami! ^^\n";
    echo "\t\t ** Selamat menikmati filmnya! **\n\n";
    echo "----------------------------------------------------\n";
}

// Program utama
do {
    clearScreen(); // Bersihkan layar sebelum menampilkan menu
    tampilkanMenu();
    $pilihan = trim(fgets(STDIN));

    switch ($pilihan) {
        case "1":
            clearScreen(); // Bersihkan layar sebelum menampilkan harga tiket
            lihatHargaTiket();
            echo "Tekan Enter untuk kembali...";
            trim(fgets(STDIN));
            break;
        case "2":
            clearScreen(); // Bersihkan layar sebelum membeli tiket
            beliTiket();
            echo "Tekan Enter untuk kembali...";
            trim(fgets(STDIN));
            break;
        case "3":
            echo "\nTerima kasih! Sampai jumpa lagi.\n";
            break;
        default:
            echo "\nOpsi tidak valid!!\n";
            echo "\nTekan Enter untuk kembali...";
            trim(fgets(STDIN));
            break;
    }
} while ($pilihan != "3");
?>
