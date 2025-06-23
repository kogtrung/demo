<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .form-icon { color: #28a745; font-size: 2rem; margin-right: 10px; vertical-align: middle; }
    .card-add { border-radius: 1rem; box-shadow: 0 4px 24px rgba(40,167,69,0.08); }
</style>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card card-add p-4">
                <h2 class="mb-4 text-center">
                    <i class="bi bi-plus-circle form-icon"></i>Thêm danh mục mới
                </h2>
                <form id="add-category-form" autocomplete="off">
                    <div class="form-group mb-3">
                        <label for="name" class="fw-bold"><i class="bi bi-tag"></i> Tên danh mục:</label>
                        <input type="text" id="name" name="name" class="form-control rounded-pill" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="description" class="fw-bold"><i class="bi bi-card-text"></i> Mô tả:</label>
                        <textarea id="description" name="description" class="form-control rounded" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success px-4 rounded-pill shadow">
                            <i class="bi bi-check-circle me-1"></i> Thêm
                        </button>
                        <a href="/webbanhang4/Category/list" class="btn btn-secondary px-4 rounded-pill shadow">
                            <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
                        </a>
                    </div>
                </form>
                <div id="add-message" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('add-category-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    fetch('/webbanhang4/CategoryApi/store', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, description })
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('add-message');
        if (data.message && data.message.includes('successfully')) {
            msg.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
            setTimeout(() => { window.location.href = '/webbanhang4/Category/list'; }, 1000);
        } else {
            msg.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Có lỗi xảy ra!') + '</div>';
        }
    })
    .catch(() => {
        document.getElementById('add-message').innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra!</div>';
    });
});
</script>
<?php include 'app/views/shares/footer.php'; ?> 