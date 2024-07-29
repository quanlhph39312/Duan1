<?php
session_start();

function logout(){
    try {
        $conn = pdo_get_connection();
        // Cập nhật trạng thái trong cơ sở dữ liệu
        $user_id_to_update = $_SESSION['user_id']; // Điều chỉnh theo cách bạn lấy ID người dùng
        $new_status = 'locked';
    
        $sql = "UPDATE user SET status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $new_status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id_to_update, PDO::PARAM_INT);
        $stmt->execute();
    
        // Hủy bỏ phiên đăng nhập
        session_destroy();
    
        // Chuyển hướng đến trang đăng nhập
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

?>
