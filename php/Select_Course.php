<?php
include "../php/ConnectDB.php";

// 假設會話中已設置 USERID
if (!isset($_SESSION['user_id'])) {
    echo "請先登錄。";
    exit;
}

$userid = $_SESSION['user_id'];

$sql = "SELECT course_id FROM usercourses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

$course_ids = [];
while ($row = $result->fetch_assoc()) {
    $course_ids[] = $row['course_id'];
}

if (empty($course_ids)) {
    $courses = [];  
}else {
   
    $placeholders = implode(',', array_fill(0, count($course_ids), '?'));
    $sql = "SELECT id, course_name FROM courses WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($course_ids)), ...$course_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選擇課程評論區</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(249, 251, 241);
        }
        h1 {
            text-align: center;
            margin-top: 5%;
        }
        ul {
            list-style-type: none;
            padding: 0;
            max-width: 50%;
            margin: 5% auto;
        }
        li {
            background-color: rgb(238, 242, 217);
            margin: 2% 0;
            padding: 3%;
            border-radius: 5px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 2rem;
            margin: 10% 0%;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        a:hover {
            color: #007BFF;
        }
        .extra-li {
            background-color: transparent;
            margin: 2% 0;
            padding: 3%;
            border-radius: 5px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 2rem;
            margin: 10% 0%;
        }
    </style>
</head>
<body>
    <h1>選擇課程進入評論區</h1>
    <ul>
    <?php if (empty($courses)): ?>
            <li>您目前沒有任何課程記錄。</li>
            <li class="extra-li"></li> <!-- 用於保持排版 -->
        <?php else: ?>
            <?php foreach ($courses as $course): ?>
                <li><a href="message.php?courseid=<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></a></li>
            <?php endforeach; ?>
            <?php if (count($courses) == 1): ?>
                <li class="extra-li"></li> <!-- 用於保持排版 -->
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</body>
</html>
