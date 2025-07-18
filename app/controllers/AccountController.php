<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
class AccountController
{
    private $accountModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }
    public function register()
    {
        include_once 'app/views/account/register.php';
    }
    public function login()
    {
        include_once 'app/views/account/login.php';
    }
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $errors = [];
            if (empty($username))
                $errors['username'] = "Vui lòng nhập username!";
            if (empty($fullName))
                $errors['fullname'] = "Vui lòng nhập fullname!";
            if (empty($password))
                $errors['password'] = "Vui lòng nhập password!";
            if ($password != $confirmPassword)
                $errors['confirmPass'] = "Mật khẩu và 
xác nhận chưa khớp!";
            if (!in_array($role, ['admin', 'user']))
                $role = 'user';
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }
            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $result = $this->accountModel->save(
                    $username,
                    $fullName,
                    $password,
                    $role
                );
                if ($result) {
                    header('Location: /webbanhang4/account/login');
                    exit;
                }
            }
        }
    }
    public function logout()
    {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /webbanhang4/product');
        exit;
    }
    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account && password_verify($password, $account->password)) {
                session_start();
                if (!isset($_SESSION['username'])) {
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role;
                }
                header('Location: /webbanhang4/product');
                exit;
            } else {
                $error = $account ? "Mật khẩu không đúng!" : "Không tìm thấy tài 
khoản!";
                include_once 'app/views/account/login.php';
                exit;
            }
        }
    }
    public function forgotPassword()
    {
        include_once 'app/views/account/forgot_password.php';
    }
    public function processForgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $account = $this->accountModel->getAccountByUsername($username);
            if (!$account) {
                $error = "Không tìm thấy tài khoản với username này!";
                include_once 'app/views/account/forgot_password.php';
                return;
            }
            // Nếu đã nhập mật khẩu mới
            if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];
                if (strlen($newPassword) < 6) {
                    $error = "Mật khẩu phải có ít nhất 6 ký tự.";
                    $showPasswordFields = true;
                    include_once 'app/views/account/forgot_password.php';
                    return;
                }
                if ($newPassword !== $confirmPassword) {
                    $error = "Mật khẩu xác nhận không khớp.";
                    $showPasswordFields = true;
                    include_once 'app/views/account/forgot_password.php';
                    return;
                }
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $query = "UPDATE account SET password = :password WHERE username = :username";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $success = "Mật khẩu đã được đặt lại thành công! Bạn có thể đăng nhập với mật khẩu mới.";
                include_once 'app/views/account/forgot_password.php';
                return;
            } else {
                // Hiển thị form nhập mật khẩu mới
                $showPasswordFields = true;
                include_once 'app/views/account/forgot_password.php';
                return;
            }
        }
    }
}
?>