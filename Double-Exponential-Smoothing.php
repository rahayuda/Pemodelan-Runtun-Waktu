<?php
// Data bulan dan suhu rata-rata
$bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni");
$suhu = array(15, 17, 20, 22, 25, 28);

// Faktor penghalus untuk level dan tren
$alpha = 0.3;
$beta = 0.2;

// Inisialisasi nilai awal
$level = $suhu[0];
$tren = $suhu[1] - $suhu[0];

// Array untuk menyimpan nilai level dan tren setiap bulan
$levels = array($level);
$trends = array($tren);

// Peramalan level, tren, dan suhu untuk setiap bulan
for ($i = 1; $i < count($bulan); $i++) {
    $ramalanLevel = $alpha * $suhu[$i] + (1 - $alpha) * ($level + $tren);
    $ramalanTren = $beta * ($ramalanLevel - $level) + (1 - $beta) * $tren;
    
    $level = $ramalanLevel;
    $tren = $ramalanTren;
    
    // Simpan nilai level dan tren pada array
    $levels[] = $level;
    $trends[] = $tren;
}

// Cetak nilai level dan tren setiap bulan
for ($i = 0; $i < count($bulan); $i++) {
    echo "Bulan: " . $bulan[$i] . "<br>";
    echo "Level: " . round($levels[$i], 2) . "<br>";
    echo "Tren: " . round($trends[$i], 2) . "<br>";
	$ramalan = round($levels[$i], 2)+round($trends[$i], 2);
	echo "Ramalan: " . $ramalan . "<br><br>";
}

// Perhitungan level dan tren untuk bulan Juli
$ramalanLevelJuli = $alpha * $ramalanLevel + (1 - $alpha) * ($level + $tren);
$ramalanTrenJuli = $beta * ($ramalanLevelJuli - $ramalanLevel) + (1 - $beta) * $tren;

// Cetak nilai level dan tren untuk bulan Juli
echo "Bulan: Juli<br>";
echo "Level: " . round($ramalanLevelJuli, 2) . "<br>";
echo "Tren: " . round($ramalanTrenJuli, 2) . "<br><br>";

// Ramalan suhu rata-rata untuk bulan Juli
$ramalanSuhuJuli = $ramalanLevelJuli + $ramalanTrenJuli;
echo "Ramalan suhu rata-rata untuk bulan Juli: " . round($ramalanSuhuJuli, 2) . "°C";
?>
