<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once 'config/database.php';

function slugify($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    $text = trim($text, '-');
    return $text;
}

// Tambah kategori
if (isset($_POST['add'])) {
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        $slug = slugify($name);
        $stmt = $pdo->prepare('INSERT INTO categories (name, slug, created_at) VALUES (?, ?, NOW())');
        $stmt->execute([$name, $slug]);
        header('Location: manage_categories.php');
        exit;
    }
}

// Edit kategori
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        $slug = slugify($name);
        $stmt = $pdo->prepare('UPDATE categories SET name=?, slug=? WHERE id=?');
        $stmt->execute([$name, $slug, $id]);
        header('Location: manage_categories.php');
        exit;
    }
}

// Hapus kategori
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id=?');
    $stmt->execute([$id]);
    header('Location: manage_categories.php');
    exit;
}

// Ambil semua kategori
$stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
$categories = $stmt->fetchAll();

// Untuk form edit
$edit_category = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id=?');
    $stmt->execute([$id]);
    $edit_category = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Humala News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                <li class="nav-item">
                    <a class="nav-link active" href="manage_categories.php">Kelola Kategori</a>
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
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Kelola Kategori</h4>
                </div>
                <div class="card-body">
                    <!-- Form tambah/edit kategori -->
                    <form method="POST" class="row g-2 mb-4">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" placeholder="Nama kategori" value="<?php echo $edit_category ? htmlspecialchars($edit_category['name']) : ''; ?>" required>
                        </div>
                        <div class="col-md-4 d-grid gap-2">
                            <?php if ($edit_category): ?>
                                <input type="hidden" name="id" value="<?php echo $edit_category['id']; ?>">
                                <button type="submit" name="edit" class="btn btn-warning">Simpan Perubahan</button>
                                <a href="manage_categories.php" class="btn btn-secondary">Batal</a>
                            <?php else: ?>
                                <button type="submit" name="add" class="btn btn-primary">Tambah Kategori</button>
                            <?php endif; ?>
                        </div>
                    </form>
                    <!-- Daftar kategori -->
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px;">No</th>
                                <th>Nama Kategori</th>
                                <th style="width:160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($categories as $cat): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($cat['name']); ?></td>
                                <td>
                                    <a href="manage_categories.php?edit=<?php echo $cat['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="manage_categories.php?delete=<?php echo $cat['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?');"><i class="fas fa-trash-alt"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> 