<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login(): void
{
    if (
        !isset($_SESSION['auth']) ||
        $_SESSION['auth'] !== true ||
        !isset($_SESSION['user'])
    ) {
        header('Location: login.php');
        exit;
    }
}

function is_admin(): bool
{
    return isset($_SESSION['user']['role']) &&
           $_SESSION['user']['role'] === 'admin';
}

function logout(): void
{
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
