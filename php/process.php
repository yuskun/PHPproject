<?php 
 include "./ConnectDB.php";

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'];
    $account = $_POST['account'];
    $password = $_POST['password'];

    if ($action == 'register') {
        $email = $_POST['email'];
        $confirm_password = $_POST['confirm-password'];

        // 確認密碼是否一致
        if ($password != $confirm_password) {
            echo "密碼不一致";
            exit;
        }

        // 檢查帳戶是否已存在
        $check_sql = "SELECT * FROM users WHERE account='$account'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo "帳戶已存在";
            exit;
        }

        // 插入新用戶
        $password_hashed = password_hash($password, PASSWORD_DEFAULT); // 密碼加密
        $sql = "INSERT INTO users (account, password, email) VALUES ('$account', '$password_hashed', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "註冊成功";
        } else {
            echo "註冊失敗: " . $conn->error;
        }
    } elseif ($action == 'login') {
        // 驗證用戶
        $sql = "SELECT * FROM users WHERE account='$account'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                echo "登入成功";
            } else {
                echo "密碼錯誤";
            }
        } else {
            echo "帳戶不存在";
        }
    }
}

$conn->close();
?>