<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Noto+Sans+TC:wght@900&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../css/Course_browser.css">
    <script src="../js/Course_browser.js"></script>
</head>
<body>
    <div class="container">
        <div class="carousel">
            <button class="arrow left">&lt;</button>
            <div class="carousel-indicators">
                <div class="indicator-wrapper">
                    <div class="indicator active"></div>
                    <div class="indicator"></div>
                    <div class="indicator"></div>
                </div>
            </div>
            <button class="arrow right">&gt;</button>
        </div>
        <div class="item" id="Search">
            <div class="title">
                <div class="title_text" style="color: rgb(76, 88, 41);">最新上線</div>
                <div class="more_info">查看更多-></div>
            </div>

            <?php
            
            function Search_result($category) {
                // 連接資料庫
                include "./ConnectDB.php";

                // 從資料庫中查找對應類別的課程
                $sql = "SELECT course_name, course_author FROM courses WHERE category = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $category);
                $stmt->execute();
                $result = $stmt->get_result();

                // 生成HTML
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card-container">';
                    echo '<div class="card"></div>';
                    echo '<div class="card-title">' . htmlspecialchars($row['course_name']) . '</div>';
                    echo '<div class="card-author">by ' . htmlspecialchars($row['course_author']) . '</div>';
                    echo '</div>';
                }

                $stmt->close();
                $conn->close();
            }
            function Search_keyword($keyword) {
                // 連接資料庫
                include "../php/ConnectDB.php";

                // 構建查詢，使用LIKE來匹配關鍵字
                $sql = "SELECT course_name, course_author FROM courses WHERE course_name LIKE ?";
                $stmt = $conn->prepare($sql);
                $like_keyword = "%" . $keyword . "%";
                $stmt->bind_param("s", $like_keyword);
                $stmt->execute();
                $result = $stmt->get_result();

                // 生成HTML
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card-container">';
                    echo '<div class="card"></div>';
                    echo '<div class="card-title">' . htmlspecialchars($row['course_name']) . '</div>';
                    echo '<div class="card-author">by ' . htmlspecialchars($row['course_author']) . '</div>';
                    echo '</div>';
                }

                $stmt->close();
                $conn->close();
            }   

            // 檢查是否有傳入類別值
            if (isset($_GET['category'])) {
                $category = intval($_GET['category']);
                Search_result($category);
               
            }
            else if (isset($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                Search_keyword($keyword);
            }
            else {
                // 預設顯示內容
                echo '<div class="card-container">';
                echo '<div class="card"></div>';
                echo '<div class="card-title">Godot 遊戲引擎入門：從 2D 到 3D 的 Unity 劍星</div>';
                echo '<div class="card-author">by 小李飛刀飛啊飛</div>';
                echo '</div>';
                echo '<div class="card-container">';
                echo '<div class="card"></div>';
                echo '<div class="card-title">Godot 遊戲引擎入門：從 2D 到 3D 的 Unity 劍星</div>';
                echo '<div class="card-author">by 小李飛刀飛啊飛</div>';
                echo '</div>';
                echo '<div class="card-container">';
                echo '<div class="card"></div>';
                echo '<div class="card-title">Godot 遊戲引擎入門：從 2D 到 3D 的 Unity 劍星</div>';
                echo '<div class="card-author">by 小李飛刀飛啊飛</div>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="item" id="extra">
            <div class="title">
                <div class="title_text" style="color: rgb(76, 88, 41);">熱門課程排行</div>
                <div class="more_info"></div>
            </div>
            <div class="card-container">
                <div class="card"></div>
                <div class="card-title">Godot 遊戲引擎入門：從 2D 到 3D 的 Unity 劍星</div>
                <div class="card-author">by 小李飛刀飛啊飛</div>
            </div>
            <div class="card-container">
                <div class="card"></div>
                <div class="card-title">Godot 遊戲引擎入門：從 2D 到 3D 的 Unity 劍星</div>
                <div class="card-author">by 小李飛刀飛啊飛</div>
            </div>
            <div class="card-container">
                <div class="card"></div>
                <div class="card-title">Godot 遊戲引擎入門：從 2D 到 3D 的 Unity 劍星</div>
                <div class="card-author">by 小李飛刀飛啊飛</div>
            </div>
        </div>
    </div>
</body>
<script>
function Search_ResultPage() {
    const carousel = document.querySelector(".carousel");
const container = document.querySelector(".container");
const extra = document.querySelector("#extra");
const more_info = document.querySelector(".more_info");
const title_text = document.querySelector(".title_text");
    carousel.style.display = "none";
    container.style.justifyContent = "initial";
    extra.style.display = "none";
    more_info.innerHTML = "";
    title_text.innerHTML = "搜尋結果";
}
</script>

<?php 
if (isset($_GET['category'])||isset($_GET['keyword'])) { 
 echo "<script>Search_ResultPage();</script>";
} 
?> 

</html>
