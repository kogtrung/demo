<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .edit-product-container {
        max-width: 600px;
        margin: 40px auto;
    }
    .card-edit-product {
        border-radius: 1.5rem;
        box-shadow: 0 8px 40px rgba(40,167,69,0.13);
        background: #fff;
        padding: 2.5rem 2rem;
        border: none;
    }
    .edit-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 1.5rem;
        text-align: center;
        letter-spacing: 1px;
    }
    .form-label {
        font-weight: 600;
        color: #218838;
        margin-bottom: 0.5rem;
    }
    .form-control {
        border-radius: 2rem;
        min-height: 48px;
        font-size: 1.1rem;
        box-shadow: 0 2px 8px rgba(40,167,69,0.04);
        margin-bottom: 1.2rem;
        transition: box-shadow 0.2s;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem #28a74533;
        border-color: #28a745;
    }
    .btn-primary {
        background: linear-gradient(90deg, #28a745 60%, #43e97b 100%);
        border: none;
        border-radius: 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 0.7rem 2.5rem;
        box-shadow: 0 2px 12px rgba(40,167,69,0.12);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
        box-shadow: 0 4px 24px rgba(40,167,69,0.18);
    }
    .btn-secondary {
        border-radius: 2rem;
        font-size: 1.1rem;
        padding: 0.7rem 2.5rem;
        margin-top: 1rem;
    }
    .img-preview {
        max-width: 120px;
        max-height: 120px;
        border-radius: 8px;
        margin-top: 0.5rem;
        box-shadow: 0 2px 8px #0001;
    }
    @media (max-width: 700px) {
        .edit-product-container { padding: 0 0.5rem; }
        .card-edit-product { padding: 1.2rem 0.5rem; }
    }
</style>
<div class="edit-product-container">
    <div class="card card-edit-product">
        <div class="edit-title"><i class="bi bi-pencil-square me-2"></i>Sửa sản phẩm</div>
        <form id="edit-product-form" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <div class="form-group">
                <label for="name" class="form-label"><i class="bi bi-tag"></i> Tên sản phẩm:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description" class="form-label"><i class="bi bi-card-text"></i> Mô tả:</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="price" class="form-label"><i class="bi bi-cash-coin"></i> Giá:</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="category_id" class="form-label"><i class="bi bi-diagram-3"></i> Danh mục:</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <!-- Các danh mục sẽ được tải từ API và hiển thị tại đây -->
                </select>
            </div>
            <?php if (SessionHelper::isAdmin()): ?>
            <div class="form-group">
                <label for="quantity" class="form-label"><i class="bi bi-stack"></i> Số lượng tồn kho:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" min="0" required>
            </div>
            <?php else: ?>
            <div class="form-group">
                <label for="quantity" class="form-label"><i class="bi bi-stack"></i> Số lượng tồn kho:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" min="0" readonly>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="image" class="form-label"><i class="bi bi-image"></i> Hình ảnh sản phẩm:</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <img id="img-preview" class="img-preview d-block" style="display:none;" />
                <div id="current-image" class="mt-2"></div>
                <input type="hidden" id="existing_image" name="existing_image">
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary me-3 shadow"><i class="bi bi-save2 me-1"></i> Lưu thay đổi</button>
                <a href="/webbanhang4/Product/list" class="btn btn-secondary shadow"><i class="bi bi-arrow-left-circle me-1"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Lấy productId từ URL
    const match = window.location.pathname.match(/edit\/(\d+)/);
    const productId = match ? match[1] : null;
    if (!productId) return;

    // Load danh mục trước
    fetch('/webbanhang4/CategoryApi/index')
        .then(response => response.json())
        .then(categories => {
            const categorySelect = document.getElementById('category_id');
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });

            // Sau khi load danh mục, load sản phẩm
            return fetch(`/webbanhang4/ProductApi/show/${productId}`);
        })
        .then(response => response.json())
        .then(product => {
            document.getElementById('id').value = product.id;
            document.getElementById('name').value = product.name;
            document.getElementById('description').value = product.description;
            document.getElementById('price').value = product.price;
            document.getElementById('category_id').value = product.category_id;
            document.getElementById('quantity').value = product.quantity;
            document.getElementById('existing_image').value = product.image || '';
            if (product.image) {
                document.getElementById('current-image').innerHTML = `<img src="/uploads/${product.image}" alt="Ảnh hiện tại" style="max-width:120px;max-height:120px;border-radius:8px;">`;
            } else {
                document.getElementById('current-image').innerHTML = '<span class="text-muted">Chưa có ảnh</span>';
            }
        });

    document.getElementById('edit-product-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        fetch(`/webbanhang4/ProductApi/update/${productId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product updated successfully') {
                location.href = '/webbanhang4/Product/list';
            } else {
                alert('Cập nhật sản phẩm thất bại');
            }
        });
    });

    document.getElementById('image').addEventListener('change', function(e) {
        const [file] = e.target.files;
        const preview = document.getElementById('img-preview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
});
</script>