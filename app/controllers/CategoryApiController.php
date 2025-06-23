<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
class CategoryApiController
{
    private $categoryModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }
    // Lấy danh sách danh mục
    public function index()
    {
        header('Content-Type: application/json');
        $categories = $this->categoryModel->getCategories();
        echo json_encode($categories);
    }

    // Lấy chi tiết danh mục theo ID
    public function show($id)
    {
        header('Content-Type: application/json');
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Category not found']);
        }
    }

    // Thêm mới danh mục
    public function store()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['name']) || !isset($data['description'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid input']);
            return;
        }
        $result = $this->categoryModel->addCategory($data['name'], $data['description']);
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'Category created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create category']);
        }
    }

    // Cập nhật danh mục
    public function update($id)
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['name']) || !isset($data['description'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid input']);
            return;
        }
        $result = $this->categoryModel->updateCategory($id, $data['name'], $data['description']);
        if ($result) {
            echo json_encode(['message' => 'Category updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update category']);
        }
    }

    // Xóa danh mục
    public function destroy($id)
    {
        header('Content-Type: application/json');
        $result = $this->categoryModel->deleteCategory($id);
        if ($result) {
            echo json_encode(['message' => 'Category deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete category']);
        }
    }
}
?>