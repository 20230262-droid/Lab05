<?php
// 🚨 BẮT BUỘC có session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🚨 KHỞI TẠO GIỎ HÀNG
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/**
 * Thêm sản phẩm vào giỏ
 */
function cart_add(int $id, int $qty = 1): void
{
    if ($qty < 1) {
        $qty = 1;
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
}

/**
 * Cập nhật số lượng sản phẩm
 */
function cart_update(int $id, int $qty): void
{
    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]);
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
}

/**
 * Xóa toàn bộ giỏ hàng
 */
function cart_clear(): void
{
    $_SESSION['cart'] = [];
}

/**
 * Tổng số lượng sản phẩm trong giỏ
 */
function cart_count(): int
{
    return array_sum($_SESSION['cart']);
}

/**
 * Lấy giỏ hàng
 */
function cart_items(): array
{
    return $_SESSION['cart'];
}
