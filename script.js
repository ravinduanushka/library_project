const wrapper = document.querySelector('.wrapper');
const btnLogin = document.querySelector('.btnLogin');
const closeBtn = document.querySelector('.close-btn');

const loginForm = document.querySelector('.login');
const registerForm = document.querySelector('.register');

const goRegister = document.querySelector('.goRegister');
const goLogin = document.querySelector('.goLogin');

btnLogin.addEventListener("click", () => {
    wrapper.style.display = "block";
    loginForm.classList.add("active");
    registerForm.classList.remove("active");
});

closeBtn.addEventListener("click", () => {
    wrapper.style.display = "none";
});

goRegister.addEventListener("click", (e) => {
    e.preventDefault();
    loginForm.classList.remove("active");
    registerForm.classList.add("active");
});

goLogin.addEventListener("click", (e) => {
    e.preventDefault();
    registerForm.classList.remove("active");
    loginForm.classList.add("active");
});