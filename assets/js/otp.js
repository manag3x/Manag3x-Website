const no_otp_btn = document.querySelector('#no-otp-btn'), 
email_otp_btn = document.querySelector('#email-otp-btn'), 
container_otp = document.querySelector('.container-otp');


no_otp_btn.addEventListener('click', ()=>{
    container_otp.classList.add('enter-no-otp');
});


email_otp_btn.addEventListener('click', ()=>{
    container_otp.classList.remove('enter-no-otp');
});