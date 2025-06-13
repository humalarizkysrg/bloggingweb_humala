<?php
require_once 'config/database.php';
session_start();

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$posts_per_page = 5;
$offset = ($page - 1) * $posts_per_page;

// Base query for search
$search_query = "SELECT * FROM posts WHERE title LIKE :search OR content LIKE :search";
$count_query = "SELECT COUNT(*) FROM posts WHERE title LIKE :search OR content LIKE :search";

// If search is active
if (!empty($search)) {
    $search_param = "%{$search}%";
    $stmt = $pdo->prepare($search_query . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':search', $search_param, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $posts_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $search_results = $stmt->fetchAll();

    // Get total count for pagination
    $stmt = $pdo->prepare($count_query);
    $stmt->bindValue(':search', $search_param, PDO::PARAM_STR);
    $stmt->execute();
    $total_posts = $stmt->fetchColumn();
    $total_pages = ceil($total_posts / $posts_per_page);
} else {
    $search_results = [];
    $total_pages = 0;
}

// Fetch featured posts
$stmt = $pdo->query("SELECT * FROM posts WHERE featured = 1 ORDER BY created_at DESC LIMIT 3");
$featured_posts = $stmt->fetchAll();

// Fetch recent posts
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 6");
$recent_posts = $stmt->fetchAll();

// Fetch categories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humala News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
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
                        <a class="nav-link active" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Kategori</a>
                    </li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="add_article.php">Tambah Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_categories.php">Kelola Kategori</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang</a>
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

    <!-- Featured Posts -->
    <div class="container mt-4">
        <h2 class="mb-4">Berita Utama</h2>
        <div class="row">
            <?php foreach($featured_posts as $post): ?>
            <div class="col-md-4 mb-4">
                <div class="featured-post" style="background-image: url('<?php echo htmlspecialchars($post['image_url']); ?>')">
                    <div class="overlay">
                        <h3 class="h4"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="mb-2"><?php echo substr(htmlspecialchars($post['excerpt']), 0, 100); ?>...</p>
                        <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right me-1"></i> Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Recent Posts -->
            <div class="col-md-8">
                <h2 class="mb-4">Berita Terbaru</h2>
                <div class="row">
                    <?php foreach($recent_posts as $post): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card post-card h-100">
                            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                                <p class="card-text"><?php echo substr(htmlspecialchars($post['excerpt']), 0, 100); ?>...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                                    </small>
                                    <div>
                                        <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-arrow-right me-1"></i> Baca
                                        </a>
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <a href="edit_article.php?id=<?php echo $post['id']; ?>" class="btn btn-warning btn-sm me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_article.php?id=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Search Form -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-search me-2"></i>Cari Berita</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" placeholder="Cari berita..." value="<?php echo htmlspecialchars($search); ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        
                        <?php if (!empty($search)): ?>
                            <div class="search-results">
                                <h6 class="mb-3">Hasil Pencarian</h6>
                                <?php if (count($search_results) > 0): ?>
                                    <?php foreach($search_results as $post): ?>
                                        <div class="mb-3">
                                            <h6 class="mb-1">
                                                <a href="post.php?id=<?php echo $post['id']; ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                                            </small>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <!-- Pagination -->
                                    <?php if ($total_pages > 1): ?>
                                        <nav aria-label="Halaman hasil pencarian">
                                            <ul class="pagination pagination-sm justify-content-center">
                                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>">
                                                            <?php echo $i; ?>
                                                        </a>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>
                                        </nav>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="text-muted">Tidak ada hasil yang ditemukan.</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Categories -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Kategori</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php foreach($categories as $category): ?>
                            <li class="mb-2">
                                <a href="category.php?id=<?php echo $category['id']; ?>" class="text-decoration-none">
                                    <i class="fas fa-angle-right me-2"></i>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="card">
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
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">Tentang Kami</h5>
                    <p>Portal berita terpercaya yang menyajikan informasi terkini dan terpercaya untuk Anda.</p>
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