<?php include 'app/views/shares/header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-lg border-0 rounded-4 bg-dark text-white">
                <div class="card-header bg-success text-white text-center rounded-top-4">
                    <h3 class="mb-0"><i class="fas fa-sign-in-alt"></i> Đăng nhập</h3>
                </div>
                <div class="card-body p-4">
                    <form action="/webbanhang4/account/checklogin" method="post">
                        <div class="mb-4">
                            <label for="username" class="form-label text-success fw-bold"><i class="fas fa-user"></i> Tên đăng nhập</label>
                            <input type="text" name="username" id="username" class="form-control rounded-pill" required placeholder="Nhập tên đăng nhập">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label text-success fw-bold"><i class="fas fa-lock"></i> Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control rounded-pill" required placeholder="Nhập mật khẩu">
                        </div>
                        <p class="small mb-4 pb-lg-2"><a class="text-warning fw-bold" href="/webbanhang4/account/forgotPassword">Quên mật khẩu?</a></p>
                        <button class="btn btn-success btn-block font-weight-bold shadow rounded-pill py-2 mb-2 w-100" type="submit"><i class="fas fa-sign-in-alt"></i> Đăng nhập</button>
                        <div class="mt-3 text-center">
                            <span>Bạn chưa có tài khoản?</span> <a href="/webbanhang4/account/register" class="text-warning fw-bold">Đăng ký</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>