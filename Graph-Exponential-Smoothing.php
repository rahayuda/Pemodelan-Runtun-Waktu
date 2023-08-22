<?php
$data = array(
    "Januari" => 15,
    "Februari" => 17,
    "Maret" => 20,
    "April" => 22,
    "Mei" => 25,
    "Juni" => 28
);

$alpha = 0.3;

$ramalan = array();
$bulan = array_keys($data);
$suhu = array_values($data);
$ramalan[] = $suhu[0];

for ($i = 1; $i < count($bulan); $i++) {
    $ramalan[] = $alpha * $suhu[$i - 1] + (1 - $alpha) * $ramalan[$i - 1];
}

$hasil_peramalan = array();
for ($i = 0; $i < count($bulan); $i++) {
    $hasil_peramalan[] = array("Bulan" => $bulan[$i], "Ramalan" => $ramalan[$i]);
}

$ramalan_juli = $alpha * $suhu[count($bulan) - 1] + (1 - $alpha) * end($ramalan);
$hasil_peramalan[] = array("Bulan" => "Juli", "Ramalan" => $ramalan_juli);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik Menggunakan Chart.js</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Hasil Peramalan Bulanan
                    </div>
                    <div class="card-body">
                        <div style="width: 400px; margin: 0 auto;">
                            <canvas id="myChart" width="500" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Tabel Hasil Peramalan
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Bulan</th>
                                    <th scope="col">Ramalan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hasil_peramalan as $hasil): ?>
                                <tr>
                                    <td><?php echo $hasil["Bulan"]; ?></td>
                                    <td><?php echo $hasil["Ramalan"]; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- ... (previous HTML code) -->

<script>
    var bulan = <?php echo json_encode(array_merge($bulan, ['Juli'])); ?>;
    var ramalan = <?php echo json_encode(array_merge($ramalan, [$ramalan_juli])); ?>;
    
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: bulan,
            datasets: [{
                label: 'Ramalan Suhu',
                data: ramalan,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
