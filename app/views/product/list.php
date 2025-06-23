<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .product-list-container {
        max-width: 1200px;
        margin: 40px auto;
    }

    .product-card-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: flex-start;
    }

    .product-card-col {
        flex: 1 1 260px;
        max-width: 23%;
        min-width: 260px;
        display: flex;
    }

    @media (max-width: 1100px) {
        .product-card-col {
            max-width: 31%;
        }
    }

    @media (max-width: 900px) {
        .product-card-col {
            max-width: 48%;
        }
    }

    @media (max-width: 600px) {
        .product-card-col {
            max-width: 100%;
            min-width: 0;
        }
    }

    .card-product {
        border-radius: 1.2rem;
        box-shadow: 0 6px 32px rgba(40, 167, 69, 0.10);
        background: #fff;
        border: none;
        margin: 0;
        display: flex;
        flex-direction: column;
        width: 100%;
        min-height: 100%;
        transition: transform 0.15s, box-shadow 0.15s;
    }

    .card-product:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 12px 36px rgba(40, 167, 69, 0.18);
    }

    .card-product .card-title {
        color: #28a745;
        font-weight: 700;
        font-size: 1.3rem;
    }

    .card-product .card-text {
        color: #444;
        font-size: 1.05rem;
    }

    .card-product .product-price {
        color: #e67e22;
        font-weight: 600;
        font-size: 1.15rem;
    }

    .card-product .product-category {
        color: #218838;
        font-size: 1rem;
        font-weight: 500;
    }

    .card-product .btn-action {
        border-radius: 2rem;
        font-size: 1rem;
        padding: 0.4rem 1.2rem;
        margin: 0 0.2rem;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.08);
        transition: background 0.2s, box-shadow 0.2s;
    }

    .card-product .btn-action.btn-warning {
        color: #fff;
        background: #ffc107;
        border: none;
    }

    .card-product .btn-action.btn-warning:hover {
        background: #ffb300;
    }

    .card-product .btn-action.btn-danger {
        color: #fff;
        background: #dc3545;
        border: none;
    }

    .card-product .btn-action.btn-danger:hover {
        background: #b71c1c;
    }

    .product-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 1.2rem 1.2rem 0 0;
        background: #f8f9fa;
    }

    .card-product .card-body {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        padding-bottom: 0.5rem;
    }

    .card-product .card-actions {
        margin-top: auto;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        padding-bottom: 1rem;
    }
</style>
<div class="product-list-container">
    <h1 class="text-center mb-4" style="color:#28a745;font-weight:700;"><i class="bi bi-box-seam me-2"></i>Danh sách sản
        phẩm</h1>
    
    <div class="product-card-grid" id="product-card-list">
        <!-- Card sản phẩm sẽ được render bằng JS -->
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('/webbanhang4/ProductApi/index')
            .then(response => response.json())
            .then(data => {
                const cardList = document.getElementById('product-card-list');
                cardList.innerHTML = '';
                if (!data.length) {
                    cardList.innerHTML = '<div class="text-center text-muted">Không có sản phẩm nào.</div>';
                    return;
                }
                data.forEach(product => {
                    const col = document.createElement('div');
                    col.className = 'product-card-col';
                    col.innerHTML = `
                    <div class=\"card card-product w-100 d-flex flex-column h-100\">
                        <img src=\"${product.image ? '/webbanhang4/' + product.image : 'https://via.placeholder.com/300x180?text=No+Image'}\" class=\"product-img\" alt=\"${product.name}\">
                        <div class=\"card-body flex-grow-1 d-flex flex-column\">
                            <h5 class=\"card-title mb-2\">${product.name}</h5>
                            <div class=\"card-text mb-2\">${product.description}</div>
                            <div class=\"product-price mb-2\"><i class=\"bi bi-cash-coin me-1\"></i>${product.price} VND</div>
                            <div class=\"product-category mb-3\"><i class=\"bi bi-diagram-3 me-1\"></i>${product.category_name || ''}</div>
                            <?php if (SessionHelper::isAdmin()): ?>
                            <div class=\"mb-2\"><span class=\"badge bg-info text-dark\"><i class=\"bi bi-stack\"></i> Tồn kho: ${product.quantity ?? 0}</span></div>
                            <?php endif; ?>
                            <div class=\"card-actions\">
                                <?php if (SessionHelper::isAdmin()): ?>
                                    <a href=\"/webbanhang4/Product/edit/${product.id}\" class=\"btn btn-warning btn-sm btn-action shadow\"><i class=\"bi bi-pencil-square\"></i> Sửa</a>
                                    <button class=\"btn btn-danger btn-sm btn-action shadow\" onclick=\"deleteProduct(${product.id})\"><i class=\"bi bi-trash\"></i> Xóa</button>
                                <?php endif; ?>
                                <a href="/webbanhang4/Product/addToCart/${product.id}"
                                    class="btn btn-primary btn-sm w-100 fw-bold rounded-pill transition-all hover-btn">
                                    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                    cardList.appendChild(col);
                });
            });
    });
    function deleteProduct(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch(`/webbanhang4/ProductApi/destroy/${id}`, {
                method: 'DELETE'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Product deleted successfully') {
                        location.reload();
                    } else {
                        alert('Xóa sản phẩm thất bại');
                    }
                });
        }
    }
</script>