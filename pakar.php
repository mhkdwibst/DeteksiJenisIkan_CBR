<?php
session_start(); // Start the session
include 'db_connect.php';

// Pagination setup
$items_per_page = 10; // Number of items per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $items_per_page;

// Get session data for temporary updates
$temp_data = isset($_SESSION['temp_data']) ? $_SESSION['temp_data'] : null;

// Handle form submissions for deleting records
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        $id_to_delete = $_POST['delete_id'];
        $stmt = $conn->prepare("DELETE FROM input_pengguna WHERE id = ?");
        $stmt->bind_param("i", $id_to_delete);
        $stmt->execute();
        header("Location: pakar.php");
        exit();
    }
}

// Fetch distinct jenis ikan for pagination selection
$sql_types = "SELECT DISTINCT jenis_ikan FROM input_pengguna ORDER BY jenis_ikan";
$result_types = $conn->query($sql_types);
$jenis_ikan_list = [];
if ($result_types && $result_types->num_rows > 0) {
    while ($row = $result_types->fetch_assoc()) {
        $jenis_ikan_list[] = $row['jenis_ikan'];
    }
}

// Determine the selected jenis ikan
$selected_jenis_ikan = isset($_GET['jenis_ikan']) ? $_GET['jenis_ikan'] : (count($jenis_ikan_list) > 0 ? $jenis_ikan_list[0] : '');

// Fetch the latest input data for the selected jenis ikan with pagination
$sql_input = "SELECT ip.*, i.id AS ikan_id, i.suhu_air_min, i.suhu_air_max, i.pH_min, i.pH_max, i.DO_min, i.DO_max, i.amonia_min, i.amonia_max, i.TDS_min, i.TDS_max, i.ketinggian_min, i.ketinggian_max, i.suhu_udara_min, i.suhu_udara_max, i.gambar
               FROM input_pengguna ip
               JOIN ikan i ON ip.jenis_ikan = i.jenis_ikan
               WHERE ip.jenis_ikan = ?
               ORDER BY ip.id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql_input);
$stmt->bind_param("sii", $selected_jenis_ikan, $items_per_page, $offset);
$stmt->execute();
$result_input = $stmt->get_result();

$input_data = [];
if ($result_input && $result_input->num_rows > 0) {
    while ($row = $result_input->fetch_assoc()) {
        if ($temp_data && $row['jenis_ikan'] == $temp_data['jenis_ikan']) {
            // Use temporary data if available
            $row = array_merge($row, $temp_data);
        }
        $input_data[] = $row;
    }
}

// Fetch total number of records for the selected jenis ikan
$sql_total = "SELECT COUNT(*) AS total FROM input_pengguna WHERE jenis_ikan = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("s", $selected_jenis_ikan);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_records = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_records / $items_per_page);

// Clear temporary data after use
unset($_SESSION['temp_data']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakar Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .img-thumbnail {
        max-width: 120px;
        height: auto;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .card-header {
        background-color: #007bff;
        color: white;
    }

    .table-info {
        background-color: #e9ecef;
        font-weight: bold;
    }

    .btn-primary,
    .btn-secondary {
        margin: 0 5px;
    }

    .card-body {
        padding: 1.5rem;
    }
    </style>
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4 text-center">Pakar Panel</h1>

        <div class="card">
            <div class="card-header">
                <h2>Data Input Pengguna Terbaru</h2>
            </div>
            <div class="card-body">
                <!-- Dropdown for selecting jenis ikan -->
                <div class="mb-4">
                    <form method="GET" action="pakar.php">
                        <div class="form-group">
                            <label for="jenis_ikan">Pilih Jenis Ikan:</label>
                            <select id="jenis_ikan" name="jenis_ikan" class="form-control"
                                onchange="this.form.submit()">
                                <?php foreach ($jenis_ikan_list as $jenis): ?>
                                <option value="<?php echo htmlspecialchars($jenis); ?>"
                                    <?php echo $jenis === $selected_jenis_ikan ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($jenis); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>

                <?php if (count($input_data) > 0): ?>
                <div class="table-responsive">
                    <?php foreach ($input_data as $input): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <?php if (!empty($input['gambar'])): ?>
                                    <img src="images/<?php echo htmlspecialchars($input['gambar']); ?>"
                                        alt="<?php echo htmlspecialchars($input['jenis_ikan']); ?>"
                                        class="img-thumbnail">
                                    <?php else: ?>
                                    <p class="text-muted">No Image Available</p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-9">
                                    <h5><?php echo htmlspecialchars($input['jenis_ikan']); ?></h5>
                                    <table class="table table-bordered">
                                        <thead class="table-info">
                                            <tr>
                                                <th colspan="2">Data Input</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Suhu Air</td>
                                                <td><?php echo htmlspecialchars($input['suhu_air']); ?>°C</td>
                                            </tr>
                                            <tr>
                                                <td>pH</td>
                                                <td><?php echo htmlspecialchars($input['ph']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>DO</td>
                                                <td><?php echo htmlspecialchars($input['do']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>Amonia</td>
                                                <td><?php echo htmlspecialchars($input['amonia']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>TDS</td>
                                                <td><?php echo htmlspecialchars($input['tds']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>Ketinggian</td>
                                                <td><?php echo htmlspecialchars($input['ketinggian']); ?> m</td>
                                            </tr>
                                            <tr>
                                                <td>Suhu Udara</td>
                                                <td><?php echo htmlspecialchars($input['suhu_udara']); ?>°C</td>
                                            </tr>
                                            <tr>
                                                <td>Similarity</td>
                                                <td><?php echo number_format($input['similarity'], 2); ?>%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h6>Rentang Data Ikan</h6>
                                    <table class="table table-bordered">
                                        <thead class="table-info">
                                            <tr>
                                                <th colspan="2">Rentang Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Suhu Air Min</td>
                                                <td><?php echo htmlspecialchars($input['suhu_air_min']); ?>°C</td>
                                            </tr>
                                            <tr>
                                                <td>Suhu Air Max</td>
                                                <td><?php echo htmlspecialchars($input['suhu_air_max']); ?>°C</td>
                                            </tr>
                                            <tr>
                                                <td>pH Min</td>
                                                <td><?php echo htmlspecialchars($input['pH_min']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>pH Max</td>
                                                <td><?php echo htmlspecialchars($input['pH_max']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>DO Min</td>
                                                <td><?php echo htmlspecialchars($input['DO_min']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>DO Max</td>
                                                <td><?php echo htmlspecialchars($input['DO_max']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>Amonia Min</td>
                                                <td><?php echo htmlspecialchars($input['amonia_min']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>Amonia Max</td>
                                                <td><?php echo htmlspecialchars($input['amonia_max']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>TDS Min</td>
                                                <td><?php echo htmlspecialchars($input['TDS_min']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>TDS Max</td>
                                                <td><?php echo htmlspecialchars($input['TDS_max']); ?> mg/L</td>
                                            </tr>
                                            <tr>
                                                <td>Ketinggian Min</td>
                                                <td><?php echo htmlspecialchars($input['ketinggian_min']); ?> m</td>
                                            </tr>
                                            <tr>
                                                <td>Ketinggian Max</td>
                                                <td><?php echo htmlspecialchars($input['ketinggian_max']); ?> m</td>
                                            </tr>
                                            <tr>
                                                <td>Suhu Udara Min</td>
                                                <td><?php echo htmlspecialchars($input['suhu_udara_min']); ?>°C</td>
                                            </tr>
                                            <tr>
                                                <td>Suhu Udara Max</td>
                                                <td><?php echo htmlspecialchars($input['suhu_udara_max']); ?>°C</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-center mt-2">
                                        <a href="edit.php?id=<?php echo htmlspecialchars($input['ikan_id']); ?>"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form method="POST" action="pakar.php" style="display:inline;">
                                            <input type="hidden" name="delete_id"
                                                value="<?php echo htmlspecialchars($input['id']); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination Controls -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="pakar.php?page=<?php echo $page - 1; ?>&jenis_ikan=<?php echo urlencode($selected_jenis_ikan); ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link"
                                    href="pakar.php?page=<?php echo $i; ?>&jenis_ikan=<?php echo urlencode($selected_jenis_ikan); ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="pakar.php?page=<?php echo $page + 1; ?>&jenis_ikan=<?php echo urlencode($selected_jenis_ikan); ?>"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>

                    <?php else: ?>
                    <p class="text-center">Tidak ada data input pengguna terbaru.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center my-4">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
</body>

</html>