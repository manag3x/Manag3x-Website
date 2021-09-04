let password = document.getElementById("password");
let passwordGuide = document.getElementById("passwordGuide");
let confirmPassword = document.getElementById("confirmPassword");
let confirmPasswordContainer = document.getElementById("confirmPasswordContainer");
let form = document.forms[0];
// ANIMATION EFFECT
const login_btn = document.querySelector('#login-button'), 
signup_btn = document.querySelector('#signup-button'), 
container = document.querySelector('.container');
let signin_form = document.forms[0];
let signup_form = document.forms[1];
const no_otp_btn = document.querySelector('#no-otp-btn'), 
email_otp_btn = document.querySelector('#email-otp-btn'), 
container_otp = document.querySelector('.container-otp');

if(confirmPassword) confirmPassword.addEventListener("input", check);
if(signin_form) signin_form.addEventListener("submit", function(event){
    if (!validateLogIn()) {
        event.preventDefault();
    }
});

if(signup_form) signup_form.addEventListener("submit", function(event){
    if (!validateSignUp()) {
        event.preventDefault();
    }

});

if(form) form.addEventListener("submit", function(event){
    if (!check()) {
        event.preventDefault();     
    }
})

if(signup_btn) signup_btn.addEventListener('click', ()=>{
    container.classList.add('enter-signup');
});

if(login_btn) login_btn.addEventListener('click', ()=>{
    container.classList.remove('enter-signup');
});

if(no_otp_btn) no_otp_btn.addEventListener('click', ()=>{
    container_otp.classList.add('enter-no-otp');
});

if(email_otp_btn) email_otp_btn.addEventListener('click', ()=>{
    container_otp.classList.remove('enter-no-otp');
});

function displayPassword() {
    if (passwordGuide.classList.contains("fa-eye")) {
        password.type = "text";
        passwordGuide.classList.remove("fa-eye");
        passwordGuide.classList.add("fa-eye-slash");  
        
    } else {
        password.type = "password";
        passwordGuide.classList.remove("fa-eye-slash");
        passwordGuide.classList.add("fa-eye");  
        

    }
}

function clickEvent(present,next) {
    if(present.value.length) {
        document.getElementById(next).focus();
    }
}

function check() {
    let confirmPasswordValue = confirmPassword.value.trim();
    let confirmPasswordValueLength = confirmPasswordValue.length;
    let passwordValue = password.value.trim();
    let passwordValueLength = passwordValue.length;
    if (confirmPasswordValueLength > 0 && confirmPasswordValue === passwordValue) {
        if (confirmPasswordContainer.classList.contains("passwordsUnequal")) {
            confirmPasswordContainer.classList.remove("passwordsUnequal");
            confirmPasswordContainer.classList.add("passwordsEqual");   
        } else {
            confirmPasswordContainer.classList.add("passwordsEqual");   
        }
        return true;
    } else if (confirmPasswordValueLength > 0 && confirmPasswordValue !== passwordValue){
        
        if (confirmPasswordContainer.classList.contains("passwordsEqual")) {
            confirmPasswordContainer.classList.remove("passwordsEqual");
            confirmPasswordContainer.classList.add("passwordsUnequal");   
        } else {
            confirmPasswordContainer.classList.add("passwordsUnequal");   
        }
        
        return false;
    }
}

// INPUT VALIDATIONS

function validateLogIn() {
    const userEmail = document.querySelector("#email"), 
    userPassword = document.querySelector("#password")

    if (userEmail.value.trim() == ""){
        userEmail.style.border = "2px solid red";
        return false;
    } else if (userPassword.value.trim() == ""){
        userEmail.style.border = "2px solid red";
        userPassword.placeholder = "You haven't input any password Fam!"
        return false;
    } else if (userPassword.value.trim().length < 6) {
        userPassword.style.border = "2px solid red";
        userPassword.placeholder = "Hello! Your password is too weak for my liking";
        return false
    } else  {
        return true;
    }
}

function validateSignUp() {
    const signupUserEmail = document.querySelector("#signup-email"),
    signupUserPassword = document.querySelector("#signup-password"),
    confirmPassword = document.querySelector("#signup-confirm-password")

    if (signupUserEmail.value.trim() == "") {
        signupUserEmail.style.border = "2px solid red";
        return false;
    } else if (signupUserPassword.value.trim() == "") {
        signupUserPassword.style.border = "2px solid red";
        return false;
    } else if (confirmPassword.value.trim() != confirmPassword.value.trim()) {
        confirmPassword.style.border = "2px solid red";
        return false;
    } else if (signupUserPassword.value.trim() == "") {
        signupUserPassword.style.border = "2px solid red";
        return false;
    } else {
        return true;
    }
    
}