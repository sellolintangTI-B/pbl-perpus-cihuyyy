// Password Validation Module
// Export fungsi-fungsi validasi yang bisa digunakan di berbagai file

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
};

 const ValidatePasswordMatch = (password, confirmPassword) => {
    const isMatch = password === confirmPassword;
    return {
        isValid: isMatch,
        message: isMatch ? 'Password cocok' : 'Password dan konfirmasi password tidak cocok'
    };
};

function debounce(func, timeout = 300) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
}