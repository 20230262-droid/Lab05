<?php
session_start();

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Lấy dữ liệu POST
$id  = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

// Kiểm tra ID hợp lệ
if ($id > 0) {
    if ($qty <= 0) {
        // Xóa sản phẩm khỏi giỏ
        unset($_SESSION['cart'][$id]);
    } else {
        // Cập nhật số lượng
        $_SESSION['cart'][$id] = $qty;
    }
}

// BẮT BUỘC redirect
header('Location: cart.php');
exit;
