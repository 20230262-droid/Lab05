<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$file = __DIR__ . '/data/users.json';
$users = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

$error = '';
$success = '';

/* ĐẾM ADMIN */
$adminCount = 0;
foreach ($users as $u) {
    if (($u['role'] ?? '') === 'admin') {
        $adminCount++;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mode     = $_POST['mode'] ?? 'login'; // login | register
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'user';

    /* ===== LOGIN ===== */
    if ($mode === 'login') {

        if (!isset($users[$username]) ||
            !password_verify($password, $users[$username]['hash'])) {
            $error = 'Sai tài khoản hoặc mật khẩu.';
        } else {
            $_SESSION['auth'] = true;
            $_SESSION['user'] = [
                'username' => $username,
                'role'     => $users[$username]['role']
            ];
            header('Location: dashboard.php');
            exit;
        }
    }

    /* ===== REGISTER ===== */
    if ($mode === 'register') {

        if ($username === '' || $password === '') {
            $error = 'Vui lòng nhập đầy đủ thông tin.';
        } elseif (isset($users[$username])) {
            $error = 'Username đã tồn tại.';
        } elseif ($role === 'admin' && $adminCount >= 3) {
            $error = 'Hệ thống chỉ cho phép tối đa 3 admin.';
        } else {
            $users[$username] = [
                'hash' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role
            ];

            file_put_contents(
                $file,
                json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            $success = 'Tạo tài khoản thành công. Bạn có thể đăng nhập.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng nhập / Đăng ký</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5" style="max-width:450px">

<div class="card shadow">
<div class="card-body">

<h4 class="text-center mb-3">🔐 Đăng nhập / 📝 Đăng ký</h4>

<?php if ($error): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post">

<!-- MODE -->
<div class="mb-3">
<select class="form-select" name="mode" id="mode" onchange="toggleRegister()">
<option value="login">Đăng nhập</option>
<option value="register">Đăng ký</option>
</select>
</div>

<input class="form-control mb-2" name="username" placeholder="Username" required>
<input type="password" class="form-control mb-2" name="password" placeholder="Password" required>

<!-- ROLE (CHỈ HIỆN KHI ĐĂNG KÝ) -->
<div class="mb-3 d-none" id="roleBox">
<label class="form-label">Loại tài khoản</label>
<select class="form-select" name="role">
<option value="user">User</option>
<option value="admin">Admin (tối đa 3)</option>
</select>
</div>

<button class="btn btn-primary w-100">Xác nhận</button>
</form>

</div>
</div>
</div>

<script>
function toggleRegister() {
    const mode = document.getElementById('mode').value;
    document.getElementById('roleBox').classList
        .toggle('d-none', mode !== 'register');
}
</script>

</body>
</html>
