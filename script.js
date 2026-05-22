const wrapper = document.querySelector('.wrapper');
const btnLogin = document.querySelector('.btnLogin');
const closeBtn = document.querySelector('.close-btn');

const loginForm = document.querySelector('.login');
const registerForm = document.querySelector('.register');

const goRegister = document.querySelector('.goRegister');
const goLogin = document.querySelector('.goLogin');

// open popup
if (btnLogin && wrapper && loginForm && registerForm) {
    btnLogin.onclick = () => {
        wrapper.style.display = "block";
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
    };
}

// close popup
if (closeBtn && wrapper) {
    closeBtn.onclick = () => {
        wrapper.style.display = "none";
    };
}

// switch to register
if (goRegister && loginForm && registerForm) {
    goRegister.onclick = () => {
        loginForm.classList.remove('active');
        registerForm.classList.add('active');
    };
}

// switch to login
if (goLogin && loginForm && registerForm) {
    goLogin.onclick = () => {
        registerForm.classList.remove('active');
        loginForm.classList.add('active');
    };
}