<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .product-detail-container {
        max-width: 800px;
        margin: 40px auto;
    }
    .card-product-detail {
        border-radius: 1.5rem;
        box-shadow: 0 8px 40px rgba(40,167,69,0.13);
        background: #fff;
        border: none;
        padding: 2.5rem 2rem;
    }
    .product-img-detail {
        max-width: 320px;
        max-height: 320px;
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px #0001;
        background: #f8f9fa;
        margin-bottom: 1.5rem;
    }
    .product-title-detail {
        font-size: 2rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 1rem;
    }
    .product-price-detail {
        color: #e67e22;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .product-category-detail {
        font-size: 1.1rem;
        color: #218838;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .badge-detail {
        background: #17a2b8;
        color: #fff;
        font-size: 1rem;
        border-radius: 1rem;
        padding: 0.4rem 1.2rem;
        margin-left: 0.5rem;
    }
    .btn-gradient {
        background: linear-gradient(90deg, #28a745 60%, #43e97b 100%);
        color: #fff;
        border: none;
        border-radius: 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 0.7rem 2.5rem;
        margin-right: 1rem;
        box-shadow: 0 2px 12px rgba(40,167,69,0.12);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-gradient:hover {
        background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
        color: #fff;
        box-shadow: 0 4px 24px rgba(40,167,69,0.18);
    }
    .btn-back {
        border-radius: 2rem;
        font-size: 1.1rem;
        padding: 0.7rem 2.5rem;
        margin-top: 1rem;
    }
    @media (max-width: 900px) {
        .product-detail-container { padding: 0 0.5rem; }
        .card-product-detail { padding: 1.2rem 0.5rem; }
    }
</style>
<div class="product-detail-container">
    <div class="card card-product-detail">
        <?php if ($product): ?>
        <div class="text-center mb-4">
            <img src="<?php echo $product->image ? '/webbanhang4/' . htmlspecialchars($product->image) : 'https://via.placeholder.com/320x320?text=No+Image'; ?>" class="product-img-detail" alt="<?php echo htmlspecialchars($product->name); ?>">
        </div>
        <div class="product-title-detail mb-2"><i class="bi bi-box-seam me-2"></i><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></div>
        <div class="product-price-detail mb-2"><i class="bi bi-cash-coin me-1"></i><?php echo number_format($product->price, 0, ',', '.'); ?> VND</div>
        <div class="product-category-detail mb-2">
            <i class="bi bi-diagram-3"></i> Danh mục:
            <span class="badge-detail">
                <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục'; ?>
            </span>
        </div>
        <div class="mb-3">
            <span class="fw-bold">Mô tả:</span><br>
            <span><?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?></span>
        </div>
        <div class="mt-4 d-flex flex-wrap gap-2">
            <a href="/webbanhang4/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-gradient"><i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng</a>
            <a href="/webbanhang4/Product/list" class="btn btn-secondary btn-back"><i class="bi bi-arrow-left"></i> Quay lại danh sách</a>
        </div>
        <?php else: ?>
        <div class="alert alert-danger text-center">
            <h4>Không tìm thấy sản phẩm!</h4>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>