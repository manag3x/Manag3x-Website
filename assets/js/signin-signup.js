const login_btn = document.querySelector('#login-button'), 
signup_btn = document.querySelector('#signup-button'), 
container = document.querySelector('.container');

signup_btn.addEventListener('click', ()=>{
    container.classList.add('enter-signup');
});

login_btn.addEventListener('click', ()=>{
    container.classList.remove('enter-signup');
});