function login() {
    const loginContent = document.querySelector('.login_content');
    const icon = document.querySelector('.icon');
    const LOGOtext = document.querySelector('.LOGOtext');
    const emailItem = document.getElementById('email-item');
    const confirmPasswordItem = document.getElementById('confirm-password-item');
    const loginBox = document.getElementById('login-box');
    
    loginContent.style.left = "0%";
    icon.style.backgroundColor = "rgb(135, 174, 11)";
    LOGOtext.style.color = "rgb(73, 89, 32)";
    setTimeout(() => {
        loginContent.classList.add('bounce-horizontal');
        setTimeout(() => {
            loginContent.classList.remove('bounce-horizontal');
        }, 500); // 移除動畫類以便於重新觸發
    }, 500); // 在動畫結束後添加回彈動畫
    
    // 隱藏額外的輸入框並調整高度
    emailItem.style.display = 'none';
    confirmPasswordItem.style.display = 'none';
    loginBox.style.height = 'auto';
}

function register() {
    const loginContent = document.querySelector('.login_content');
    const icon = document.querySelector('.icon');
    const LOGOtext = document.querySelector('.LOGOtext');
    const emailItem = document.getElementById('email-item');
    const confirmPasswordItem = document.getElementById('confirm-password-item');
    const loginBox = document.getElementById('login-box');
    
    loginContent.style.left = "72%";
    icon.style.backgroundColor = "white";
    LOGOtext.style.color = "white";
    setTimeout(() => {
        loginContent.classList.add('bounce-horizontal-reverse');
        setTimeout(() => {
            loginContent.classList.remove('bounce-horizontal-reverse');
        }, 500); // 移除動畫類以便於重新觸發
    }, 500); // 在動畫結束後添加回彈動畫
    
    // 顯示額外的輸入框並調整高度
    emailItem.style.display = 'block';
    confirmPasswordItem.style.display = 'block';
    loginBox.style.height = 'auto'; // 可根據實際需求調整
}