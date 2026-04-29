const wrapper = document.querySelector('.wrapper');
const btnLogin = document.querySelector('.btnLogin');
const closeBtn = document.querySelector('.close-btn');

const loginForm = document.querySelector('.login');
const registerForm = document.querySelector('.register');

const goRegister = document.querySelector('.goRegister');
const goLogin = document.querySelector('.goLogin');

// open popup
if (btnLogin) {
    btnLogin.onclick = () => {
        wrapper.style.display = "block";
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
    };
}

// close popup
closeBtn.onclick = () => {
    wrapper.style.display = "none";
};

// switch to register
goRegister.onclick = (e) => {
    e.preventDefault();
    loginForm.classList.remove('active');
    registerForm.classList.add('active');
};

// switch to login
goLogin.onclick = (e) => {
    e.preventDefault();
    registerForm.classList.remove('active');
    loginForm.classList.add('active');
};