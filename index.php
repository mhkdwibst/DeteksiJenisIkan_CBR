<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Jenis Ikan Air Tawar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Deteksi Jenis Ikan Air Tawar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Beranda <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login_pakar.php">Login Pakar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login_admin.php">Login Admin</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="jumbotron jumbotron-fluid text-center bg-info text-white">
        <div class="container">
            <h1 class="display-4">Deteksi Jenis Ikan Air Tawar</h1>
            <p class="lead">Menentukan jenis ikan air tawar berdasarkan parameter kualitas air dan kondisi wilayah</p>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h3>Tentang Deteksi Jenis Ikan Air Tawar</h3>
                <p>
                    Dalam ekosistem air tawar, kualitas air dan kondisi lingkungan sangat berpengaruh terhadap kehidupan
                    ikan.
                    Beberapa parameter penting seperti suhu air, pH, kadar oksigen terlarut (DO), amonia, total padatan
                    terlarut (TDS),
                    ketinggian, dan suhu udara dapat membantu menentukan jenis ikan yang cocok di lingkungan tersebut.
                </p>
                <p>
                    Dengan memasukkan parameter-parameter tersebut, Anda dapat mengetahui jenis ikan yang paling sesuai
                    untuk kondisi
                    lingkungan tertentu, sehingga membantu dalam pengelolaan dan konservasi habitat ikan air tawar.
                </p>
            </div>
            <div class="col-md-4">
                <img src="ikan.png" alt="Contoh Ikan Air Tawar" class="img-fluid" alt="Gambar responsif">
            </div>
        </div>

        <div class="card shadow-sm p-4">
            <form action="process.php" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="do">DO (mg/L)</label>
                    <input type="number" step="0.01" class="form-control" id="do" name="do">
                </div>
                <div class="form-group">
                    <label for="amonia">Ammonia (mg/L)</label>
                    <input type="number" step="0.001" class="form-control" id="amonia" name="amonia">
                </div>
                <div class="form-group">
                    <label for="suhu_air">Suhu Air (°C)</label>
                    <input type="number" step="0.01" class="form-control" id="suhu_air" name="suhu_air">
                </div>
                <div class="form-group">
                    <label for="ph">pH</label>
                    <input type="number" step="0.01" class="form-control" id="ph" name="ph">
                </div>
                <div class="form-group">
                    <label for="tds">TDS (ppm)</label>
                    <input type="number" step="0.01" class="form-control" id="tds" name="tds">
                </div>
                <div class="form-group">
                    <label for="ketinggian">Ketinggian Dataran (m)</label>
                    <input type="number" step="0.01" class="form-control" id="ketinggian" name="ketinggian">
                </div>
                <div class="form-group">
                    <label for="suhu_udara">Suhu Udara (°C)</label>
                    <input type="number" step="0.01" class="form-control" id="suhu_udara" name="suhu_udara">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Cari Jenis Ikan</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>