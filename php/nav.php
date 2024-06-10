<?php
include "../php/ConnectDB.php";

if (!isset($_SESSION['user_id'])) {
    echo "請先登錄。";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql_user = "SELECT profile_picture FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$stmt_user->close();
// 查询用户的所有通知
$sql = "SELECT id, message FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[$row['id']] = $row['message'];  // 使用通知的實際ID作為鍵
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="../css/nav.css" />
  <script src="../js/nav.js"></script>
</head>

<body>
  <div class="nav">
    <!-- logoArea -->
    <div class="logoArea" onclick="ToCourseSearch()">
      <div class="logo"></div>
      <div class="navLogoText">EduSustain</div>
    </div>

    <!-- search area -->
    <div class="searchArea">
      <div class="categoryButton">
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" stroke="currentColor"
          xmlns="http://www.w3.org/2000/svg">
          <rect x="5.99994" y="6" width="6" height="6" rx="3" stroke-width="2.5" />
          <rect x="14.9999" y="6" width="6" height="6" rx="3" stroke-width="2.5" />
          <rect x="23.9999" y="6" width="6" height="6" rx="3" stroke-width="2.5" />
          <rect x="5.99994" y="15" width="6" height="6" rx="3" stroke-width="2.5" />
          <rect x="14.9999" y="15" width="6" height="6" rx="3" stroke-width="2.5" />
          <rect x="23.9999" y="15" width="6" height="6" rx="3" stroke-width="2.5" />
          <rect x="5.99994" y="24" width="6" height="6" rx="3" stroke-width="2.5" />
          <rect x="14.9999" y="24" width="6" height="6" rx="3" stroke-width="2.5" />
          <rect x="23.9999" y="24" width="6" height="6" rx="3" stroke-width="2.5" />
        </svg>
        <div class="floatingWindow">
          <div class="title">課程分類</div>
          <p onclick="filterCourses(1)">歷史人文</p>
          <p onclick="filterCourses(2)">藝術設計</p>
          <p onclick="filterCourses(3)">哲學思維</p>
          <p onclick="filterCourses(4)">數理科學</p>
          <p onclick="filterCourses(5)">語言邏輯</p>
          <p onclick="filterCourses(6)">創客科技</p>
          <p onclick="filterCourses(7)">工業美學</p>
        </div>
      </div>
      <div class="searchBar">
        <div class="navRegularButtons">
          <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M20.6667 18.6667H19.6133L19.24 18.3067C20.5467 16.7867 21.3333 14.8133 21.3333 12.6667C21.3333 7.88 17.4533 4 12.6667 4C7.88 4 4 7.88 4 12.6667C4 17.4533 7.88 21.3333 12.6667 21.3333C14.8133 21.3333 16.7867 20.5467 18.3067 19.24L18.6667 19.6133V20.6667L25.3333 27.32L27.32 25.3333L20.6667 18.6667ZM12.6667 18.6667C9.34667 18.6667 6.66667 15.9867 6.66667 12.6667C6.66667 9.34667 9.34667 6.66667 12.6667 6.66667C15.9867 6.66667 18.6667 9.34667 18.6667 12.6667C18.6667 15.9867 15.9867 18.6667 12.6667 18.6667Z"
              fill=currentColor />
          </svg>
        </div>
        <form id="searchForm" action="Course_Search.php" method="GET">
          <input class="searchInput" type="text" name="keyword" placeholder="搜索課程" />
        </form>
      </div>
    </div>

    <!-- featureArea -->
    <div class="featureArea">
      <div class="featureButtons">
        <div class="navRegularButtons" onclick="ToCourse()">
          <svg width="48" height="48" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M8.65698 9.9819C8.65706 9.62809 8.79767 9.28879 9.04789 9.03865C9.29804 8.78842 9.63734 8.64781 9.99115 8.64774L20.6645 8.66775C21.4013 8.66775 21.9986 9.26507 21.9986 10.0019V24.6777C21.9986 25.4146 21.4013 26.0119 20.6645 26.0119H9.99115C9.25431 26.0119 8.65698 25.4146 8.65698 24.6777V9.9819ZM27.3353 8.66641L38.0086 8.64774C38.7455 8.64774 39.3428 9.24506 39.3428 9.9819V16.6714C39.3428 17.4083 38.7455 18.0056 38.0086 18.0056H27.3353C26.5985 18.0056 26.0011 17.4083 26.0011 16.6714V10.0006C26.0011 9.26374 26.5985 8.66641 27.3353 8.66641ZM21.6077 38.9613C21.858 38.7112 21.9986 38.3719 21.9986 38.0181V31.3472C21.9986 30.6104 21.4013 30.0131 20.6645 30.0131H9.99115C9.25431 30.0131 8.65698 30.6104 8.65698 31.3472V37.9981C8.65698 38.7349 9.25431 39.3322 9.99115 39.3322L20.6645 39.3509C21.0181 39.3512 21.3574 39.2111 21.6077 38.9613ZM27.3353 22.0094H38.0086C38.7455 22.0094 39.3428 22.6067 39.3428 23.3436V38.0007C39.3428 38.7376 38.7455 39.3349 38.0086 39.3349L27.3353 39.3536C26.5985 39.3536 26.0011 38.7563 26.0011 38.0194V23.3436C26.0011 22.6067 26.5985 22.0094 27.3353 22.0094Z" />
          </svg>
        </div>
        <div class="navRegularButtons" onclick="ToPersonal()">
          <svg width="48" height="48" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M36.6746 7.98999H11.3254C9.48331 7.98999 7.98999 9.48331 7.98999 11.3254V36.6746C7.98999 37.5592 8.3414 38.4076 8.96691 39.0331C9.59242 39.6586 10.4408 40.01 11.3254 40.01H36.6746C37.5592 40.01 38.4076 39.6586 39.0331 39.0331C39.6586 38.4076 40.01 37.5592 40.01 36.6746V11.3254C40.01 10.4408 39.6586 9.59242 39.0331 8.96691C38.4076 8.3414 37.5592 7.98999 36.6746 7.98999ZM32.6721 20.6646H26.6683C25.9315 20.6646 25.3342 20.0672 25.3342 19.3304C25.3342 18.5936 25.9315 17.9962 26.6683 17.9962H32.6721C33.4089 17.9962 34.0062 18.5936 34.0062 19.3304C34.0062 20.0672 33.4089 20.6646 32.6721 20.6646ZM32.6721 32.6721C33.4089 32.6721 34.0062 32.0747 34.0062 31.3379C34.0062 30.6011 33.4089 30.0037 32.6721 30.0037H26.6683C25.9315 30.0037 25.3342 30.6011 25.3342 31.3379C25.3342 32.0747 25.9315 32.6721 26.6683 32.6721H32.6721ZM23.0661 15.4613L19.0636 20.798C18.8322 21.1086 18.4773 21.3034 18.091 21.3317H17.9962C17.6424 21.3316 17.3031 21.191 17.053 20.9407L15.0517 18.9395C14.5304 18.4186 14.5301 17.5736 15.0511 17.0523C15.572 16.531 16.4169 16.5307 16.9382 17.0517L17.8521 17.9656L20.9314 13.8603C21.3735 13.2709 22.2098 13.1514 22.7992 13.5935C23.3887 14.0356 23.5082 14.8719 23.0661 15.4613ZM19.0636 34.1397L23.0661 28.803C23.5082 28.2135 23.3887 27.3773 22.7992 26.9352C22.2098 26.4931 21.3735 26.6125 20.9314 27.202L17.8521 31.3086L16.9382 30.3947C16.4147 29.889 15.5826 29.8963 15.068 30.4109C14.5534 30.9255 14.5461 31.7577 15.0517 32.2812L17.053 34.2824C17.33 34.5485 17.7068 34.6848 18.09 34.6576C18.4732 34.6304 18.8269 34.4422 19.0636 34.1397Z" />
            <mask id="mask0_335_225" style="mask-type: alpha" maskUnits="userSpaceOnUse" x="7" y="7" width="34"
              height="34">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M36.6746 7.98999H11.3254C9.48331 7.98999 7.98999 9.48331 7.98999 11.3254V36.6746C7.98999 37.5592 8.3414 38.4076 8.96691 39.0331C9.59242 39.6586 10.4408 40.01 11.3254 40.01H36.6746C37.5592 40.01 38.4076 39.6586 39.0331 39.0331C39.6586 38.4076 40.01 37.5592 40.01 36.6746V11.3254C40.01 10.4408 39.6586 9.59242 39.0331 8.96691C38.4076 8.3414 37.5592 7.98999 36.6746 7.98999ZM32.6721 20.6646H26.6683C25.9315 20.6646 25.3342 20.0672 25.3342 19.3304C25.3342 18.5936 25.9315 17.9962 26.6683 17.9962H32.6721C33.4089 17.9962 34.0062 18.5936 34.0062 19.3304C34.0062 20.0672 33.4089 20.6646 32.6721 20.6646ZM32.6721 32.6721C33.4089 32.6721 34.0062 32.0747 34.0062 31.3379C34.0062 30.6011 33.4089 30.0037 32.6721 30.0037H26.6683C25.9315 30.0037 25.3342 30.6011 25.3342 31.3379C25.3342 32.0747 25.9315 32.6721 26.6683 32.6721H32.6721ZM23.0661 15.4613L19.0636 20.798C18.8322 21.1086 18.4773 21.3034 18.091 21.3317H17.9962C17.6424 21.3316 17.3031 21.191 17.053 20.9407L15.0517 18.9395C14.5304 18.4186 14.5301 17.5736 15.0511 17.0523C15.572 16.531 16.4169 16.5307 16.9382 17.0517L17.8521 17.9656L20.9314 13.8603C21.3735 13.2709 22.2098 13.1514 22.7992 13.5935C23.3887 14.0356 23.5082 14.8719 23.0661 15.4613ZM19.0636 34.1397L23.0661 28.803C23.5082 28.2135 23.3887 27.3773 22.7992 26.9352C22.2098 26.4931 21.3735 26.6125 20.9314 27.202L17.8521 31.3086L16.9382 30.3947C16.4147 29.889 15.5826 29.8963 15.068 30.4109C14.5534 30.9255 14.5461 31.7577 15.0517 32.2812L17.053 34.2824C17.33 34.5485 17.7068 34.6848 18.09 34.6576C18.4732 34.6304 18.8269 34.4422 19.0636 34.1397Z"
                fill="white" />
            </mask>
            <g mask="url(#mask0_335_225)"></g>
          </svg>
        </div>
        <div class="navRegularButtons" onclick="ToMessage()">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M27.3353 8.65707H13.9936C11.0463 8.65707 8.65698 11.0464 8.65698 13.9937V20.6646C8.65698 23.6119 11.0463 26.0012 13.9936 26.0012H15.3278V31.3379L21.3316 26.0012H27.3353C30.2827 26.0012 32.672 23.6119 32.672 20.6646V13.9937C32.672 11.0464 30.2827 8.65707 27.3353 8.65707Z"
              fill="currentColor" stroke-linejoin="round" />
            <path
              d="M23.3328 30.0038V32.005C23.3328 32.8896 23.6842 33.738 24.3097 34.3635C24.9352 34.989 25.7836 35.3404 26.6682 35.3404H30.0036L34.0061 39.3429V35.3404H36.0073C36.892 35.3404 37.7403 34.989 38.3658 34.3635C38.9914 33.738 39.3428 32.8896 39.3428 32.005V28.0025C39.3428 26.1604 37.8494 24.6671 36.0073 24.6671H35.3403"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </div>
        <div class="navRegularButtons" onclick="toggleNotificationWindow()">
          <svg width="48" height="48" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M34.0064 29.3367C34.0064 30.4419 34.9024 31.3379 36.0076 31.3379C36.7445 31.3379 37.3418 31.9352 37.3418 32.6721C37.3418 33.4089 36.7445 34.0062 36.0076 34.0062H11.9926C11.2558 34.0062 10.6584 33.4089 10.6584 32.6721C10.6584 31.9352 11.2558 31.3379 11.9926 31.3379C13.0979 31.3379 13.9939 30.4419 13.9939 29.3367V22.8499C13.8347 17.6152 17.5168 13.0464 22.6659 12.0899V9.32416C22.6659 8.58732 23.2633 7.98999 24.0001 7.98999C24.737 7.98999 25.3343 8.58732 25.3343 9.32416V12.0899C30.4834 13.0464 34.1655 17.6152 34.0064 22.8499V29.3367ZM21.0169 36.0075H26.9833C27.1533 36.0066 27.2964 36.1346 27.3142 36.3037C27.3287 36.4268 27.3359 36.5506 27.3355 36.6746C27.3355 38.5167 25.8422 40.01 24.0001 40.01C22.158 40.01 20.6647 38.5167 20.6647 36.6746C20.6644 36.5506 20.6715 36.4268 20.686 36.3037C20.705 36.1352 20.8474 36.0078 21.0169 36.0075Z"
              fill="currentColor" />
          </svg>
          <span class="notification-count"><?php echo count($notifications)  ?></span>
        </div>
        <div class="notificationWindowAlert" id="notificationWindowAlert">
    <div class="title">通知</div>
    <?php if (empty($notifications)): ?>
        <p>目前沒有新通知。</p>
    <?php else: ?>
        <?php foreach ($notifications as $notification_id => $notification): ?>
            <div id="notification-<?php echo $notification_id; ?>">
                <p>
                    <?php echo htmlspecialchars($notification); ?>
                    <button class="delete-button" onclick="deleteNotification(<?php echo $notification_id; ?>)">×</button>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

      </div>

      <div class="userIcon" style=" background-image:url(<?php echo htmlspecialchars($user['profile_picture'] ?: '../image/web_img.png'); ?>)">
   
</div>

    </div>
  </div>
</body>

</html>