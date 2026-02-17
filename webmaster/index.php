<?php
session_start();
require_once __DIR__ . '/includes/db.php';

function loginAdmin($userId, $username) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $userId;
    $_SESSION['admin_username'] = $username;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            loginAdmin($user['id'], $user['username']);
            header('Location: /webmaster/dashboard');
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    } else {
        $error = 'Mohon isi semua kolom!';
    }
}

$title = "Login Admin";
include __DIR__ . '/include/head.php';
?>

<style>
    body {
        background: linear-gradient(to bottom right, #9C27B0, #7B1FA2);
        font-family: 'Poppins', sans-serif;
    }

    .login-card {
        background-color: #fff;
        border-radius: 16px;
        padding: 32px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.6s ease;
    }

    .login-card h2 {
        text-align: center;
        margin-bottom: 24px;
        color: #7B1FA2;
        font-weight: 600;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #ccc;
        font-size: 15px;
    }

    .form-control:focus {
        border-color: #9C27B0;
        box-shadow: 0 0 0 2px rgba(156, 39, 176, 0.2);
    }

    .btn-primary {
        background-color: #9C27B0;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #7B1FA2;
    }

    .alert {
        font-size: 14px;
        border-radius: 8px;
        padding: 10px 14px;
        margin-top: 10px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 500px) {
        .login-card {
            padding: 24px;
        }
    }
</style>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="login-card">
        <h2>Login Webmaster</h2>
        <form method="post" novalidate>
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/include/footer.php'; ?>
