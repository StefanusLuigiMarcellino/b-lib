window.onload = () => {
    // sign up validations
    const createButton = document.getElementById('signup');
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

        // validate program
        const program = document.getElementById('program');
        const programValidation = document.getElementById('program-validation');

        if(program.value.trim() === ''){
            programValidation.innerText = 'Please fill the program!';
            flag = 1;
        }else{
            programValidation.innerText = '';
        }

        // validate name
        const name = document.getElementById('name');
        const nameValidation = document.getElementById('name-validation');

        if(name.value.trim() === ''){
            nameValidation.innerText = 'Please fill the name!';
            flag = 1;
        }else if(name.value.length > 100){
            nameValidation.innerText = 'Name max character is 100!';
            flag = 1;
        }else{
            nameValidation.innerText = '';
        }

        // validate email
        const email = document.getElementById('email');
        const emailValidation = document.getElementById('email-validation');

        if(email.value.trim() === ''){
            emailValidation.innerText = 'Please fill the email!';
            flag = 1;
        }else if(!email.value.includes('@gmail.com')){
            emailValidation.innerText = 'Email must end with "@gmail.com!';
            flag = 1;
        }else{
            emailValidation.innerText = '';
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