<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// USER
$user = $_SESSION['user'] ?? null;
$city = $_SESSION['city'] ?? 'HN';

// ĐẾM GIỎ HÀNG
$cartCount = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Shop Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- TOP BAR -->
<div class="bg-dark text-white py-1">
    <div class="container d-flex justify-content-between">
        <div>
            📍 Cửa hàng gần nhất:
            <b><?= $city === 'HCM' ? 'TP. Hồ Chí Minh' : 'Hà Nội' ?></b>
        </div>
        <div>
            ☎ Tư vấn: <b class="text-warning">1900 9999</b>
        </div>
    </div>
</div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold text-primary" href="products.php">
            🛒 Shop Demo
        </a>

        <!-- SEARCH -->
        <form class="d-flex flex-grow-1 mx-4" method="get" action="products.php">
            <input
                class="form-control me-2"
                type="search"
                name="q"
                placeholder="Tìm sản phẩm..."
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
            >
            <button class="btn btn-primary">Tìm</button>
        </form>

        <!-- LOCATION -->
        <form method="post" action="set_city.php" class="me-3">
            <select
                name="city"
                class="form-select form-select-sm"
                onchange="this.form.submit()"
            >
                <option value="HN" <?= $city === 'HN' ? 'selected' : '' ?>>
                    Hà Nội
                </option>
                <option value="HCM" <?= $city === 'HCM' ? 'selected' : '' ?>>
                    TP. HCM
                </option>
            </select>
        </form>

        <!-- CART -->
        <a href="cart.php" class="btn btn-outline-primary position-relative me-3">
            🛒
            <?php if ($cartCount > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $cartCount ?>
                </span>
            <?php endif; ?>
        </a>

        <!-- USER -->
        <?php if ($user): ?>
            <div class="d-flex align-items-center">
                <span class="me-2">
                    👋 <?= htmlspecialchars($user['username']) ?>
                </span>
                <a href="logout.php" class="btn btn-sm btn-outline-danger">
                    Logout
                </a>
            </div>
        <?php endif; ?>

    </div>
</nav>

<!-- CONTENT START -->
<div class="container mt-4">
