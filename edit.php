<?php
session_start();
include 'db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $jenis_ikan = $_POST['jenis_ikan'];
    $suhu_air_min = floatval($_POST['suhu_air_min']);
    $suhu_air_max = floatval($_POST['suhu_air_max']);
    $pH_min = floatval($_POST['pH_min']);
    $pH_max = floatval($_POST['pH_max']);
    $DO_min = floatval($_POST['DO_min']);
    $DO_max = floatval($_POST['DO_max']);
    $amonia_min = floatval($_POST['amonia_min']);
    $amonia_max = floatval($_POST['amonia_max']);
    $TDS_min = floatval($_POST['TDS_min']);
    $TDS_max = floatval($_POST['TDS_max']);
    $ketinggian_min = floatval($_POST['ketinggian_min']);
    $ketinggian_max = floatval($_POST['ketinggian_max']);
    $suhu_udara_min = floatval($_POST['suhu_udara_min']);
    $suhu_udara_max = floatval($_POST['suhu_udara_max']);

    // Handle file upload
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'images/' . basename($gambar);

    // Check if a new image is uploaded
    if (!empty($gambar)) {
        // Move uploaded file to the images directory
        move_uploaded_file($gambar_tmp, $gambar_path);
    } else {
        // Keep the existing image if no new image is uploaded
        $gambar = $_POST['existing_gambar'];
    }

    // Insert the updated record into the datasave table
    $stmt_insert = $conn->prepare("INSERT INTO datasave (jenis_ikan, suhu_air_min, suhu_air_max, pH_min, pH_max, DO_min, DO_max, amonia_min, amonia_max, TDS_min, TDS_max, ketinggian_min, ketinggian_max, suhu_udara_min, suhu_udara_max, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_insert->bind_param("sdddddddddddddds", $jenis_ikan, $suhu_air_min, $suhu_air_max, $pH_min, $pH_max, $DO_min, $DO_max, $amonia_min, $amonia_max, $TDS_min, $TDS_max, $ketinggian_min, $ketinggian_max, $suhu_udara_min, $suhu_udara_max, $gambar);
    $stmt_insert->execute();

    // Delete related records from input_pengguna
    $stmt_delete_input = $conn->prepare("DELETE FROM input_pengguna WHERE jenis_ikan = ?");
    $stmt_delete_input->bind_param("s", $jenis_ikan);
    $stmt_delete_input->execute();

    // Optionally delete the record from the ikan table
    $stmt_delete = $conn->prepare("DELETE FROM ikan WHERE id = ?");
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();

    // Redirect to pakar.php
    header("Location: pakar.php");
    exit();
}

// Get the record to edit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM ikan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
} else {
    $record = null;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Ikan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2>Edit Data Ikan</h2>
            </div>
            <div class="card-body">
                <?php if ($record): ?>
                <form method="POST" action="edit.php" enctype="multipart/form-data">
                    <input type="hidden" name="update_id" value="<?php echo htmlspecialchars($record['id']); ?>">
                    <input type="hidden" name="existing_gambar"
                        value="<?php echo htmlspecialchars($record['gambar']); ?>">

                    <div class="form-group">
                        <label for="jenis_ikan">Jenis Ikan</label>
                        <input type="text" class="form-control" id="jenis_ikan" name="jenis_ikan"
                            value="<?php echo htmlspecialchars($record['jenis_ikan']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="suhu_air_min">Suhu Air Min</label>
                        <input type="number" step="0.1" class="form-control" id="suhu_air_min" name="suhu_air_min"
                            value="<?php echo htmlspecialchars($record['suhu_air_min']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="suhu_air_max">Suhu Air Max</label>
                        <input type="number" step="0.1" class="form-control" id="suhu_air_max" name="suhu_air_max"
                            value="<?php echo htmlspecialchars($record['suhu_air_max']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pH_min">pH Min</label>
                        <input type="number" step="0.1" class="form-control" id="pH_min" name="pH_min"
                            value="<?php echo htmlspecialchars($record['pH_min']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pH_max">pH Max</label>
                        <input type="number" step="0.1" class="form-control" id="pH_max" name="pH_max"
                            value="<?php echo htmlspecialchars($record['pH_max']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="DO_min">DO Min</label>
                        <input type="number" step="0.1" class="form-control" id="DO_min" name="DO_min"
                            value="<?php echo htmlspecialchars($record['DO_min']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="DO_max">DO Max</label>
                        <input type="number" step="0.1" class="form-control" id="DO_max" name="DO_max"
                            value="<?php echo htmlspecialchars($record['DO_max']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="amonia_min">Amonia Min</label>
                        <input type="number" step="0.001" class="form-control" id="amonia_min" name="amonia_min"
                            value="<?php echo htmlspecialchars($record['amonia_min']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="amonia_max">Amonia Max</label>
                        <input type="number" step="0.001" class="form-control" id="amonia_max" name="amonia_max"
                            value="<?php echo htmlspecialchars($record['amonia_max']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="TDS_min">TDS Min</label>
                        <input type="number" step="0.1" class="form-control" id="TDS_min" name="TDS_min"
                            value="<?php echo htmlspecialchars($record['TDS_min']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="TDS_max">TDS Max</label>
                        <input type="number" step="0.1" class="form-control" id="TDS_max" name="TDS_max"
                            value="<?php echo htmlspecialchars($record['TDS_max']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ketinggian_min">Ketinggian Min</label>
                        <input type="number" step="0.1" class="form-control" id="ketinggian_min" name="ketinggian_min"
                            value="<?php echo htmlspecialchars($record['ketinggian_min']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ketinggian_max">Ketinggian Max</label>
                        <input type="number" step="0.1" class="form-control" id="ketinggian_max" name="ketinggian_max"
                            value="<?php echo htmlspecialchars($record['ketinggian_max']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="suhu_udara_min">Suhu Udara Min</label>
                        <input type="number" step="0.1" class="form-control" id="suhu_udara_min" name="suhu_udara_min"
                            value="<?php echo htmlspecialchars($record['suhu_udara_min']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="suhu_udara_max">Suhu Udara Max</label>
                        <input type="number" step="0.1" class="form-control" id="suhu_udara_max" name="suhu_udara_max"
                            value="<?php echo htmlspecialchars($record['suhu_udara_max']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="gambar">Gambar</label>
                        <?php if (!empty($record['gambar'])): ?>
                        <div class="mb-3">
                            <img src="images/<?php echo htmlspecialchars($record['gambar']); ?>" alt="Current Image"
                                class="img-thumbnail" style="max-width: 150px;">
                        </div>
                        <?php endif; ?>
                        <input type="file" class="form-control-file" id="gambar" name="gambar">
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="pakar.php" class="btn btn-secondary">Cancel</a>
                </form>
                <?php else: ?>
                <div class="alert alert-danger">
                    Data ikan tidak ditemukan.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>