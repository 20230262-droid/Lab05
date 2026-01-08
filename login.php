<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$file = __DIR__ . '/data/users.json';
$users = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

$error = '';
$success = '';

/*
|--------------------------------------------------------------------------
| ĐÃ LOGIN → VÀO DASHBOARD
|--------------------------------------------------------------------------
*/
if (!empty($_SESSION['auth'])) {
    header('Location: dashboard.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| XỬ LÝ FORM
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action   = $_POST['action'] ?? 'login';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'user';

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    }

    /* ================== LOGIN ================== */
    elseif ($action === 'login') {

        if (!isset($users[$username])) {
            $error = 'Sai tài khoản hoặc mật khẩu.';
        } elseif (!password_verify($password, $users[$username]['hash'])) {
            $error = 'Sai tài khoản hoặc mật khẩu.';
        } else {
            session_regenerate_id(true);
            $_SESSION['auth'] = true;
            $_SESSION['user'] = [
                'username' => $username,
                'role'     => $users[$username]['role']
            ];
            header('Location: dashboard.php');
            exit;
        }

    }

    /* ================== REGISTER ================== */
    elseif ($action === 'register') {

        if (isset($users[$username])) {
            $error = 'Username đã tồn tại.';
        } else {

            // Đếm admin
            $adminCount = 0;
            foreach ($users as $u) {
                if ($u['role'] === 'admin') $adminCount++;
            }

            if ($role === 'admin' && $adminCount >= 3) {
                $error = 'Chỉ được tối đa 3 tài khoản admin.';
            } else {

                $users[$username] = [
                    'hash' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $role
                ];

                file_put_contents(
                    $file,
                    json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                );

                $success = 'Đăng ký thành công. Vui lòng đăng nhập.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Login / Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card shadow">
<div class="card-body">

<h4 class="text-center mb-4 fw-bold">🔐 Shop Demo</h4>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post">

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input class="form-control" name="username">
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password">
    </div>

    <!-- CHỌN CHỨC NĂNG -->
    <div class="mb-3">
        <label class="form-label">Hành động</label>
        <select class="form-select" name="action" onchange="toggleRole(this.value)">
            <option value="login">Đăng nhập</option>
            <option value="register">Đăng ký</option>
        </select>
    </div>

    <!-- ROLE (CHỈ HIỆN KHI ĐĂNG KÝ) -->
    <div class="mb-3" id="roleBox" style="display:none;">
        <label class="form-label">Loại tài khoản</label>
        <select class="form-select" name="role">
            <option value="user">User</option>
            <option value="admin">Admin (tối đa 3)</option>
        </select>
    </div>

    <button class="btn btn-primary w-100">
        Xác nhận
    </button>

</form>

</div>
</div>

</div>
</div>
</div>

<script>
function toggleRole(value) {
    document.getElementById('roleBox').style.display =
        value === 'register' ? 'block' : 'none';
}
</script>

</body>
</html>
