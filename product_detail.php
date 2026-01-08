<?php
session_start();

/* =======================
   DỮ LIỆU SẢN PHẨM
======================= */
$products = [
    1 => [
        'name'=>'Laptop Dell Inspiron',
        'price'=>15000000,
        'image'=>'assets/images/sp1.jpg',
        'brand'=>'Dell',
        'specs'=>'Intel Core i5 • RAM 8GB • SSD 512GB • 15.6" Full HD',
        'description'=>'Laptop Dell Inspiron phù hợp học tập, làm việc văn phòng.'
    ],
    2 => [
        'name'=>'Laptop HP Pavilion',
        'price'=>16500000,
        'image'=>'assets/images/sp2.jpg',
        'brand'=>'HP',
        'specs'=>'Intel Core i5 • RAM 8GB • SSD 512GB • 14" Full HD',
        'description'=>'HP Pavilion thiết kế gọn nhẹ, hiệu năng ổn định.'
    ],
    3 => [
        'name'=>'MacBook Air M1',
        'price'=>21500000,
        'image'=>'assets/images/sp3.jpg',
        'brand'=>'Apple',
        'specs'=>'Apple M1 • RAM 8GB • SSD 256GB • Retina 13.3"',
        'description'=>'MacBook Air M1 pin lâu, mượt mà cho học tập và làm việc.'
    ],
    4 => [
        'name'=>'PC Gaming RTX 3060',
        'price'=>28000000,
        'image'=>'assets/images/sp4.jpg',
        'brand'=>'Custom',
        'specs'=>'Ryzen 5 • RTX 3060 • RAM 16GB • SSD 1TB',
        'description'=>'PC Gaming cấu hình cao, chiến game AAA mượt.'
    ],
    5 => [
        'name'=>'Màn hình LG 24 inch',
        'price'=>3500000,
        'image'=>'assets/images/sp5.jpg',
        'brand'=>'LG',
        'specs'=>'24 inch • Full HD • IPS • 75Hz',
        'description'=>'Màn hình LG sắc nét, bảo vệ mắt.'
    ],
    6 => [
        'name'=>'Bàn phím cơ AKKO',
        'price'=>1200000,
        'image'=>'assets/images/sp6.jpg',
        'brand'=>'AKKO',
        'specs'=>'Switch cơ • LED RGB • Layout 87 phím',
        'description'=>'Bàn phím cơ AKKO cho game thủ.'
    ],
    7 => [
        'name'=>'Bàn phím Logitech K120',
        'price'=>250000,
        'image'=>'assets/images/sp7.jpg',
        'brand'=>'Logitech',
        'specs'=>'USB • Full size • Chống nước nhẹ',
        'description'=>'Bàn phím văn phòng bền bỉ.'
    ],
    8 => [
        'name'=>'Chuột Logitech G102',
        'price'=>450000,
        'image'=>'assets/images/sp8.jpg',
        'brand'=>'Logitech',
        'specs'=>'DPI 8000 • RGB • Có dây',
        'description'=>'Chuột gaming chính xác cao.'
    ],
    9 => [
        'name'=>'Chuột không dây Xiaomi',
        'price'=>280000,
        'image'=>'assets/images/sp9.jpg',
        'brand'=>'Xiaomi',
        'specs'=>'Wireless • Pin AA • Nhẹ',
        'description'=>'Chuột Xiaomi thiết kế tối giản.'
    ],
];

/* =======================
   KIỂM TRA ID
======================= */
$id = (int)($_GET['id'] ?? 0);
if (!isset($products[$id])) {
    die('❌ Sản phẩm không tồn tại');
}
$p = $products[$id];

/* =======================
   XỬ LÝ ẢNH (CHỐNG LỖI)
======================= */
$imagePath = $p['image'];
if (!file_exists($imagePath)) {
    $imagePath = 'assets/images/no-image.jpg';
}

/* =======================
   GIẢM GIÁ TẾT
======================= */
$isTetSale = true;
$discountPercent = 10;
$finalPrice = $isTetSale
    ? $p['price'] * (100 - $discountPercent) / 100
    : $p['price'];

/* =======================
   THÊM VÀO GIỎ
======================= */
if (isset($_POST['add'])) {
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    $msg = "✅ Đã thêm vào giỏ hàng";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($p['name']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
<div class="row">

    <div class="col-md-5">
        <img src="<?= $imagePath ?>" class="img-fluid rounded shadow">
    </div>

    <div class="col-md-7">
        <h3 class="fw-bold"><?= htmlspecialchars($p['name']) ?></h3>

        <p><strong>Hãng:</strong> <?= $p['brand'] ?></p>
        <p><strong>Cấu hình:</strong> <?= $p['specs'] ?></p>

        <?php if ($isTetSale): ?>
            <p>
                <del><?= number_format($p['price']) ?> ₫</del>
                <span class="badge bg-danger">Tết -<?= $discountPercent ?>%</span>
            </p>
        <?php endif; ?>

        <h4 class="text-danger fw-bold">
            <?= number_format($finalPrice) ?> ₫
        </h4>

        <p><?= $p['description'] ?></p>

        <?php if (!empty($msg)): ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php endif; ?>

        <form method="post">
            <button name="add" class="btn btn-primary">🛒 Thêm vào giỏ</button>
            <a href="dashboard.php" class="btn btn-secondary ms-2">⬅ Quay lại</a>
        </form>
    </div>

</div>
</div>
</body>
</html>
