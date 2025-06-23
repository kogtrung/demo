<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .add-product-container {
        max-width: 600px;
        margin: 40px auto;
    }
    .card-add-product {
        border-radius: 1.5rem;
        box-shadow: 0 8px 40px rgba(40,167,69,0.13);
        background: #fff;
        padding: 2.5rem 2rem;
        border: none;
    }
    .add-title {
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
        .add-product-container { padding: 0 0.5rem; }
        .card-add-product { padding: 1.2rem 0.5rem; }
    }
</style>
<div class="add-product-container">
    <div class="card card-add-product">
        <div class="add-title"><i class="bi bi-plus-circle me-2"></i>Thêm sản phẩm mới</div>
        <form id="add-product-form" enctype="multipart/form-data">
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
                <label for="quantity" class="form-label"><i class="bi bi-stack"></i> Số lượng tồn kho:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" min="0" required>
            </div>
            <div class="form-group">
                <label for="category_id" class="form-label"><i class="bi bi-diagram-3"></i> Danh mục:</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <!-- Các danh mục sẽ được tải từ API và hiển thị tại đây -->
                </select>
            </div>
            <div class="form-group">
                <label for="image" class="form-label"><i class="bi bi-image"></i> Hình ảnh sản phẩm:</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <img id="img-preview" class="img-preview d-block" style="display:none;" />
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary me-3 shadow"><i class="bi bi-plus-circle me-1"></i> Thêm sản phẩm</button>
                <a href="/webbanhang4/Product/list" class="btn btn-secondary shadow"><i class="bi bi-arrow-left-circle me-1"></i> Quay lại</a>
            </div>
        </form>
        <div id="add-message" class="mt-3"></div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
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
        });
    document.getElementById('add-product-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        fetch('/webbanhang4/ProductApi/store', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const msg = document.getElementById('add-message');
            if (data.message === 'Product created successfully') {
                msg.innerHTML = '<div class="alert alert-success">Thêm sản phẩm thành công!</div>';
                setTimeout(() => { window.location.href = '/webbanhang4/Product/list'; }, 1000);
            } else {
                msg.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Thêm sản phẩm thất bại!') + '</div>';
            }
        })
        .catch(() => {
            document.getElementById('add-message').innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra!</div>';
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