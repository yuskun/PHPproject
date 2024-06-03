<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('請先登錄'); window.location.href='../html/login.html';</script>";
    exit();
}

include "../php/ConnectDB.php";

$userId = $_SESSION['user_id'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];


if ($newPassword !== $confirmPassword) {
    echo "<script>alert('新密碼與確認密碼不匹配'); window.location.href='../html/personal.html';</script>";
    exit();
}


$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);


$sql = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $hashedPassword, $userId);

if ($stmt->execute()) {
    echo "<script>alert('密碼重設成功'); window.location.href='../php/personal.php';</script>";
} else {
    echo "<script>alert('密碼重設失敗，請稍後再試'); window.location.href='../php/personal.php';</script>";
}

$stmt->close();
$conn->close();
?>
