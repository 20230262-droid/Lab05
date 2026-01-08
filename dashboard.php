<?php
declare(strict_types=1);

require_once 'includes/auth.php';
require_login();
require_once 'includes/header.php';

/* =======================
   DANH MỤC
======================= */
$categories = [
    'laptop'   => 'Laptop',
    'pc'       => 'PC & Màn hình',
    'keyboard' => 'Bàn phím',
    'mouse'    => 'Chuột',
    'audio'    => 'Âm thanh',
    'storage'  => 'Lưu trữ',
    'accessory'=> 'Phụ kiện'
];

/* =======================
   SẢN PHẨM
======================= */
$products = [
        1 => ['name'=>'Laptop Dell Inspiron','price'=>15000000,'category'=>'laptop','image'=>'assets/images/sp1.jpg'],
        2 => ['name'=>'Laptop HP Pavilion','price'=>16500000,'category'=>'laptop','image'=>'assets/images/sp2.jpg'],
        3 => ['name'=>'MacBook Air M1','price'=>21500000,'category'=>'laptop','image'=>'assets/images/sp3.jpg'],
        4 => ['name'=>'PC Gaming RTX 3060','price'=>28000000,'category'=>'pc','image'=>'assets/images/sp4.jpg'],
        5 => ['name'=>'Màn hình LG 24 inch','price'=>3500000,'category'=>'pc','image'=>'assets/images/sp5.jpg'],
        6 => ['name'=>'Bàn phím cơ AKKO','price'=>1200000,'category'=>'keyboard','image'=>'assets/images/sp6.jpg'],
        7 => ['name'=>'Bàn phím Logitech K120','price'=>250000,'category'=>'keyboard','image'=>'assets/images/sp7.jpg'],
        8 => ['name'=>'Chuột Logitech G102','price'=>450000,'category'=>'mouse','image'=>'assets/images/sp8.jpg'],
        9 => ['name'=>'Chuột không dây Xiaomi','price'=>280000,'category'=>'mouse','image'=>'assets/images/sp9.jpg'],

];

/* =======================
   GIẢM GIÁ TẾT
======================= */
$isTetSale = true;
$discountPercent = 10;

/* =======================
   SEARCH + LỌC
======================= */
$keyword = trim($_GET['q'] ?? '');
$cat = $_GET['cat'] ?? '';
$city = $_SESSION['city'] ?? 'HN';
$found = false;
?>

<div class="text-center mb-4">
    <h2 class="fw-bold">🛒 Sản phẩm công nghệ</h2>
    <p class="text-muted">Giá tại <?= $city === 'HCM' ? 'TP.HCM' : 'Hà Nội' ?></p>
</div>

<div class="mb-4 text-center">
<?php foreach ($categories as $key => $name): ?>
    <a href="dashboard.php?cat=<?= $key ?>"
       class="badge me-2 <?= $cat === $key ? 'bg-primary' : 'bg-secondary' ?>">
        <?= $name ?>
    </a>
<?php endforeach; ?>
<?php if ($cat): ?>
    <a href="dashboard.php" class="badge bg-danger ms-2">✖ Bỏ lọc</a>
<?php endif; ?>
</div>

<div class="row g-4">
<?php foreach ($products as $id => $p): ?>

<?php
if ($keyword && stripos($p['name'], $keyword) === false) continue;
if ($cat && $p['category'] !== $cat) continue;
$found = true;

$price = $p['price'];
if ($city === 'HCM') $price += 200000;

$finalPrice = $isTetSale
    ? $price * (100 - $discountPercent) / 100
    : $price;
?>

<div class="col-md-3">
    <div class="card h-100 shadow-sm product-card">

        <a href="product_detail.php?id=<?= $id ?>">
            <img src="<?= $p['image'] ?>"
                 class="card-img-top"
                 style="height:200px; object-fit:cover">
        </a>

        <div class="card-body text-center">
            <h6 class="fw-bold">
                <a href="product_detail.php?id=<?= $id ?>" style="text-decoration:none;">
                    <?= htmlspecialchars($p['name']) ?>
                </a>
            </h6>

            <?php if ($isTetSale): ?>
                <small><del><?= number_format($price) ?> ₫</del></small>
                <span class="badge bg-danger">-<?= $discountPercent ?>%</span>
            <?php endif; ?>

            <p class="text-danger fw-bold">
                <?= number_format($finalPrice) ?> ₫
            </p>

            <a href="cart.php?add=<?= $id ?>" class="btn btn-sm btn-primary">
                🛒 Thêm vào giỏ
            </a>
        </div>
    </div>
</div>

<?php endforeach; ?>
</div>

<?php if (!$found): ?>
<div class="alert alert-warning text-center mt-4">
    ❌ Không tìm thấy sản phẩm
</div>
<?php endif; ?>

<style>
body { background:#f6f7fb; }
.product-card { border-radius:14px; }
.product-card:hover { transform:translateY(-5px); transition:0.3s; }
</style>

<?php require_once 'includes/footer.php'; ?>
