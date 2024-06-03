function login() {
    const Logintext= document.querySelector('#Logintext');
    const Registertext = document.querySelector('#Registertext');
    const loginContent = document.querySelector('.login_content');
    const login_btn= document.querySelector('.login_btn');
    const icon = document.querySelector('.icon');
    const LOGOtext = document.querySelector('.LOGOtext');
    const emailItem = document.getElementById('email-item');
    const confirmPasswordItem = document.getElementById('confirm-password-item');
    const loginBox = document.getElementById('login-box');
    const authForm = document.getElementById('auth-form');
    
    login_btn.textContent = '登入';
    Logintext.style.color = "black";
    Registertext.style.color = "rgb(135, 174, 11)";
    loginContent.style.left = "0%";
    icon.style.backgroundColor = "rgb(135, 174, 11)";
    LOGOtext.style.color = "rgb(73, 89, 32)";
     
    
    // 隱藏額外的輸入框並調整高度
    emailItem.classList.add('itemToggle');
    confirmPasswordItem.classList.add('itemToggle');
    loginBox.style.height = 'auto';
    authForm.action = '../php/process.php?action=login';
}

function register() {
    const Logintext= document.querySelector('#Logintext');
    const Registertext = document.querySelector('#Registertext');
    const loginContent = document.querySelector('.login_content');
    const icon = document.querySelector('.icon');
    const LOGOtext = document.querySelector('.LOGOtext');
    const emailItem = document.getElementById('email-item');
    const confirmPasswordItem = document.getElementById('confirm-password-item');
    const loginBox = document.getElementById('login-box');
    const login_btn= document.querySelector('.login_btn');
    const authForm = document.getElementById('auth-form');
    
    login_btn.textContent = '註冊';
    Logintext.style.color = "rgb(135, 174, 11)";
    Registertext.style.color = "black";
    loginContent.style.left = "70%";
    icon.style.backgroundColor = "white";
    LOGOtext.style.color = "white";
    
    
    emailItem.classList.remove('itemToggle');
    confirmPasswordItem.classList.remove('itemToggle');
    loginBox.style.height = 'auto'; 
    authForm.action = '../php/process.php?action=register';
}