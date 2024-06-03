<?php
$servername = "localhost";
$username = "root"; // 使用你在phpMyAdmin中創建的用戶名
$password = ""; // 使用你在phpMyAdmin中創建的密碼
$dbname = "edsustain"; // 你的資料庫名稱

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
?>