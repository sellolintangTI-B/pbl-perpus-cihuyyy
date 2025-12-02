// import { ValidatePassword, ValidatePasswordMatch } from "./utils/password-validation";

const password = document.getElementById('password');
const password_confirmation = document.getElementById('password_confirmation');
const text_alert = document.getElementById('text_alert');
const match_alert = document.getElementById('match_alert');
const form_register = document.getElementById('form_register');


let pass = '';
let passConfirm = '';

function debounce(func, timeout = 300){
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => { func.apply(this, args); }, timeout);
  };
}

const ValidatePassword = (password) => {
    const lengthRegex = /.{8,}/;
    const lowerRegex = /[a-z]/;
    const upperRegex = /[A-Z]/;
    const numberRegex = /[0-9]/;
    const specialRegex = /[!@#$%^&*()]/;
    
    const isValid = lengthRegex.test(password) && 
                    lowerRegex.test(password) && 
                    upperRegex.test(password) && 
                    numberRegex.test(password) && 
                    specialRegex.test(password);
    
    return {
        isValid: isValid,
        message: isValid 
            ? 'Password sudah sesuai dan valid' 
            : 'Password harus terdiri dari minimal 8 karakter, mengandung huruf kecil (a-z), huruf besar (A-Z), angka (0-9), dan karakter spesial (!@#$%^&*())'
    };
}

const ValidatePasswordMatch = (password, confirmPassword) => {
    const isMatch = password === confirmPassword;
    return {
        isValid: isMatch,
        message: isMatch ? 'Password cocok' : 'Password dan konfirmasi password tidak cocok'
    };
}

function validatePass(pass){
    if(!pass || pass === ''){
        text_alert.classList.add('hidden');
        text_alert.innerHTML = '';
        return;
    }
    
    let {isValid, message} = ValidatePassword(pass);
    
    if(!isValid){
        text_alert.innerHTML = `<li class="text-red">${message}</li>`;
        text_alert.classList.remove('hidden');
    } else {
        text_alert.innerHTML = `<li class="text-secondary">${message}</li>`;
        text_alert.classList.remove('hidden');
    }
    
    if(passConfirm && passConfirm !== ''){
        validatePasswordMatch(pass, passConfirm);
    }
}

function validatePasswordMatch(pass, passConfirm){
    if(!passConfirm || passConfirm === ''){
        match_alert.classList.add('hidden');
        match_alert.innerHTML = '';
        return;
    }
    
    let {isValid, message} = ValidatePasswordMatch(pass, passConfirm);
    
    if(!isValid){
        match_alert.innerHTML = `<li class="text-red">${message}</li>`;
        match_alert.classList.remove('hidden');
    } else {
        match_alert.innerHTML = `<li class="text-secondary">${message}</li>`;
        match_alert.classList.remove('hidden');
    }
}

const debouncedValidate = debounce((value) => {
    validatePass(value);
}, 300);

const debouncedValidateMatch = debounce(() => {
    validatePasswordMatch(pass, passConfirm);
}, 300);

password.addEventListener('input', (e) => {
    pass = e.target.value;
    debouncedValidate(pass);
});

password_confirmation.addEventListener('input', (e) => {
    passConfirm = e.target.value;
    debouncedValidateMatch();
});

const formSubmitCheck = (e)=>{
     pass = password.value;
    passConfirm = password_confirmation.value;
    
    const passwordValidation = ValidatePassword(pass);
    const matchValidation = ValidatePasswordMatch(pass, passConfirm);
    
    let hasError = false;
    
    if(!pass || pass === ''){
        e.preventDefault();
        text_alert.innerHTML = `<li class="text-red">Password tidak boleh kosong</li>`;
        text_alert.classList.remove('hidden');
        hasError = true;
    } else if(!passwordValidation.isValid){
        e.preventDefault();
        text_alert.innerHTML = `<li class="text-red">${passwordValidation.message}</li>`;
        text_alert.classList.remove('hidden');
        hasError = true;
    }
    
    if(!passConfirm || passConfirm === ''){
        e.preventDefault();
        match_alert.innerHTML = `<li class="text-red">Konfirmasi password tidak boleh kosong</li>`;
        match_alert.classList.remove('hidden');
        hasError = true;
    } else if(!matchValidation.isValid){
        e.preventDefault();
        match_alert.innerHTML = `<li class="text-red">${matchValidation.message}</li>`;
        match_alert.classList.remove('hidden');
        hasError = true;
    }
    
    if(hasError){
        text_alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    
    return true;
}

if(form_register){
    form_register.addEventListener('submit', formSubmitCheck);
}

