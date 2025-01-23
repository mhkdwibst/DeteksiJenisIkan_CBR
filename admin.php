<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login_admin.php');
    exit();
}

// Handle form submission for saving data from datasave to ikan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_data'])) {
    // Fetch saved data from datasave
    $sql_saved = "SELECT * FROM datasave";
    $result_saved = $conn->query($sql_saved);

    if ($result_saved && $result_saved->num_rows > 0) {
        while ($data = $result_saved->fetch_assoc()) {
            // Insert into ikan table
            $stmt_insert = $conn->prepare("INSERT INTO ikan (jenis_ikan, suhu_air_min, suhu_air_max, pH_min, pH_max, DO_min, DO_max, amonia_min, amonia_max, TDS_min, TDS_max, ketinggian_min, ketinggian_max, suhu_udara_min, suhu_udara_max, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt_insert->bind_param(
                "sdddddddddddddds",
                $data['jenis_ikan'],
                $data['suhu_air_min'],
                $data['suhu_air_max'],
                $data['pH_min'],
                $data['pH_max'],
                $data['DO_min'],
                $data['DO_max'],
                $data['amonia_min'],
                $data['amonia_max'],
                $data['TDS_min'],
                $data['TDS_max'],
                $data['ketinggian_min'],
                $data['ketinggian_max'],
                $data['suhu_udara_min'],
                $data['suhu_udara_max'],
                $data['gambar']
            );

            if ($stmt_insert->execute()) {
                // Delete from datasave table
                $delete_sql = "DELETE FROM datasave WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $data['id']);
                $delete_stmt->execute();
            } else {
                echo "Error: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        }
    }

    header('Location: admin.php');
    exit();
}

// Pagination setup
$items_per_page = 10; // Number of items per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch data from datasave table with pagination
$sql_saved = "SELECT * FROM datasave ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql_saved);
$stmt->bind_param("ii", $items_per_page, $offset);
$stmt->execute();
$result_saved = $stmt->get_result();

$saved_data = [];
if ($result_saved && $result_saved->num_rows > 0) {
    while ($row = $result_saved->fetch_assoc()) {
        $saved_data[] = $row;
    }
}

// Fetch total number of saved records for pagination
$sql_total = "SELECT COUNT(*) AS total FROM datasave";
$result_total = $conn->query($sql_total);
$total_records = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_records / $items_per_page);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Admin Panel</h1>
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Data yang Disimpan</h2>
            </div>
            <div class="card-body">
                <?php if (count($saved_data) > 0): ?>
                <form method="POST">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Suhu Air Min</th>
                                    <th>Suhu Air Max</th>
                                    <th>pH Min</th>
                                    <th>pH Max</th>
                                    <th>DO Min</th>
                                    <th>DO Max</th>
                                    <th>Amonia Min</th>
                                    <th>Amonia Max</th>
                                    <th>TDS Min</th>
                                    <th>TDS Max</th>
                                    <th>Ketinggian Min</th>
                                    <th>Ketinggian Max</th>
                                    <th>Suhu Udara Min</th>
                                    <th>Suhu Udara Max</th>
                                    <th>Gambar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($saved_data as $data): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data['id']); ?></td>
                                    <td><?php echo htmlspecialchars($data['suhu_air_min']); ?></td>
                                    <td><?php echo htmlspecialchars($data['suhu_air_max']); ?></td>
                                    <td><?php echo htmlspecialchars($data['pH_min']); ?></td>
                                    <td><?php echo htmlspecialchars($data['pH_max']); ?></td>
                                    <td><?php echo htmlspecialchars($data['DO_min']); ?></td>
                                    <td><?php echo htmlspecialchars($data['DO_max']); ?></td>
                                    <td><?php echo htmlspecialchars($data['amonia_min']); ?></td>
                                    <td><?php echo htmlspecialchars($data['amonia_max']); ?></td>
                                    <td><?php echo htmlspecialchars($data['TDS_min']); ?></td>
                                    <td><?php echo htmlspecialchars($data['TDS_max']); ?></td>
                                    <td><?php echo htmlspecialchars($data['ketinggian_min']); ?></td>
                                    <td><?php echo htmlspecialchars($data['ketinggian_max']); ?></td>
                                    <td><?php echo htmlspecialchars($data['suhu_udara_min']); ?></td>
                                    <td><?php echo htmlspecialchars($data['suhu_udara_max']); ?></td>
                                    <td>
                                        <?php if (!empty($data['gambar'])): ?>
                                        <img src="images/<?php echo htmlspecialchars($data['gambar']); ?>"
                                            alt="<?php echo htmlspecialchars($data['jenis_ikan']); ?>"
                                            class="img-thumbnail" style="max-width: 100px;">
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" name="save_data" class="btn btn-success btn-block">Simpan ke Tabel
                        Ikan</button>
                </form>
                <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    Tidak ada data yang disimpan.
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>