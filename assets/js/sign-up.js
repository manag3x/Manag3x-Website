let password = document.getElementById("password");
let passwordGuide = document.getElementById("passwordGuide");
let confirmPassword = document.getElementById("confirmPassword");
let confirmPasswordContainer = document.getElementById("confirmPasswordContainer");
let form = document.forms[0];


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

confirmPassword.addEventListener("input", check);

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

 form.addEventListener("submit", function(event){
     if (!check()) {
         event.preventDefault();     }
 })