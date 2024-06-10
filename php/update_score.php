<?php
session_start();
include "../php/ConnectDB.php";

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'];
$number = $_POST['number'];
$score = $_POST['score'];

$sql = "SELECT assignments_grades FROM usercourses WHERE user_id = ? AND course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User course not found.");
}

$row = $result->fetch_assoc();
$assignment_score = json_decode($row['assignments_grades'], true);

if (!is_array($assignment_score)) {
    $assignment_score = [];
}

$assignment_score[$number - 1] = $score;  

$updated_scores = json_encode($assignment_score);
$stmt->close();

$update_sql = "UPDATE usercourses SET  assignments_grades = ? WHERE user_id = ? AND course_id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("sii", $updated_scores, $user_id, $course_id);
$update_stmt->execute();
$update_stmt->close();

echo "Score updated successfully.";
header("Location: ../View/Database_Content.php");
exit();
?>
