<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once __DIR__ . '/../helpers/SessionHelper.php';
class ProductApiController
{
    private $productModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    // Lấy danh sách sản phẩm
    public function index()
    {
        header('Content-Type: application/json');
        $products = $this->productModel->getProducts();
        echo json_encode($products);
    }
    // Lấy thông tin sản phẩm theo ID
    public function show($id)
    {
        header('Content-Type: application/json');
        $product = $this->productModel->getProductById($id);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }
    // Thêm sản phẩm mới
    public function store()
    {
        header('Content-Type: application/json');
        // Hỗ trợ cả JSON và multipart/form-data
        if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false) {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 0;
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = 'uploads/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
                $image = uniqid('img_') . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $image);
                $image = 'uploads/' . $image;
            }
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $quantity, $image);
            if (is_array($result)) {
                http_response_code(400);
                echo json_encode(['errors' => $result]);
            } else {
                http_response_code(201);
                echo json_encode(['message' => 'Product created successfully']);
            }
            return;
        }
        // JSON truyền thống
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $category_id = $data['category_id'] ?? null;
        $quantity = $data['quantity'] ?? 0;
        $image = $data['image'] ?? '';
        // Nếu image chỉ là tên file (không có uploads/), thêm vào
        if (!empty($image) && strpos($image, 'uploads/') !== 0) {
            $image = 'uploads/' . $image;
        }
        $result = $this->productModel->addProduct($name, $description, $price, $category_id, $quantity, $image);
        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        }
    }
    // Cập nhật sản phẩm theo ID
    public function update($id)
    {
        header('Content-Type: application/json');
        if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false) {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 0;
            $image = $_POST['existing_image'] ?? '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = 'uploads/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
                // Xóa ảnh cũ nếu có
                if (!empty($image) && file_exists($targetDir . $image)) {
                    unlink($targetDir . $image);
                }
                $image = uniqid('img_') . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $image);
                $image = 'uploads/' . $image;
            }
            $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $quantity, $image);
            if ($result) {
                echo json_encode(['message' => 'Product updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Product update failed']);
            }
            return;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $category_id = $data['category_id'] ?? null;
        $quantity = $data['quantity'] ?? 0;
        $image = $data['image'] ?? '';
        // Nếu image chỉ là tên file (không có uploads/), thêm vào
        if (!empty($image) && strpos($image, 'uploads/') !== 0) {
            $image = 'uploads/' . $image;
        }
        $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $quantity, $image);
        if ($result) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product update failed']);
        }
    }
    // Xóa sản phẩm theo ID
    public function destroy($id)
    {
        header('Content-Type: application/json');
        $result = $this->productModel->deleteProduct($id);
        if ($result) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product deletion failed']);
        }
    }
    
}
?>