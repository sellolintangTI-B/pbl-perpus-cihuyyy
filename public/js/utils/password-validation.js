

export const ValidatePassword = (password) => {
    const lengthRegex = /.{8,}/;
    const lowerRegex = /[a-z]/;
    const upperRegex = /[A-Z]/;
    const numberRegex = /[0-9]/;
    const specialRegex = /[!@#$%^&*()]/;
    let messages = [];
    
    if (!lengthRegex.test(password)) {
        messages.push({
            identifier: 'length',
            message: 'Password harus terdiri dari minimal 8 karakter'
        });
    }
    
    if (!lowerRegex.test(password)) {
        messages.push({
            identifier: 'lowercase',
            message: 'Password harus mengandung minimal 1 huruf kecil (a-z)'
        });
    }
    
    if (!upperRegex.test(password)) {
        messages.push({
            identifier: 'uppercase',
            message: 'Password harus mengandung minimal 1 huruf besar (A-Z)'
        });
    }
    
    if (!numberRegex.test(password)) {
        messages.push({
            identifier: 'number',
            message: 'Password harus mengandung minimal 1 angka (0-9)'
        });
    }
    
    if (!specialRegex.test(password)) {
        messages.push({
            identifier: 'special',
            message: 'Password harus mengandung minimal 1 karakter spesial (!@#$%^&*())'
        });
    }
    
    const isValid = messages.length === 0;
    
    return {
        isValid: isValid,
        messages: messages
    };
}

export const ValidatePasswordMatch = (password, confirmPassword) => {
    const isMatch = password === confirmPassword;
    return {
        isValid: isMatch,
        message: isMatch ? '' : 'Password dan konfirmasi password tidak cocok'
    };
}

export const GetPasswordStrength = (password) => {
    let strength = 0;
    const checks = {
        length: /.{8,}/.test(password),
        lowercase: /[a-z]/.test(password),
        uppercase: /[A-Z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[!@#$%^&*()]/.test(password),
        longLength: /.{12,}/.test(password)
    };
    
    if (checks.length) strength += 20;
    if (checks.lowercase) strength += 20;
    if (checks.uppercase) strength += 20;
    if (checks.number) strength += 20;
    if (checks.special) strength += 20;
    if (checks.longLength) strength += 10; 
    
    let level = 'Sangat Lemah';
    let color = 'red';
    
    if (strength >= 90) {
        level = 'Sangat Kuat';
        color = 'tertiary';
    } else if (strength >= 70) {
        level = 'Kuat';
        color = 'secondary';
    } else if (strength >= 50) {
        level = 'Sedang';
        color = 'yellow';
    } else if (strength >= 30) {
        level = 'Lemah';
        color = 'orange';
    }
    
    return {
        strength: strength,
        level: level,
        color: color
    };
}