<?php
session_start();

if (isset($_POST['city'])) {
    $_SESSION['city'] = $_POST['city'];
}

header('Location: dashboard.php');
exit;
