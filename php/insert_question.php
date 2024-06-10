<?php
// 連接資料庫
include "../php/ConnectDB.php";

// 定義題目資料
$questions = [
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '資料庫管理系統 (DBMS) 的主要功能是什麼？',
        'option_a' => '管理數據和資料庫',
        'option_b' => '管理操作系統',
        'option_c' => '管理網絡安全',
        'option_d' => '管理硬件設備',
        'correct_answer' => 'A'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '以下哪一個是關聯資料庫的主要概念？',
        'option_a' => '鍵值對',
        'option_b' => '文檔存儲',
        'option_c' => '表格',
        'option_d' => '圖形',
        'correct_answer' => 'C'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => 'SQL 是什麼的縮寫？',
        'option_a' => 'Structured Query Language',
        'option_b' => 'Simple Query Language',
        'option_c' => 'Sequential Query Language',
        'option_d' => 'Standard Query Language',
        'correct_answer' => 'A'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '在關聯資料庫中，表之間的關聯是通過什麼建立的？',
        'option_a' => '主鍵',
        'option_b' => '外鍵',
        'option_c' => '唯一鍵',
        'option_d' => '值鍵',
        'correct_answer' => 'B'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '資料庫正規化的主要目的是什麼？',
        'option_a' => '儲存更多數據',
        'option_b' => '減少數據冗餘',
        'option_c' => '提高數據安全',
        'option_d' => '增加數據冗餘',
        'correct_answer' => 'B'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '哪一個 SQL 語句用於從資料表中獲取數據？',
        'option_a' => 'GET',
        'option_b' => 'FETCH',
        'option_c' => 'SELECT',
        'option_d' => 'RETRIEVE',
        'correct_answer' => 'C'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '以下哪一個是資料庫索引的主要作用？',
        'option_a' => '增加資料庫大小',
        'option_b' => '減少資料庫大小',
        'option_c' => '加快查詢速度',
        'option_d' => '減慢查詢速度',
        'correct_answer' => 'C'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '哪一個 SQL 關鍵字用於更新資料表中的數據？',
        'option_a' => 'MODIFY',
        'option_b' => 'CHANGE',
        'option_c' => 'UPDATE',
        'option_d' => 'ALTER',
        'correct_answer' => 'C'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '哪一個 SQL 語句用於刪除資料表中的數據？',
        'option_a' => 'REMOVE',
        'option_b' => 'DELETE',
        'option_c' => 'DROP',
        'option_d' => 'ERASE',
        'correct_answer' => 'B'
    ],
    [
        'course_id' => 1,
        'number' => 1,
        'question' => '資料庫的 ACID 性質中的 "A" 代表什麼？',
        'option_a' => '安全性 (Authorization)',
        'option_b' => '原子性 (Atomicity)',
        'option_c' => '可靠性 (Accountability)',
        'option_d' => '一致性 (Agreement)',
        'correct_answer' => 'B'
    ]
];

// 插入題目到資料庫
foreach ($questions as $q) {
    $sql = "INSERT INTO questions (course_id, number, question, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssss", $q['course_id'], $q['number'], $q['question'], $q['option_a'], $q['option_b'], $q['option_c'], $q['option_d'], $q['correct_answer']);
    
    if ($stmt->execute()) {
        echo "題目已成功儲存: " . $q['question'] . "<br>";
    } else {
        echo "儲存題目失敗: " . $stmt->error . "<br>";
    }
}

$stmt->close();
$conn->close();
?>
    