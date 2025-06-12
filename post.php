<?php
require_once 'config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$post_id = $_GET['id'];

// Fetch post details
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name 
                       FROM posts p 
                       LEFT JOIN categories c ON p.category_id = c.id 
                       WHERE p.id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: index.php');
    exit();
}

// Fetch related posts
$stmt = $pdo->prepare("SELECT * FROM posts 
                       WHERE category_id = ? AND id != ? 
                       ORDER BY created_at DESC LIMIT 3");
$stmt->execute([$post['category_id'], $post_id]);
$related_posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Humala News</title>
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
                    <li class="nav-item">
                        <a class="nav-link" href="add_article.php">Tambah Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Post Header -->
    <div class="post-header" style="background-image: url('<?php echo htmlspecialchars($post['image_url']); ?>')">
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h1 class="display-4 text-white mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
                        <p class="lead text-white">
                            <span class="badge bg-primary"><?php echo htmlspecialchars($post['category_name']); ?></span>
                            <span class="ms-2">
                                <i class="far fa-calendar-alt me-1"></i>
                                <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Post Content -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="post-content">
                    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                </div>

                <!-- Share Buttons -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Bagikan Artikel</h5>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-primary">
                                <i class="fab fa-facebook-f me-2"></i>Facebook
                            </a>
                            <a href="#" class="btn btn-info text-white">
                                <i class="fab fa-twitter me-2"></i>Twitter
                            </a>
                            <a href="#" class="btn btn-danger">
                                <i class="fab fa-pinterest me-2"></i>Pinterest
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Related Posts -->
                <?php if (count($related_posts) > 0): ?>
                <div class="mt-5">
                    <h3 class="mb-4">Artikel Terkait</h3>
                    <div class="row">
                        <?php foreach($related_posts as $related): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card post-card h-100">
                                <img src="<?php echo htmlspecialchars($related['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($related['title']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($related['title']); ?></h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            <?php echo date('d M Y', strtotime($related['created_at'])); ?>
                                        </small>
                                        <a href="post.php?id=<?php echo $related['id']; ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-arrow-right me-1"></i> Baca
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Newsletter -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Berlangganan Newsletter</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Masukkan email Anda">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-2"></i>Berlangganan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Popular Posts -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Berita Populer</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Judul Berita Populer 1</h6>
                                    <small class="text-muted">3 hari</small>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Judul Berita Populer 2</h6>
                                    <small class="text-muted">5 hari</small>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Judul Berita Populer 3</h6>
                                    <small class="text-muted">1 minggu</small>
                                </div>
                            </a>
                        </div>
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