<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Humala News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/logo.png" alt="Humala News Logo" height="30" class="me-2">Humala News
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Kategori</a>
                    </li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="add_article.php">Tambah Artikel</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="about.php">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Kontak</a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <span class="nav-link disabled">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo $_SESSION['role']; ?>)</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tentang Kami</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=800&q=80" alt="About Us" class="img-fluid rounded mb-3" style="max-height: 300px; width: 100%; object-fit: cover;">
                        </div>
                        <p class="lead">Humala News terpercaya yang menyajikan informasi terkini dan terpercaya untuk Anda.</p>
                        <p>Didirikan pada tahun 2024, Humala News berkomitmen untuk menyajikan informasi yang akurat, objektif, dan bermanfaat bagi pembaca. Kami mengutamakan kualitas konten dan kecepatan dalam menyampaikan berita kepada masyarakat.</p>
                        <p>Tim kami terdiri dari jurnalis profesional yang berpengalaman di bidang media dan komunikasi. Kami terus berupaya untuk memberikan layanan terbaik dan mengikuti perkembangan teknologi terkini dalam dunia jurnalistik digital.</p>
                        
                        <h4 class="mt-4 mb-3">Visi Kami</h4>
                        <p>Menjadi portal berita terpercaya dan terdepan yang menyajikan informasi berkualitas untuk masyarakat Indonesia.</p>
                        
                        <h4 class="mt-4 mb-3">Misi Kami</h4>
                        <ul>
                            <li>Menyajikan berita yang akurat dan terpercaya</li>
                            <li>Memberikan informasi yang bermanfaat dan relevan</li>
                            <li>Mengutamakan kecepatan dalam penyampaian berita</li>
                            <li>Mengembangkan teknologi untuk layanan yang lebih baik</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">Tentang Kami</h5>
                    <p>Humala News terpercaya yang menyajikan informasi terkini dan terpercaya untuk Anda.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Jl. Seipadang No. 108
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            081361335403
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            humalarizky@gmail.com
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Ikuti Kami</h5>
                    <div class="social-links mb-3">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-linkedin"></i></a>
                    </div>
                    <h5 class="mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-light text-decoration-none">Beranda</a></li>
                        <li><a href="about.php" class="text-light text-decoration-none">Tentang</a></li>
                        <li><a href="contact.php" class="text-light text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Humala News. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 