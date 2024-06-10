function ToPersonal() {
    window.location = "../View/personal.php";
}
function ToMessage() {
    window.location = "../View/Select_CourseComment.php";
}
function ToCourse() {
    window.location = "../View/course.php";
}

function toggleNotificationWindow() {
  const notificationWindow = document.getElementById('notificationWindowAlert');
  if (notificationWindow.style.display === 'none' || notificationWindow.style.display === '') {
      notificationWindow.style.display = 'block';
  } else {
      notificationWindow.style.display = 'none';
  }
}
  function ToCourseSearch() {
    window.location = "../View/Course_Search.php";
}
function filterCourses(categoryId) {
  window.location.href = `Course_Search.php?category=${categoryId}`;
}
document.querySelector('.searchInput').addEventListener('keydown', function (event) {
  if (event.key === 'Enter') {
    event.preventDefault();

    document.getElementById('searchForm').submit();
  }
});
function deleteNotification(notificationId) {
  console.log(notificationId); 
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'process.php?action=delete_notification', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
      if (xhr.status === 200) {
          console.log(xhr.responseText); 
          if (xhr.responseText.includes("通知已刪除")) {
              document.getElementById('notification-' + notificationId).remove();
              updateNotificationCount(); 
          } else {
              alert(xhr.responseText);
          }
      } else {
          console.error('請求失敗，狀態碼：' + xhr.status);
      }
  };
  xhr.onerror = function() {
      console.error('請求錯誤');
  };
  xhr.send('notification_id=' + notificationId);
}

function updateNotificationCount() {
  const notificationElements = document.querySelectorAll('.notification-item');
  const notificationCount = notificationElements.length;
  const notificationCountElement = document.querySelector('.notification-count');
  if (notificationCountElement) {
      notificationCountElement.textContent = notificationCount;
  }
}
