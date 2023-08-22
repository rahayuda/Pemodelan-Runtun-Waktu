<?php
// Data bulan dan suhu rata-rata
$bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni");
$suhu = array(15, 17, 20, 22, 25, 28);

// Faktor penghalus untuk level, tren, dan musiman
$alpha = 0.3;
$beta = 0.2;
$gamma = 0.1;

// Inisialisasi nilai awal
$level = $suhu[0];
$tren = $suhu[1] - $suhu[0];
$musiman = 0; // Nilai awal musiman

// Array untuk menyimpan nilai level, tren, dan musiman setiap bulan
$levels = array($level);
$trends = array($tren);
$musimans = array($musiman);

// Peramalan level, tren, dan musiman untuk setiap bulan
for ($i = 1; $i < count($bulan); $i++) {
    $ramalanLevel = $alpha * $suhu[$i] + (1 - $alpha) * ($level + $tren + $musiman);
    $ramalanTren = $beta * ($ramalanLevel - $level) + (1 - $beta) * $tren;
    $ramalanMusiman = $gamma * ($suhu[$i] - $ramalanLevel) + (1 - $gamma) * $musiman;
    
    $level = $ramalanLevel;
    $tren = $ramalanTren;
    $musiman = $ramalanMusiman;
    
    // Simpan nilai level, tren, dan musiman pada array
    $levels[] = $level;
    $trends[] = $tren;
    $musimans[] = $musiman;
}

// Cetak nilai level, tren, dan musiman setiap bulan
for ($i = 0; $i < count($bulan); $i++) {
    echo "Bulan: " . $bulan[$i] . "<br>";
    echo "Level: " . round($levels[$i], 2) . "<br>";
    echo "Tren: " . round($trends[$i], 2) . "<br>";
    echo "Musiman: " . round($musimans[$i], 2) . "<br>";
	$ramalan = round($levels[$i], 2)+round($trends[$i], 2)+round($musimans[$i], 2);
	echo "Ramalan: " . $ramalan . "<br><br>";
}

// Perhitungan level, tren, dan musiman untuk bulan Juli
$ramalanLevelJuli = $alpha * $ramalanLevel + (1 - $alpha) * ($level + $tren + $musiman);
$ramalanTrenJuli = $beta * ($ramalanLevelJuli - $level) + (1 - $beta) * $tren;
$ramalanMusimanJuli = $gamma * ($ramalanLevel - $ramalanLevelJuli) + (1 - $gamma) * $musiman;

// Cetak nilai level, tren, dan musiman untuk bulan Juli
echo "Bulan: Juli<br>";
echo "Level: " . round($ramalanLevelJuli, 2) . "<br>";
echo "Tren: " . round($ramalanTrenJuli, 2) . "<br>";
echo "Musiman: " . round($ramalanMusimanJuli, 2) . "<br><br>";

// Ramalan suhu rata-rata untuk bulan Juli
$ramalanSuhuJuli = $ramalanLevelJuli + $ramalanTrenJuli + $ramalanMusimanJuli;
echo "Bulan: Juli<br>";
echo "Ramalan suhu rata-rata untuk bulan Juli: " . round($ramalanSuhuJuli, 2) . "°C";
?>
