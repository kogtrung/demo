<?php include 'app/views/shares/header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center rounded-top-4">
                    <h3 class="mb-0"><i class="fas fa-user-plus"></i> Đăng ký tài khoản</h3>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($errors) && count($errors) > 0): ?>
                        <div class="alert alert-danger text-center mb-3">
                            <?php foreach ($errors as $err) echo $err . '<br>'; ?>
                        </div>
                    <?php endif; ?>
                    <form action="/webbanhang4/account/save" method="post">
                        <div class="mb-4">
                            <label for="username" class="form-label text-success fw-bold"><i class="fas fa-user"></i> Tên đăng nhập</label>
                            <input type="text" class="form-control rounded-pill" id="username" name="username" required placeholder="Nhập tên đăng nhập">
                        </div>
                        <div class="mb-4">
                            <label for="fullname" class="form-label text-success fw-bold"><i class="fas fa-id-card"></i> Họ và tên</label>
                            <input type="text" class="form-control rounded-pill" id="fullname" name="fullname" required placeholder="Nhập họ và tên">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label text-success fw-bold"><i class="fas fa-lock"></i> Mật khẩu</label>
                            <input type="password" class="form-control rounded-pill" id="password" name="password" required placeholder="Nhập mật khẩu">
                        </div>
                        <div class="mb-4">
                            <label for="confirmpassword" class="form-label text-success fw-bold"><i class="fas fa-lock"></i> Xác nhận mật khẩu</label>
                            <input type="password" class="form-control rounded-pill" id="confirmpassword" name="confirmpassword" required placeholder="Nhập lại mật khẩu">
                        </div>
                        <button class="btn btn-success btn-block font-weight-bold shadow rounded-pill py-2 mb-2 w-100" type="submit"><i class="fas fa-user-plus"></i> Đăng ký</button>
                        <div class="mt-3 text-center">
                            <span>Đã có tài khoản?</span> <a href="/webbanhang4/account/login" class="text-warning fw-bold">Đăng nhập</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>