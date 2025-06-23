<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="/webbanhang4/public/css/custom.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow rounded-pill px-4 my-3">
        <a class="navbar-brand font-weight-bold d-flex align-items-center" href="/webbanhang4/Product/">
            <span class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:40px;height:40px;"><i class="fas fa-store text-success fa-lg"></i></span>
            <span class="ms-2" style="font-size:1.5rem;letter-spacing:2px;">ALO shop</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center w-100 justify-content-end">
                <li class="nav-item mx-2">
                    <a class="nav-link fw-bold" href="/webbanhang4/Product/">Sản phẩm</a>
                </li>
                <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-bold" href="/webbanhang4/Product/add">Thêm sản phẩm</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-bold" href="/webbanhang4/Category/list">Danh mục</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item mx-2">
                    <a class="nav-link position-relative fw-bold" href="/webbanhang4/Product/cart">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                        <?php
                        $cartCount = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                $cartCount += $item['quantity'];
                            }
                        }
                        if ($cartCount > 0): ?>
                            <span class="badge badge-danger position-absolute" style="top:-8px; right:-12px; font-size:0.8rem; min-width:22px;"> <?php echo $cartCount; ?> </span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <?php
                    if (SessionHelper::isLoggedIn()) {
                        echo "<span class='nav-link fw-bold text-success'>" . htmlspecialchars($_SESSION['username']) . " (" . SessionHelper::getRole() . ")</span>";
                    } else {
                        echo "<a class='btn btn-outline-success rounded-pill px-4 fw-bold' href='/webbanhang4/account/login'>Đăng nhập</a>";
                    }
                    ?>
                </li>
                <li class="nav-item mx-2">
                    <?php
                    if (SessionHelper::isLoggedIn()) {
                        echo "<a class='btn btn-danger rounded-pill px-4 fw-bold' href='/webbanhang4/account/logout'>Đăng xuất</a>";
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>