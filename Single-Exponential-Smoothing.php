<?php

// Data Suhu Rata-Rata Bulanan
$data = array(
    "Januari" => 15,
    "Februari" => 17,
    "Maret" => 20,
    "April" => 22,
    "Mei" => 25,
    "Juni" => 28
);

// Faktor Penghalus (α)
$alpha = 0.3;

// Inisialisasi nilai awal peramalan
$ramalan = array();
$bulan = array_keys($data);
$suhu = array_values($data);
$ramalan[] = $suhu[0];

// Peramalan menggunakan Exponential Smoothing
for ($i = 1; $i < count($bulan); $i++) {
    $ramalan[] = $alpha * $suhu[$i - 1] + (1 - $alpha) * $ramalan[$i - 1];
}

// Menambahkan hasil peramalan untuk bulan Juli
$ramalan_juli = $alpha * $suhu[count($bulan) - 1] + (1 - $alpha) * end($ramalan);
$ramalan[] = $ramalan_juli;

// Menampilkan hasil peramalan
$hasil_peramalan = array();
for ($i = 0; $i < count($bulan); $i++) {
    $hasil_peramalan[] = array("Bulan" => $bulan[$i], "Ramalan" => $ramalan[$i]);
}
$hasil_peramalan[] = array("Bulan" => "Juli", "Ramalan" => $ramalan_juli);

foreach ($hasil_peramalan as $hasil) {
    echo "Bulan: " . $hasil["Bulan"] . "<br>";
	echo "Ramalan: " . $hasil["Ramalan"] . "<br><br>";
}


?>
