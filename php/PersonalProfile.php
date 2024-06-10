<?php

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('未登錄'); window.location.href='../html/login.html';</script>";
    exit();
}

include "../php/ConnectDB.php";

$userId = $_SESSION['user_id'];


$sql = "SELECT u.lastname, u.firstname, u.email, u.phone, u.address, u.profile_picture, n.email_notifications, n.promotional_emails, p.show_courses, p.show_email 
        FROM users u 
        LEFT JOIN NotificationSettings n ON u.id = n.user_id 
        LEFT JOIN PrivacySettings p ON u.id = p.user_id 
        WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('未找到用戶資料'); window.location.href='../html/login.html';</script>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人資料</title>
    <link rel="stylesheet" href="../Font/inter.css">
    <link rel="stylesheet" href="../css/personal.css">
    <link rel="stylesheet" href="../css/switchButton.css">

</head>

<body>
    <div class="container">
        <div class="content">
            <form id="user-form" method="post" action="../php/updateUser.php" enctype="multipart/form-data">
                <div class="personal">
                    <div class="title">
                        <div class="list" onclick="closepersonal()">
                            <svg id="person" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.82 16L24 25.16L33.18 16L36 18.82L24 30.82L12 18.82L14.82 16Z" fill="#495920"/>
                            </svg>
                        </div>
                        <div class="text">個人資訊</div>
                    </div>
                    <div class="itemlist" id="personalBOX">
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 姓氏</div>
                            <div class="clue">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="#EC75AA"/>
                                </svg>
                            </div>
                            <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                        </div>
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 名字</div>
                            <div class="clue">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="#EC75AA"/>
                                </svg>
                            </div>
                            <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                        </div>
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 電子郵件信箱</div>
                            <div class="clue">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V9H11V15ZM11 7H9V5H11V7Z" fill="#87AE0B"/>
                                </svg>
                            </div>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 密碼</div>
                            <div class="clue">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 19H11V17H13V19ZM15.07 11.25L14.17 12.17C13.45 12.9 13 13.5 13 15H11V14.5C11 13.4 11.45 12.4 12.17 11.67L13.41 10.41C13.78 10.05 14 9.55 14 9C14 7.9 13.1 7 12 7C10.9 7 10 7.9 10 9H8C8 6.79 9.79 5 12 5C14.21 5 16 6.79 16 9C16 9.88 15.64 10.68 15.07 11.25Z" fill="#495920"/>
                                </svg>
                            </div>
                            <button type="button" onclick="openModal()">重設</button>
                        </div>
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 手機號碼</div>
                            <div class="clue">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="#EC75AA"/>
                                </svg>
                            </div>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                        </div>
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 地址</div>
                            <div class="clue">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="#EC75AA"/>
                                </svg>
                            </div>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                        </div>
                    </div>
                </div>
                <div class="avatar">
                    <img src="<?php echo htmlspecialchars($user['profile_picture'] ?: '../image/web_img.png'); ?>" id="avatarImage" alt="Avatar">
                    <input type="file" id="avatarInput" name="profile_picture"  accept=".jpg,.jpeg" onchange="previewAvatar()">
                    <input type="hidden" id="profile_picture_base64" name="profile_picture_base64" value="<?php echo htmlspecialchars($user['profile_picture']); ?>">
                    <label for="avatarInput">更換大頭貼</label>
                </div>
                <div class="inform">
                    <div class="title">
                        <div class="list" onclick="closeinform()">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.82 16L24 25.16L33.18 16L36 18.82L24 30.82L12 18.82L14.82 16Z" fill="#495920"/>
                            </svg>
                        </div>
                        <div class="text">通知設定</div>
                    </div>
                    <div class="itemlist" id="informBOX">
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 寄送通知信件</div>
                            <div class="clue">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V9H11V15ZM11 7H9V5H11V7Z" fill="#87AE0B"/>
                                </svg>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="email_notifications" <?php echo $user['email_notifications'] ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 寄送推薦信件</div>
                            <div class="clue">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V9H11V15ZM11 7H9V5H11V7Z" fill="#87AE0B"/>
                                </svg>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="promotional_emails" <?php echo $user['promotional_emails'] ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="privacy">
                    <div class="title">
                        <div class="list" onclick="closeprivate()">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.82 16L24 25.16L33.18 16L36 18.82L24 30.82L12 18.82L14.82 16Z" fill="#495920"/>
                            </svg>
                        </div>
                        <div class="text">隱私設定</div>
                    </div>
                    <div class="itemlist" id="privateBOX">
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 顯示課程</div>
                            <div class="clue">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V9H11V15ZM11 7H9V5H11V7Z" fill="#87AE0B"/>
                                </svg>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_courses" <?php echo $user['show_courses'] ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="item">
                            <div class="itemname"> &nbsp;  &nbsp; 顯示電子郵件</div>
                            <div class="clue">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V9H11V15ZM11 7H9V5H11V7Z" fill="#87AE0B"/>
                                </svg>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_email" <?php echo $user['show_email'] ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button class="save" type="submit">儲存</button>
                    <button class="cancel" type="button" onclick="cancelChanges()">取消</button>
                </div>
            </form>
        </div>
    </div>
    <div id="resetPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>重設密碼</h2>
            <form id="reset-password-form" method="post" action="../php/resetPassword.php">
                <div class="item">
                    <label for="newPassword">新密碼</label>
                    <input type="password" id="newPassword" name="new_password" required>
                </div>
                <div class="item">
                    <label for="confirmPassword">確認密碼</label>
                    <input type="password" id="confirmPassword" name="confirm_password" required>
                </div>
                <button type="submit">重設密碼</button>
            </form>
        </div>
    </div>
    <script src="../js/personal.js"></script>

</body>
</html>
