<?php
session_start();
include "../php/ConnectDB.php";

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$number = isset($_GET['number']) ? intval($_GET['number']) : 0;

if ($course_id == 0 || $number == 0) {
    die("Invalid course ID or question number.");
}


$questions = [];


$sql = "SELECT question, option_a, option_b, option_c, option_d, correct_answer FROM questions WHERE course_id = ? AND number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $course_id, $number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo $course_id;
    echo $number;
    die("Question not found.");
}

while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>資料庫基礎測驗</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
        }
        
        .question-container {
            margin-top: 20px;
        }
        
        .question {
            margin-bottom: 20px;
        }
        
        .question-text {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .options {
            display: flex;
            flex-direction: column;
        }
        
        .options label {
            margin-bottom: 5px;
            font-size: 16px;
        }
        
        button {
            display: block;
            padding: 10px;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        
        button:hover {
            background-color: #ffffff;
            color: #000000;
            border: solid 1px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>資料庫基礎測驗</h1>
        <div class="question-container">
            <?php foreach ($questions as $index => $question) { ?>
            <div class="question">
                <p class="question-text"><?php echo htmlspecialchars($question['question']); ?></p>
                <div class="options" id="question_<?php echo $index; ?>" data-correct-answer="<?php echo htmlspecialchars($question['correct_answer']); ?>">
                    <label><input type="radio" name="answer_<?php echo $index; ?>" value="A"> <?php echo htmlspecialchars($question['option_a']); ?></label>
                    <label><input type="radio" name="answer_<?php echo $index; ?>" value="B"> <?php echo htmlspecialchars($question['option_b']); ?></label>
                    <label><input type="radio" name="answer_<?php echo $index; ?>" value="C"> <?php echo htmlspecialchars($question['option_c']); ?></label>
                    <label><input type="radio" name="answer_<?php echo $index; ?>" value="D"> <?php echo htmlspecialchars($question['option_d']); ?></label>
                </div>
            </div>
            <?php } ?>
        </div>
        <button onclick="submitQuiz()">提交</button>
    </div>

    <script>
        function submitQuiz() {
            let score = 0;
            const questions = document.querySelectorAll('.question');
            
            questions.forEach((question, index) => {
                const selectedOption = document.querySelector(`input[name="answer_${index}"]:checked`);
                if (selectedOption) {
                    const correctAnswer = question.querySelector('.options').getAttribute('data-correct-answer');
                    if (selectedOption.value === correctAnswer) {
                        score += 100 / questions.length;
                    }
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../php/update_score.php';
            
            const courseIdInput = document.createElement('input');
            courseIdInput.type = 'hidden';
            courseIdInput.name = 'course_id';
            courseIdInput.value = <?php echo $course_id; ?>;
            form.appendChild(courseIdInput);
            
            const numberInput = document.createElement('input');
            numberInput.type = 'hidden';
            numberInput.name = 'number';
            numberInput.value = <?php echo $number; ?>;
            form.appendChild(numberInput);
            
            const scoreInput = document.createElement('input');
            scoreInput.type = 'hidden';
            scoreInput.name = 'score';
            scoreInput.value = score;
            form.appendChild(scoreInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
