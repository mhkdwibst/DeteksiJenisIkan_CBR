<?php
include 'db_connect.php';

// Ambil input pengguna
$suhu_air = $_POST['suhu_air'];
$ph = $_POST['ph'];
$do = $_POST['do'];
$amonia = $_POST['amonia'];
$tds = $_POST['tds'];
$ketinggian = $_POST['ketinggian'];
$suhu_udara = $_POST['suhu_udara'];

// Ambil data ikan dari database
$sql = "SELECT * FROM ikan";
$result = $conn->query($sql);

$scores = [];

while ($row = $result->fetch_assoc()) {
    // Hitung similaritas dengan mempertimbangkan bobot
    $matched = 0;
    $total_weight = 11; // Total bobot parameter
    $explanation = '';

    // Cek suhu air
    if ($suhu_air >= $row['suhu_air_min'] && $suhu_air <= $row['suhu_air_max']) {
        $matched += 2;
        $explanation .= "Suhu Air ({$suhu_air} dalam rentang [{$row['suhu_air_min']}, {$row['suhu_air_max']}]) cocok: 2\n";
    } else {
        $explanation .= "Suhu Air ({$suhu_air} di luar rentang [{$row['suhu_air_min']}, {$row['suhu_air_max']}]) tidak cocok: 0\n";
    }

    // Cek pH
    if ($ph >= $row['pH_min'] && $ph <= $row['pH_max']) {
        $matched += 2;
        $explanation .= "pH ({$ph} dalam rentang [{$row['pH_min']}, {$row['pH_max']}]) cocok: 2\n";
    } else {
        $explanation .= "pH ({$ph} di luar rentang [{$row['pH_min']}, {$row['pH_max']}]) tidak cocok: 0\n";
    }

    // Cek DO
    if ($do >= $row['DO_min'] && $do <= $row['DO_max']) {
        $matched += 2;
        $explanation .= "DO ({$do} dalam rentang [{$row['DO_min']}, {$row['DO_max']}]) cocok: 2\n";
    } else {
        $explanation .= "DO ({$do} di luar rentang [{$row['DO_min']}, {$row['DO_max']}]) tidak cocok: 0\n";
    }

    // Cek Amonia
    if ($amonia >= $row['amonia_min'] && $amonia <= $row['amonia_max']) {
        $matched += 2;
        $explanation .= "Amonia ({$amonia} dalam rentang [{$row['amonia_min']}, {$row['amonia_max']}]) cocok: 2\n";
    } else {
        $explanation .= "Amonia ({$amonia} di luar rentang [{$row['amonia_min']}, {$row['amonia_max']}]) tidak cocok: 0\n";
    }

    // Cek TDS
    if ($tds >= $row['TDS_min'] && $tds <= $row['TDS_max']) {
        $matched += 1;
        $explanation .= "TDS ({$tds} dalam rentang [{$row['TDS_min']}, {$row['TDS_max']}]) cocok: 1\n";
    } else {
        $explanation .= "TDS ({$tds} di luar rentang [{$row['TDS_min']}, {$row['TDS_max']}]) tidak cocok: 0\n";
    }

    // Cek Ketinggian
    if ($ketinggian >= $row['ketinggian_min'] && $ketinggian <= $row['ketinggian_max']) {
        $matched += 1;
        $explanation .= "Ketinggian ({$ketinggian} dalam rentang [{$row['ketinggian_min']}, {$row['ketinggian_max']}]) cocok: 1\n";
    } else {
        $explanation .= "Ketinggian ({$ketinggian} di luar rentang [{$row['ketinggian_min']}, {$row['ketinggian_max']}]) tidak cocok: 0\n";
    }

    // Cek Suhu Udara
    if ($suhu_udara >= $row['suhu_udara_min'] && $suhu_udara <= $row['suhu_udara_max']) {
        $matched += 1;
        $explanation .= "Suhu Udara ({$suhu_udara} dalam rentang [{$row['suhu_udara_min']}, {$row['suhu_udara_max']}]) cocok: 1\n";
    } else {
        $explanation .= "Suhu Udara ({$suhu_udara} di luar rentang [{$row['suhu_udara_min']}, {$row['suhu_udara_max']}]) tidak cocok: 0\n";
    }

    // Hitung similarity
    $similarity = ($matched / $total_weight) * 100;

    // Gabungkan hasil untuk jenis ikan yang sama
    if ($similarity > 0) {
        if (isset($scores[$row['jenis_ikan']])) {
            // Ambil skor tertinggi untuk jenis ikan yang sama
            $existing_similarity = $scores[$row['jenis_ikan']]['similarity'];
            if ($similarity > $existing_similarity) {
                $scores[$row['jenis_ikan']] = [
                    'similarity' => $similarity,
                    'gambar' => $row['gambar'],
                    'explanation' => $explanation
                ];
            }
        } else {
            $scores[$row['jenis_ikan']] = [
                'similarity' => $similarity,
                'gambar' => $row['gambar'],
                'explanation' => $explanation
            ];
        }
    }
}

// Ubah array ke format yang bisa diurutkan
$scores = array_map(function($key, $value) {
    return ['jenis_ikan' => $key] + $value;
}, array_keys($scores), $scores);

// Urutkan berdasarkan similarity tertinggi
usort($scores, function($a, $b) {
    return $b['similarity'] - $a['similarity'];
});

// Simpan data input dan hasil similarity ke database
foreach ($scores as $result) {
    $stmt = $conn->prepare("INSERT INTO input_pengguna (suhu_air, ph, do, amonia, tds, ketinggian, suhu_udara, similarity, jenis_ikan, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ddddiidsss", $suhu_air, $ph, $do, $amonia, $tds, $ketinggian, $suhu_udara, $result['similarity'], $result['jenis_ikan'], $result['gambar']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Deteksi Ikan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .result-item {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 15px;
    }

    .result-item img {
        max-width: 150px;
        margin-right: 20px;
    }

    .result-item h5 {
        margin-bottom: 10px;
    }

    .result-item small {
        font-size: 0.9em;
        color: #777;
    }

    .result-item p {
        margin: 0;
    }

    .alert-danger {
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="my-4">Hasil Deteksi Jenis Ikan</h1>
        <?php if (count($scores) > 0): ?>
        <div class="list-group">
            <?php foreach ($scores as $result): ?>
            <div class="list-group-item result-item">
                <div class="d-flex align-items-center">
                    <img src="images/<?php echo htmlspecialchars($result['gambar']); ?>"
                        alt="<?php echo htmlspecialchars($result['jenis_ikan']); ?>" class="img-thumbnail">
                    <div>
                        <h5 class="mb-1"><?php echo htmlspecialchars($result['jenis_ikan']); ?></h5>
                        <small><?php echo number_format($result['similarity'], 2); ?>%</small>
                    </div>
                </div>
                <div class="mt-3">
                    <p><?php echo nl2br(htmlspecialchars($result['explanation'])); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="alert alert-danger" role="alert">
            Tidak ada nilai parameter yang cocok dalam deteksi jenis ikan air tawar.
        </div>
        <?php endif; ?>

        <!-- Button Kembali -->
        <a href="index.php" class="btn btn-primary mt-4">Kembali</a>
    </div>
</body>

</html>