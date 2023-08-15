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

        fetch("http://localhost:80/customer/signUp",
            {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                method: "POST",
                body: JSON.stringify(signUpData)
            }
        ).then(res => {
            console.log(res);
            console.log(`Sign up successful as ${username}`);
            alert(`Sign up successful as ${username}`);
        }).catch(e => {
            console.log(e);
        })
    }
});

const signIn = (signInData) => {
    fetch("http://localhost:80/customer/signIn",
    {
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        method: "POST",
        body: JSON.stringify(signInData)
    }
    ).then(res => {
        console.log(res);
        console.log(`Sign up successful as ${username}`);
        alert(`Sign up successful as ${username}`);
    }).catch(e => {
        console.log(e);
    })
}

const signOut = () => {
    fetch("http://localhost:80/customer/signOut",
    {
        method: "GET"
    }).then(res => {
        console.log(res);
        return res;
    }).catch(e => {
        console.log(e);
    })
}

