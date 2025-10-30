<?php
// login.php
session_start();
include 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Email dan password harus diisi!';
    } else {
        $stmt = $conn->prepare("SELECT id, name, email, password_hash, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                // Log activity
                $activity = "User login: " . $user['name'];
                $log_stmt = $conn->prepare("INSERT INTO activity_logs (user_id, activity) VALUES (?, ?)");
                $log_stmt->bind_param("is", $user['id'], $activity);
                $log_stmt->execute();

                header("Location: index.php");
                exit;
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Email tidak terdaftar!';
        }
        $stmt->close();
    }
}

include 'includes/header.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card">
                    <h2 class="text-center mb-4"><i class="fas fa-sign-in-alt"></i> Login</h2>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </button>

                        <div class="text-center">
                            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                            <hr>
                            <small class="text-muted">
                                Demo Account:<br>
                                Admin: admin@simb.com / admin123<br>
                                User: user@simb.com / user123
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>