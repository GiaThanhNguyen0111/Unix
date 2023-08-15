document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const productCards = document.querySelectorAll(".product-card");

    searchInput.addEventListener("input", function () {
        const searchText = searchInput.value.toLowerCase();

        productCards.forEach(function (card) {
            const productName = card.querySelector(".card-title").textContent.toLowerCase();

            if (productName.includes(searchText)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});


const getAllProduct = () => {
    fetch("http://localhost:80/product/list",
        {
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            method: "GET"
        }
    ).then(res => {
        console.log(res);
        return res;
    }).catch(e => {
        console.log(e);
    })
}

const getProductByStoreName = (storeName) => {
    fetch("http://localhost:80/product/findByStoreName",
        {
            headers: {
                "Accept": "application/json",
                "Content-Type": "form-data"
            },
            method: "POST",
            body: storeName
        }
    ).then(res => {
        console.log(res);
        return res;
    }).catch(e => {
        console.log(e);
    })
}

const getProductById = (productId) => {
    fetch("http://localhost:80/product/findById",
        {
            headers: {
                "Accept": "application/json",
                "Content-Type": "form-data"
            },
            method: "POST",
            body: productId
        }
    ).then(res => {
        console.log(res);
        return res;
    }).catch(e => {
        console.log(e);
    });
}