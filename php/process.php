<?php
session_start(); 

include "ConnectDB.php";

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $action = $_GET['action']; // 狀態: 登入或註冊或刪除通知
    $account = isset($_POST['account']) ? $_POST['account'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($action == 'register') {
        $email = $_POST['email'];
        $confirm_password = $_POST['confirm-password'];

        // 確認密碼
        if ($password != $confirm_password) {
            echo "<script>alert('密碼不一致'); window.location.href='../View/Login.php';</script>";
            exit;
        }

        // 檢查帳戶
        $check_sql = "SELECT * FROM Users WHERE account=?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param('s', $account);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('帳戶已存在'); window.location.href='../View/Login.php';</script>";
            exit;
        }

        // 插入新用戶
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Users (account, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $account, $password_hashed, $email);

        if ($stmt->execute() === TRUE) {
            // 獲取剛插入的用戶ID
            $user_id = $stmt->insert_id;

            // 插入 NotificationSettings 
            $notification_sql = "INSERT INTO NotificationSettings (user_id) VALUES (?)";
            $notification_stmt = $conn->prepare($notification_sql);
            $notification_stmt->bind_param('i', $user_id);
            $notification_stmt->execute();

           
            $privacy_sql = "INSERT INTO PrivacySettings (user_id) VALUES (?)";
            $privacy_stmt = $conn->prepare($privacy_sql);
            $privacy_stmt->bind_param('i', $user_id);
            $privacy_stmt->execute();

            echo "<script>alert('註冊成功'); window.location.href='../View/Login.php';</script>";
        } else {
            echo "<script>alert('註冊失敗: " . $stmt->error . "'); window.location.href='../View/Login.php';</script>";
        }
    } elseif ($action == 'login') {
        $sql = "SELECT * FROM Users WHERE account=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $account);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // 登錄成功
                $_SESSION['user_id'] = $row['id'];

                echo "<script>window.location.href='../View/Course_Search.php';</script>";
                exit();
            } else {
                echo "<script>alert('密碼錯誤'); window.location.href='../View/Login.php';</script>";
            }
        } else {
            echo "<script>alert('帳戶不存在'); window.location.href='../View/Login.php';</script>";
        }
    } elseif ($action == 'delete_notification') {
        if (!isset($_POST['notification_id'])) {
            echo "缺少通知ID。";
            exit;
        }

        $notification_id = $_POST['notification_id'];

       
        error_log("notification_id: " . $notification_id);

        // 確認通知存在
        $check_sql = "SELECT * FROM notifications WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $notification_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        // 刪除通知
        $sql = "DELETE FROM notifications WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $notification_id);
            if ($stmt->affected_rows > 0) {
                echo "通知已刪除。";
            } else {
                echo "通知刪除失敗或通知不存在。";
            }
        $stmt->close();
}
}
$conn->close();
?>
