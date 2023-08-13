document.addEventListener("DOMContentLoaded", function () {
    const signUpForm = document.querySelector("#sign-up-form");
    signUpForm.addEventListener("submit", handleSignUp);

    async function handleSignUp(event) {
        event.preventDefault();

        const username = document.getElementById("username").value;
        const email = document.getElementById("email").value;
        const address = document.getElementById("address").value;
        const phoneNumber = document.getElementById("phone").value;
        const password = document.getElementById("password").value;

        const signUpData = {
            username,
            email,
            address,
            phoneNumber,
            password
        };

        alert(`Sign up successful as ${username}`);

    }
});

