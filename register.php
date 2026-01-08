<?php
require_once 'includes/auth.php';
require_once 'includes/csrf.php';
require_once 'includes/flash.php';

require_login();

/* chỉ admin */
if ($_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền.');
}

$file = __DIR__ . '/data/users.json';
$users = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_check($_POST['csrf'] ?? '')) {
        $error = 'CSRF không hợp lệ.';
    } else {

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? 'user';

        if ($username === '' || $password === '') {
            $error = 'Vui lòng nhập đầy đủ thông tin.';
        } elseif (isset($users[$username])) {
            $error = 'Username đã tồn tại.';
        } else {

            /* đếm admin */
            $adminCount = 0;
            foreach ($users as $u) {
                if (($u['role'] ?? '') === 'admin') {
                    $adminCount++;
                }
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

                set_flash('success', 'Tạo tài khoản thành công.');
                header('Location: dashboard.php');
                exit;
            }
        }
    }
}

require_once 'includes/header.php';
?>

<h3>Tạo tài khoản</h3>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input class="form-control" name="username" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select class="form-select" name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button class="btn btn-primary">Tạo tài khoản</button>
</form>

<?php require_once 'includes/footer.php'; ?>
