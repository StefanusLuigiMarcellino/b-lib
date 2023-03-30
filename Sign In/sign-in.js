window.onload = () => {
    // sign up validations
    const createButton = document.getElementById('signin');
    createButton.onclick = () => {
        let flag = 0;

        // validate nip
        const nip = document.getElementById('nip');
        const nipValidation = document.getElementById('nip-validation');

        if(nip.value.trim() === ''){
            nipValidation.innerText = 'Please fill the NIP!';
            flag = 1;
        }else if(nip.value.length !== 4){
            nipValidation.innerText = 'NIP length must be 4 characters!';
            flag = 1;
        }else{
            nipValidation.innerText = '';
        }

        // validate password
        const password = document.getElementById('password');
        const passwordValidation = document.getElementById('password-validation');

        if(password.value.trim() === ''){
            passwordValidation.innerText = 'Please fill the password!';
            flag = 1;
        }else{
            passwordValidation.innerText = '';
        }

        // check if there is an error
        if(flag === 1){
            return false;
        }
        document.getElementById('form').submit();
    }
}