<?php

include "../php/ConnectDB.php";

if (!isset($_GET['courseid'])) {
    echo "未指定課程ID。";
    exit;
}

$courseid = intval($_GET['courseid']);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('未登錄'); window.location.href='../html/login.html';</script>";
        exit();
    }

    $userid = $_SESSION['user_id'];
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        // 插入新的評論到 comments 表
        $sql = "INSERT INTO comments (user_id, course_id, comment, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $userid, $courseid, $comment);
        $stmt->execute();
    }
}

// 查找 comments 表中指定課程的評論
$sql = "SELECT c.comment, c.created_at, u.firstname, u.lastname, u.profile_picture 
        FROM comments c 
        JOIN users u ON c.user_id = u.id 
        WHERE c.course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $courseid);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
    $sql = "SELECT firstname, lastname, profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言互動區</title>
    <link rel="stylesheet" href="../css/message.css">
</head>

<body>
<div class="msg_body">
        <h1>留言互動區</h1>
        <div class="big_send">
            <div class="border_img">
                <img class="img" src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="">
                <div class="user_name"><?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']); ?></div>
            </div>
            <div class="send">
                <form action="message.php?courseid=<?php echo $courseid; ?>" method="post">
                    <textarea class="input" name="comment" placeholder="輸入留言"></textarea>
                    <button type="submit">發表評論</button>
                </form>
            </div>
        </div>
        <div class="comment_body">
            <?php if (empty($comments)): ?>
                <div class="big_comment">
                    <div class="send_text">目前沒有評論。</div>
                </div>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="big_comment">
                        <div class="border_img">
                            <img class="img" src="<?php echo htmlspecialchars($comment['profile_picture']); ?>" alt="">
                            <div class="user_name"><?php echo htmlspecialchars($comment['firstname']) . ' ' . htmlspecialchars($comment['lastname']); ?></div>
                        </div>
                        <div class="send_text">
                            <div class="comment"><?php echo htmlspecialchars($comment['comment']); ?></div>
                            <div class="comment_time"><?php echo htmlspecialchars($comment['created_at']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
