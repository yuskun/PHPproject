<?php
session_start(); // 啟動會話

include "../php/ConnectDB.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 確保用戶已登錄並設置了會話變量
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('未登錄'); window.location.href='../View/Login.php';</script>";
        exit();
    }

    $userId = $_SESSION['user_id'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $promotional_emails = isset($_POST['promotional_emails']) ? 1 : 0;
    $show_courses = isset($_POST['show_courses']) ? 1 : 0;
    $show_email = isset($_POST['show_email']) ? 1 : 0;

    // 檢查電子郵件是否已經存在於其他用戶
    $check_email_sql = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bind_param('si', $email, $userId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // 電子郵件已經存在於其他用戶
        echo "<script>alert('該電子郵件地址已被其他用戶使用'); window.location.href='../View/personal.php';</script>";
        $stmt->close();
        $conn->close();
        exit();
    }

    $stmt->close();

    // 更新個人資訊
    $update_user_sql = "UPDATE users SET lastname=?, firstname=?, email=?, phone=?, address=? WHERE id=?";
    $stmt = $conn->prepare($update_user_sql);
    $stmt->bind_param('sssssi', $lastname, $firstname, $email, $phone, $address, $userId);
    $stmt->execute();

    // 更新通知設定
    $update_notification_sql = "UPDATE NotificationSettings SET email_notifications=?, promotional_emails=? WHERE user_id=?";
    $stmt = $conn->prepare($update_notification_sql);
    $stmt->bind_param('iii', $email_notifications, $promotional_emails, $userId);
    $stmt->execute();

    // 更新隱私設定
    $update_privacy_sql = "UPDATE PrivacySettings SET show_courses=?, show_email=? WHERE user_id=?";
    $stmt = $conn->prepare($update_privacy_sql);
    $stmt->bind_param('iii', $show_courses, $show_email, $userId);
    $stmt->execute();

    // 更新大頭貼
    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = $_FILES['profile_picture'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($profile_picture["name"]);
        move_uploaded_file($profile_picture["tmp_name"], $target_file);

        $update_avatar_sql = "UPDATE users SET profile_picture=? WHERE id=?";
        $stmt = $conn->prepare($update_avatar_sql);
        $stmt->bind_param('si', $target_file, $userId);
        $stmt->execute();
    }

    // 完成後重定向或顯示成功訊息
    echo "<script>alert('更新成功！'); window.location.href='../View/personal.php';</script>";
    exit();
}

$conn->close();
?>
