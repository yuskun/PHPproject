<?php
include "../php/ConnectDB.php";

if (!isset($_SESSION['user_id'])) {
    echo "請先登錄。";
    exit;
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT course_id, assignments_grades, progress FROM usercourses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

$course_names = [];
if (!empty($courses)) {
    // 查找所有課程的名稱
    $course_ids = array_column($courses, 'course_id');
    $placeholders = implode(',', array_fill(0, count($course_ids), '?'));
    $types = str_repeat('i', count($course_ids));

    $sql = "SELECT id, course_name FROM courses WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$course_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $course_names[$row['id']] = $row['course_name'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>參與課程</title>
    <link rel="stylesheet" href="../css/course.css">
</head>
<body>
    <div class="crouse_body">
        <h1 class="title">參與課程</h1>
        <table>
            <thead>
                <tr class="item_name">
                    <th style="width: 45%;">課程名稱</th>
                    <th style="width: 35%;">進度</th>
                    <th style="width: 20%;">成績</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course_names[$course['course_id']] ?? '未知課程'); ?></td>
                    <td>
                        <div class="a">
                            <div class="progress_text"><?php echo htmlspecialchars($course['progress']); ?>%</div>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo htmlspecialchars($course['progress']); ?>%;"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php
                        $assignments_grades = trim($course['assignments_grades'], '"');
                        $grades = json_decode($assignments_grades, true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            echo "解析成績時出錯: " . json_last_error_msg();
                        } else {
                            $average_grade = is_array($grades) ? array_sum($grades) / count($grades) : 0;
                            echo htmlspecialchars(number_format($average_grade, 2));
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
