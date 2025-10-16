<?php
//load config.php 
include("config/config.php");
 
// untuk api_key newsapi.org
$api_key="e8b4c499140641a1baf34db3566229a4";
 
// URL API 
$url="https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=".$api_key;
 
// menyimpan hasil dalam variabel
$data=http_request_get($url);
 
// konversi data json ke array
$hasil=json_decode($data,true);
 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Rest Client dengan cURL</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/theme.css">
    <style>
    .container {
        margin-top: 75px;
    }

    .error-box {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 15px;
        border-radius: 5px;
    }
    </style>
    </style>
    <script>
    // Persisted theme (light/dark) without changing PHP logic
    (function() {
        var stored = localStorage.getItem('theme');
        if (stored === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    })();
    </script>
</head>

<body>

    <nav class="navbar fixed-top navbar-expand-lg">
        <a class="navbar-brand" href="#">RestClient</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
            </ul>
            <div class="ms-auto ml-auto">
                <button id="themeToggle" type="button" class="btn theme-toggle" aria-label="Toggle dark mode">
                    <span id="themeIcon">🌙</span> <span class="d-none d-sm-inline">Dark</span>
                </button>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">

            <?php 

if (is_array($hasil) && isset($hasil['status']) && $hasil['status'] == 'ok' && isset($hasil['articles'])) {
    
    // Looping jika data valid
    foreach ($hasil['articles'] as $row) { 
?>

            <div class="col-md-4" style="margin-top: 10px; margin-bottom: 10px;">
                <div class="card" style="width: 100%;">
                    <img src="<?php echo $row['urlToImage'] ?? 'placeholder.jpg'; ?>" class="card-img-top"
                        height="180px" alt="Gambar Berita">
                    <div class="card-body">
                        <p class="card-text">
                            <i>Oleh <?php echo htmlspecialchars($row['author'] ?? 'N/A'); ?></i>
                            <br>
                            <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                        </p>
                        <p class="text-right"><a href="<?php echo htmlspecialchars($row['url']); ?>"
                                target="_blank">Selengkapnya..</a></p>
                    </div>
                </div>
            </div>

            <?php 
    } // Akhir foreach
    
} else {
    // Tampilkan pesan error jika API request gagal (API Key salah, kuota habis, dll.)
    echo '<div class="col-12">';
    echo '<div class="error-box">';
    echo '<h3>Error Mengambil Data API</h3>';
    
    if (isset($hasil['status']) && $hasil['status'] == 'error') {
        echo '<p><strong>Pesan API:</strong> ' . htmlspecialchars($hasil['message'] ?? 'Kesalahan tak teridentifikasi.') . '</p>';
        echo '<p>Pastikan API Key Anda valid dan kuota harian belum habis.</p>';
    } else {
        echo '<p>Gagal mengkonversi JSON atau response API tidak valid. (Kemungkinan error di fungsi http_request_get)</p>';
    }
    
    echo '</div>';
    echo '</div>';
}
?>

        </div>
    </div>

    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        var btn = document.getElementById('themeToggle');
        var icon = document.getElementById('themeIcon');
        if (!btn) return;
        function setIcon() {
            var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            icon.textContent = isDark ? '☀️' : '🌙';
        }
        setIcon();
        btn.addEventListener('click', function() {
            var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            if (isDark) {
                document.documentElement.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
            setIcon();
        });
    })();
    </script>
</body>

</html>