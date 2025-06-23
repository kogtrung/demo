<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .category-list-container {
        max-width: 900px;
        margin: 40px auto;
    }
    .card-category-list {
        border-radius: 1.5rem;
        box-shadow: 0 8px 40px rgba(40,167,69,0.13);
        background: #fff;
        border: none;
        padding: 2.5rem 2rem;
    }
    .category-title {
        font-size: 2rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 1.5rem;
        text-align: center;
        letter-spacing: 1px;
    }
    .table-category {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 12px #0001;
        background: #fff;
    }
    .table-category th {
        background: linear-gradient(90deg, #28a745 60%, #43e97b 100%);
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        border: none;
    }
    .table-category td {
        vertical-align: middle;
        font-size: 1.05rem;
        border-top: 1px solid #e9ecef;
    }
    .btn-action {
        border-radius: 2rem;
        font-size: 1rem;
        padding: 0.4rem 1.2rem;
        margin: 0 0.2rem;
        box-shadow: 0 2px 8px rgba(40,167,69,0.08);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-action.btn-warning {
        color: #fff;
        background: #ffc107;
        border: none;
    }
    .btn-action.btn-warning:hover {
        background: #ffb300;
    }
    .btn-action.btn-danger {
        color: #fff;
        background: #dc3545;
        border: none;
    }
    .btn-action.btn-danger:hover {
        background: #b71c1c;
    }
    .btn-add-category {
        background: linear-gradient(90deg, #28a745 60%, #43e97b 100%);
        color: #fff;
        border: none;
        border-radius: 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 0.7rem 2.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 12px rgba(40,167,69,0.12);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-add-category:hover {
        background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
        color: #fff;
        box-shadow: 0 4px 24px rgba(40,167,69,0.18);
    }
    @media (max-width: 700px) {
        .category-list-container { padding: 0 0.5rem; }
        .card-category-list { padding: 1.2rem 0.5rem; }
    }
</style>
<div class="category-list-container">
    <div class="card card-category-list">
        <div class="category-title mb-4"><i class="bi bi-list-ul me-2"></i>Quản lý danh mục</div>
        <div class="d-flex justify-content-end mb-3">
            <a href="/webbanhang4/Category/add" class="btn btn-add-category shadow"><i class="bi bi-plus-circle me-1"></i> Thêm danh mục mới</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle table-category">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 220px;">Tên danh mục</th>
                        <th>Mô tả</th>
                        <th style="width: 180px;">Hành động</th>
                    </tr>
                </thead>
                <tbody id="category-table-body">
                    <!-- Dữ liệu sẽ được render bằng JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function renderCategories(categories) {
    const tbody = document.getElementById('category-table-body');
    tbody.innerHTML = '';
    categories.forEach(category => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="fw-bold text-center">${category.id}</td>
            <td class="text-primary fw-semibold">${category.name}</td>
            <td>${category.description}</td>
            <td class="text-center">
                <a href="/webbanhang4/Category/edit/${category.id}" class="btn btn-warning btn-sm btn-action me-1 shadow"><i class="bi bi-pencil-square"></i> Sửa</a>
                <button class="btn btn-danger btn-sm btn-action shadow" onclick="deleteCategory(${category.id})"><i class="bi bi-trash"></i> Xóa</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}
function fetchCategories() {
    fetch('/webbanhang4/CategoryApi/index')
        .then(res => res.json())
        .then(data => renderCategories(data));
}
function deleteCategory(id) {
    if (confirm('Bạn có chắc chắn muốn xóa?')) {
        fetch(`/webbanhang4/CategoryApi/destroy/${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                fetchCategories();
            });
    }
}
document.addEventListener('DOMContentLoaded', fetchCategories);
</script>
<?php include 'app/views/shares/footer.php'; ?> 