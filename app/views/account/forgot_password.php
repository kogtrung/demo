<?php include 'app/views/shares/header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center rounded-top-4">
                    <h3 class="mb-0"><i class="fas fa-key"></i> Quên mật khẩu</h3>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger text-center mb-3"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success text-center mb-3"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="/webbanhang4/account/processForgotPassword">
                        <div class="form-group mb-4">
                            <label for="username" class="font-weight-bold text-success"><i class="fas fa-user"></i> Tên đăng nhập:</label>
                            <input type="text" id="username" name="username" class="form-control rounded-pill" required placeholder="Nhập tên đăng nhập" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" <?php if (!empty($showPasswordFields)) echo 'readonly'; ?>>
                        </div>
                        <?php if (!empty($showPasswordFields)): ?>
                        <div class="form-group mb-4">
                            <label for="new_password" class="font-weight-bold text-success"><i class="fas fa-lock"></i> Mật khẩu mới:</label>
                            <input type="password" id="new_password" name="new_password" class="form-control rounded-pill" required placeholder="Nhập mật khẩu mới">
                        </div>
                        <div class="form-group mb-4">
                            <label for="confirm_password" class="font-weight-bold text-success"><i class="fas fa-lock"></i> Xác nhận mật khẩu mới:</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control rounded-pill" required placeholder="Nhập lại mật khẩu mới">
                        </div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-success btn-block font-weight-bold shadow rounded-pill py-2 mb-2 w-100"><i class="fas fa-key"></i> <?php echo !empty($showPasswordFields) ? 'Đặt lại mật khẩu' : 'Tiếp tục'; ?></button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="/webbanhang4/account/login" class="text-success"><i class="fas fa-arrow-left"></i> Quay lại đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?> 