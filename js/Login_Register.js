function login() {
    console.log('login');
    const loginContent = document.querySelector('.login_content');
    const icon = document.querySelector('.icon');
    const LOGOtext = document.querySelector('.LOGOtext');
    const emailItem = document.getElementById('email-item');
    const confirmPasswordItem = document.getElementById('confirm-password-item');
    const loginBox = document.getElementById('login-box');
    const submitBtn = document.getElementById('submit-btn');
    const authForm = document.getElementById('auth-form');
    this.color = "white";

    loginContent.style.left = "0%";
    icon.style.backgroundColor = "rgb(135, 174, 11)";
    LOGOtext.style.color = "rgb(73, 89, 32)";
    setTimeout(() => {
        loginContent.classList.add('bounce-horizontal');
        setTimeout(() => {
            loginContent.classList.remove('bounce-horizontal');
        }, 500);
    }, 500);
    
    emailItem.style.display = 'none';
    confirmPasswordItem.style.display = 'none';
    loginBox.style.height = 'auto';
    
    submitBtn.textContent = '登入';
    authForm.action = '../php/process.php?action=login';
}

function register() {
    console.log('register');
    const loginContent = document.querySelector('.login_content');
    const icon = document.querySelector('.icon');
    const LOGOtext = document.querySelector('.LOGOtext');
    const emailItem = document.getElementById('email-item');
    const confirmPasswordItem = document.getElementById('confirm-password-item');
    const loginBox = document.getElementById('login-box');
    const submitBtn = document.getElementById('submit-btn');
    const authForm = document.getElementById('auth-form');
    this.color = "rgb(135, 174, 11)";

    
    loginContent.style.left = "72%";
    icon.style.backgroundColor = "white";
    LOGOtext.style.color = "white";
    setTimeout(() => {
        loginContent.classList.add('bounce-horizontal-reverse');
        setTimeout(() => {
            loginContent.classList.remove('bounce-horizontal-reverse');
        }, 500);
    }, 500);
    
    emailItem.style.display = 'block';
    confirmPasswordItem.style.display = 'block';
    loginBox.style.height = 'auto';
    
    submitBtn.textContent = '註冊';
    authForm.action = '../php/process.php?action=register';
}
