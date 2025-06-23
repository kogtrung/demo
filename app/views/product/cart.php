<?php include 'app/views/shares/header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-success text-white text-center rounded-top-4">
                    <h2 class="mb-0"><i class="fas fa-shopping-cart"></i> Giỏ hàng</h2>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['cart_error'])): ?>
                        <div class="alert alert-danger text-center fw-bold">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo $_SESSION['cart_error']; unset($_SESSION['cart_error']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($cart)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle bg-white shadow-sm rounded-4 overflow-hidden">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th style="width:60px;">#</th>
                                        <th style="width:120px;">Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($cart as $id => $item): ?>
                                        <tr>
                                            <td class="fw-bold text-center"><?php echo $i++; ?></td>
                                            <td class="text-center">
                                                <?php if ($item['image']): ?>
                                                    <img src="/webbanhang4/<?php echo $item['image']; ?>" alt="Product Image" style="max-width: 80px; border-radius:8px; border:1px solid #27ae60;">
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-success fw-semibold"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="text-danger fw-bold"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <a href="/webbanhang4/Product/decreaseCartQuantity/<?php echo $id; ?>" class="btn btn-sm btn-danger rounded-circle"><i class="fas fa-minus"></i></a>
                                                    <span class="mx-2 fw-bold" style="min-width:32px;display:inline-block;text-align:center;">
                                                        <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </span>
                                                    <a href="/webbanhang4/Product/increaseCartQuantity/<?php echo $id; ?>" class="btn btn-sm btn-success rounded-circle"><i class="fas fa-plus"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">Giỏ hàng của bạn đang trống.</div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between mt-4 gap-2">
                        <a href="/webbanhang4/Product" class="btn btn-secondary btn-action rounded-pill"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a>
                        <a href="/webbanhang4/Product/checkout" class="btn btn-success btn-action rounded-pill"><i class="fas fa-credit-card"></i> Thanh Toán</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>