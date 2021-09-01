// ANIMATION EFFECT

const login_btn = document.querySelector('#login-button'), 
signup_btn = document.querySelector('#signup-button'), 
container = document.querySelector('.container')
signin_form = document.forms[0]
signup_form = document.forms[1];;


signup_btn.addEventListener('click', ()=>{
    container.classList.add('enter-signup');
});

login_btn.addEventListener('click', ()=>{
    container.classList.remove('enter-signup');
});





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


signin_form.addEventListener("submit", function(event){
    if (!validateLogIn()) {
        event.preventDefault();
    }

});

signup_form.addEventListener("submit", function(event){
    if (!validateSignUp()) {
        event.preventDefault();
    }

});