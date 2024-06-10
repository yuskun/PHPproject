<?php
include "../php/ConnectDB.php";

if (!isset($_POST['user_id']) || !isset($_POST['course_id']) || !isset($_POST['progress'])) {
    die("Invalid request.");
}

$user_id = intval($_POST['user_id']);
$course_id = intval($_POST['course_id']);
$progress = intval($_POST['progress']);

// 更新 usercourses 表中的 progress 欄位
$sql = "UPDATE usercourses SET progress = ? WHERE user_id = ? AND course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $progress, $user_id, $course_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Progress updated successfully.";
} else {
    echo "Failed to update progress.";
}

$stmt->close();
$conn->close();
?>
