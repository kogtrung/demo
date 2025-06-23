<?php include 'app/views/shares/header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center rounded-top-4">
                    <h2 class="mb-0"><i class="fas fa-credit-card"></i> Thanh toán</h2>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="/webbanhang4/Product/processCheckout">
                        <div class="mb-4">
                            <label for="name" class="form-label text-success fw-bold"><i class="fas fa-user"></i> Họ tên</label>
                            <input type="text" id="name" name="name" class="form-control rounded-pill" required>
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="form-label text-success fw-bold"><i class="fas fa-phone"></i> Số điện thoại</label>
                            <input type="text" id="phone" name="phone" class="form-control rounded-pill" required>
                        </div>
                        <div class="mb-4">
                            <label for="address" class="form-label text-success fw-bold"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                            <textarea id="address" name="address" class="form-control rounded-4" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label text-success fw-bold"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" id="email" name="email" class="form-control rounded-pill" required placeholder="Nhập địa chỉ email">
                        </div>
                        <button type="submit" class="btn btn-success btn-block font-weight-bold shadow rounded-pill py-2 mb-2 w-100"><i class="fas fa-credit-card"></i> Thanh toán</button>
                        <a href="/webbanhang4/Product/cart" class="btn btn-secondary mt-3 d-block mx-auto rounded-pill" style="max-width:220px;"><i class="fas fa-arrow-left"></i> Quay lại giỏ hàng</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>