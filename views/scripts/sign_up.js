const handleClick = () => {
        const username = document.getElementById("username").value;
        const email = document.getElementById("email").value;
        const address = document.getElementById("address").value;
        const phoneNumber = document.getElementById("phone").value;
        const password = document.getElementById("password").value;
        console.log(username);
        const formData = new FormData();
        formData.append("username", username);
        formData.append("email", email);
        formData.append("address", address);
        formData.append("phoneNumber", phoneNumber);
        formData.append("password", password);

        fetch("http://localhost:80/index.php/customer/signUp",
            {
                method: "POST",
                body: formData
            }
        ).then(res => {
            return res.json();
            //redirect to product pages.
        }).then(
            result => {
                console.log(result);
                console.log(`Sign up successful as ${username}`);
                alert(`Sign up successful as ${username}`);
                if (result.isLoggedIn === true) {
                    window.location.replace("http://localhost:80/views/pages/index.html");
                }
            }
        ).catch(e => {
            console.log(e);
        })
}

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

