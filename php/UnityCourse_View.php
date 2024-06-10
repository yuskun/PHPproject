<?php
include "../php/ConnectDB.php";

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];
$course_id = 2; 

// 查詢 usercourses 表中是否有符合條件的記錄
$sql = "SELECT * FROM usercourses WHERE user_id = ? AND course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // 如果沒有符合條件的記錄，則新增一個
    $assignments_grades = json_encode([]);
    $progress = 0;
    $insert_sql = "INSERT INTO usercourses (user_id, course_id, assignments_grades, progress) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iisi", $user_id, $course_id, $assignments_grades, $progress);
    $insert_stmt->execute();
    $insert_stmt->close();
} else {
    // 如果有符合條件的記錄，則取出該記錄的 progress 欄位值
    $row = $result->fetch_assoc();
    $progress = $row['progress'];
    $assignments_grades = $row['assignments_grades'];
    $result->close();
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學習網站</title>
    <link rel="stylesheet" href="../css/course_content.css">
</head>

<body>
    <div class="course_content_body">
        <div class="container">
            <div class="sidebar">
                <div>課程進度:</div>
                <div class="progress-container">
                    <div class="progress-bar">
                    <div id="course-progress" class="progress" style="width: 0%;"></div>

                    </div>
                </div>
                <div>成績:</div>
                <div class="progress-container">
                    <div class="progress-bar">
                    <div id="exam-progress" class="progress" style="width: <?php
$grades = json_decode($assignments_grades, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "解析成績時出錯: " . json_last_error_msg();
} else {
    $average_grade = 0;
    if (is_array($grades) && !empty($grades)) {
        $average_grade = array_sum($grades) / count($grades);
    }
    echo htmlspecialchars(number_format($average_grade, 2));
} ?>%;"></div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="title">112-2 Unity</div>
                <nav>
                    <a href="#course" class="active">課程</a>
                    <a href="#communication">考試/作業</a>
                    <a href="#grades">成績</a>
                </nav>
                <hr>
                <div id="course" class="tab-content active">
                    <h2>課程</h2>
                    <details>
                        <summary>6/1</summary>
                        <div class="file-item">
                            <div>
                                <span class="file-icon">📓</span>
                                <a href="./web_pdf/case01_login system without and with database.pdf">001 login system
                                    without and with database</a>
                            </div>
                            <div><button class="complete_btn">未完成</button></div>
                        </div>
                    </details>
                    <details>
                        <summary>6/2</summary>
                        <div class="file-item">
                            <div>
                                <span class="file-icon">📓</span>
                                <a href="./web_pdf/case02_upload files without database.pdf">002 upload files without
                                    database</a>
                            </div>
                            <div><button class="complete_btn">未完成</button></div>
                        </div>
                    </details>
                    <details>
                        <summary>6/3</summary>
                        <div class="file-item">
                            <div>
                                <span class="file-icon">📓</span>
                                <a href="./web_pdf/case03_upload files with login system  (1).pdf">003 upload files with
                                    login system</a>
                            </div>
                            <div><button class="complete_btn">未完成</button></div>
                        </div>
                    </details>
                </div>
                <div id="communication" class="tab-content">
                    <h2 style="color: #628864;">考試</h2>
                    <details>
                        <summary>課堂考</summary>
                        <div class="test_item">
                            <span class="file-icon">📜</span>
                            <a href="../php/test.php?course_id=<?php echo $course_id; ?>&number=1">第一次課堂小考</a>
                            <div></div>
                        </div>
                        <div class="test_item">
                            <span class="file-icon">📜</span>
                            <a href="../php/test.php?course_id=<?php echo $course_id; ?>&number=2">第二次課堂小考</a>
                        </div>
                        <div class="test_item">
                            <span class="file-icon">📜</span>
                            <a href="../php/test.php?course_id=<?php echo $course_id; ?>&number=3">第三次課堂小考</a>
                        </div>
                    </details>
                    <details>
                        <summary>期考</summary>
                        <div class="test_item">
                            <span class="file-icon">📜</span>
                            <a href="../php/test.php?course_id=<?php echo $course_id; ?>&number=4">期中考</a>
                        </div>
                        <div class="test_item">
                            <span class="file-icon">📜</span>
                            <a href="../php/test.php?course_id=<?php echo $course_id; ?>&number=5">期末考</a>
                        </div>
                    </details>
                    <h2 style="color: #628864;">作業</h2>
                    <details>
                        <summary>課堂檢測</summary>
                        <div class="test_item">
                            <span class="file-icon">📜</span>
                            <a href="../php/test.php?course_id=<?php echo $course_id; ?>&number=6">6/1課堂作業</a>
                        </div>
                        <div class="test_item">
                            <span class="file-icon">📜</span>
                            <a href="../php/test.php?course_id=<?php echo $course_id; ?>&number=7">6/2課堂作業</a>
                        </div>
                        <div class="test_item">
                            <span class="file-icon">📜</span>
                            <a href="../php/test.php?course_id=<?php echo $course_id; ?>&number=8">6/3課堂作業</a>
                        </div>
                    </details>
                </div>
                <div id="grades" class="tab-content">
                    <div class="score_content">
                        <div class="course_names">
                            <div class="sum_content header-row">
                                <div>項目占比</div>
                                <div>獲得該項占比權重</div>
                                <div>分數</div>
                                <div>全距</div>
                                <div>獲得總成績占分</div>
                            </div>
                            <details class="section">
                                <summary class="section-header">課堂出席表現(15%)</summary>
                                <div class="sum_content">
                                    <div>15%</</div>
                                    <div>50%</</div>
                                    <div>50分</div>
                                    <div>100分</div>
                                    <div>7.5%</</div>
                                </div>
                            </details>
                            <details class="section">
                                <summary class="section-header">作業(20%)</summary>
                                <div class="sum_content">
                                    <div>20%</</div>
                                    <div>80%</</div>
                                    <div>-</div>
                                    <div>-</div>
                                    <div>16%</</div>
                                </div>
                                <details>
                                    <summary class="section-header rank1">作業一</summary>
                                    <div class="sum_content">
                                        <div>5%</</div>
                                        <div>90%</</div>
                                        <div>9分</div>
                                        <div>10分</div>
                                        <div>4.5%</</div>
                                    </div>
                                </details>
                                <details>
                                    <summary class="section-header rank1">作業二</summary>
                                    <div class="sum_content">
                                        <div>5%</</div>
                                        <div>70%</</div>
                                        <div>7分</div>
                                        <div>10分</div>
                                        <div>3.5%</</div>
                                    </div>
                                </details>
                                <details>
                                    <summary class="section-header rank1">作業三</summary>
                                    <div class="sum_content">
                                        <div>5%</</div>
                                        <div>80%</</div>
                                        <div>8分</div>
                                        <div>10分</div>
                                        <div>4%</</div>
                                    </div>
                                </details>
                            </details>
                            <details class="section">
                                <summary class="section-header">期中考(30%)</summary>
                                <div class="sum_content">
                                    <div>30%</</div>
                                    <div>85%</</div>
                                    <div>-</div>
                                    <div>-</div>
                                    <div>25.5%</</div>
                                </div>
                                <details>
                                    <summary class="section-header rank1">上機考(30%x50%)</summary>
                                    <div class="sum_content">
                                        <div>15%</</div>
                                        <div>90%</</div>
                                        <div>90分</div>
                                        <div>100分</div>
                                        <div>13.5%</</div>
                                    </div>
                                </details>
                                <details>
                                    <summary class="section-header rank1">筆試(30%x50%)</summary>
                                    <div class="sum_content">
                                        <div>15%</</div>
                                        <div>80%</</div>
                                        <div>80分</div>
                                        <div>100分</div>
                                        <div>12%</</div>
                                    </div>
                                </details>
                            </details>
                            <details class="section">
                                <summary class="section-header">期末考(35%)</summary>
                                <div class="sum_content">
                                    <div>35%</</div>
                                    <div>90%</</div>
                                    <div>-</div>
                                    <div>-</div>
                                    <div>31.5%</</div>
                                </div>
                                <details>
                                    <summary class="section-header rank1">上機考(35%x50%)</summary>
                                    <div class="sum_content">
                                        <div>17.5%</</div>
                                        <div>95%</</div>
                                        <div>95分</div>
                                        <div>100分</div>
                                        <div>16.625%</</div>
                                    </div>
                                </details>
                                <details>
                                    <summary class="section-header rank1">筆試(35%x50%)</summary>
                                    <div class="sum_content">
                                        <div>17.5%</</div>
                                        <div>85%</</div>
                                        <div>85分</div>
                                        <div>100分</div>
                                        <div>14.875%</</div>
                                    </div>
                                </details>
                            </details>
                            <div class="sum_content header-row">
                                <div colspan="4">總成績</div>
                                <div>-</div>
                                <div>-</div>
                                <div>-</div>
                                <div>80.5分</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="../js/course_content.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let courseProgress = document.getElementById('course-progress');

            // Create a MutationObserver to monitor changes to the 'style' attribute
            let observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        // Get the new width percentage
                        let widthPercentage = courseProgress.style.width;
                        let widthValue = parseInt(widthPercentage);

                        // Send the new progress value to the server using AJAX
                        let xhr = new XMLHttpRequest();
                        xhr.open("POST", "../php/update_progress.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("user_id=<?php echo $user_id; ?>&course_id=<?php echo $course_id; ?>&progress=" + widthValue);
                    }
                });
            });

            // Configuration for the observer (we want to monitor changes to the 'style' attribute)
            let config = { attributes: true, attributeFilter: ['style'] };

            // Start observing the target node for configured mutations
            observer.observe(courseProgress, config);
        });
    </script>
</body>

</html>
