<?php
declare(strict_types=1);

/* =======================
   DANH MỤC
======================= */
$categories = [
    'laptop'   => 'Laptop',
    'pc'       => 'PC & Màn hình',
    'keyboard' => 'Bàn phím',
    'mouse'    => 'Chuột',
    'audio'    => 'Âm thanh'
];

/* =======================
   SẢN PHẨM
======================= */
$products = [
    1 => [
        'name'=>'Laptop Dell Inspiron',
        'price'=>15000000,
        'category'=>'laptop',
        'image'=>'/Lab05/assets/images/sp1.jpg'
    ],
    2 => [
        'name'=>'Laptop HP Pavilion',
        'price'=>16500000,
        'category'=>'laptop',
        'image'=>'/Lab05/assets/images/sp2.jpg'
    ],
    3 => [
        'name'=>'MacBook Air M1',
        'price'=>21500000,
        'category'=>'laptop',
        'image'=>'/Lab05/assets/images/sp3.jpg'
    ],
    4 => [
        'name'=>'PC Gaming RTX 3060',
        'price'=>28000000,
        'category'=>'pc',
        'image'=>'/Lab05/assets/images/sp4.jpg'
    ],
    5 => [
        'name'=>'Màn hình LG 24 inch',
        'price'=>3500000,
        'category'=>'pc',
        'image'=>'/Lab05/assets/images/sp5.jpg'
    ],
    6 => [
        'name'=>'Bàn phím cơ AKKO',
        'price'=>1200000,
        'category'=>'keyboard',
        'image'=>'/Lab05/assets/images/sp6.jpg'
    ],
    7 => [
        'name'=>'Bàn phím Logitech K120',
        'price'=>250000,
        'category'=>'keyboard',
        'image'=>'/Lab05/assets/images/sp7.jpg'
    ],
    8 => [
        'name'=>'Chuột Logitech G102',
        'price'=>450000,
        'category'=>'mouse',
        'image'=>'/Lab05/assets/images/sp8.jpg'
    ],
    9 => [
        'name'=>'Chuột Xiaomi',
        'price'=>280000,
        'category'=>'mouse',
        'image'=>'/Lab05/assets/images/sp9.jpg'
    ],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Dashboard sản phẩm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-4">

<h3 class="mb-4 fw-bold">🛍️ Danh sách sản phẩm</h3>

<div class="row g-4">
<?php foreach ($products as $id => $p): ?>
    <div class="col-md-3">
        <div class="card h-100 shadow-sm">
            <img src="<?= $p['image'] ?>"
                 class="card-img-top"
                 style="height:180px;object-fit:cover"
                 onerror="this.src='/Lab05/assets/images/sp1.jpg'">

            <div class="card-body">
                <h6 class="card-title"><?= htmlspecialchars($p['name']) ?></h6>
                <p class="text-danger fw-bold">
                    <?= number_format($p['price']) ?> ₫
                </p>
            </div>

            <div class="card-footer bg-white border-0">
                <a href="product_detail.php?id=<?= $id ?>"
                   class="btn btn-sm btn-primary w-100">
                   Xem chi tiết
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

</div>
</body>
</html>
    