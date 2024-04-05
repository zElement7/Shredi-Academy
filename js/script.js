document.addEventListener("DOMContentLoaded", function ()
{
    function validate()
    {
        // get the entered password and confirm password values
        let enteredPassword = document.getElementById("create-password").value.trim();
        let confirmPassword = document.getElementById("confirm-password").value.trim();

        // test password criteria
        let passwordMinLength = enteredPassword.length >= 8;
        let passwordHasNumber = /\d/.test(enteredPassword);

        // get feedback message elements
        let passwordMessage1 = document.getElementById("password-message1");
        let passwordMessage2 = document.getElementById("password-message2");
        let passwordMessage3 = document.getElementById("password-message3");

        // checks password criteria and updates feedback messages
        if(enteredPassword && !passwordMinLength) passwordMessage1.innerHTML = 'Password must be at least 8 characters long.';
        else passwordMessage1.innerHTML = '';

        if(enteredPassword && !passwordHasNumber) passwordMessage2.innerHTML = 'Password must have at least one number.';
        else passwordMessage2.innerHTML = '';

        if(confirmPassword && enteredPassword !== confirmPassword) passwordMessage3.innerHTML = '"Password" and "Verify Password" must match.';
        else passwordMessage3.innerHTML = '';

        // disables the submit button if the password is not valid or the passwords don't match
        document.getElementById("submit-button").disabled = (!passwordMinLength || !passwordHasNumber || (enteredPassword !== confirmPassword && confirmPassword !== ''));
    }

    // attach the validate function to the input event of the createPassword input
    document.getElementById("create-password").addEventListener("input", validate);
    document.getElementById("confirm-password").addEventListener("input", validate);
});