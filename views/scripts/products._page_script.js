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

function findByName() {
    const element = document.getElementById("inner-container-product");
    element.innerHTML = "";
    const name = document.getElementById("search-input").value;
    console.log(name);

    const formData = new FormData();
    formData.append("product_name", name);

    fetch("http://localhost:80/index.php/product/findByName",
        {
            method: "POST",
            body: formData
        }
    ).then(res => {
        return res.json();
    })
    .then(data => {
        if(!data[0]) {
            getAllProduct();
        }
        console.log(data[0]);
        let sub = `<div class="col-md-4 product-card">
            <div class="card mb-4">
                <img class="card-img-top" src="../assets/img/product2.jpg" alt="Product 2">
                <div class="card-body">
                    <h5 class="card-title">${data[0].product_name} </h5>
                    <p class="card-text">${data[0].price} </p>
                    <p class="card-text">Quantity : ${data[0].quantity} </p>
                    <p class="card-text">Description: ${data[0].description} </p>
                    <input type="button" name='${JSON.stringify(data[0])}' class="btn btn-primary add-product" value="Add to Cart">
                </div>
            </div>  
            </div>`
        element.insertAdjacentHTML("beforeend",sub);
    })
    .catch(e => {
        console.log(e);
    })
}

//
const addToCart = (data) => {
    orderList = localStorage.getItem("orderList") ? JSON.parse(localStorage.getItem("orderList")) : [];
    orderList.push(data);
    
    localStorage.setItem("orderList", JSON.stringify(orderList));
}

//
const getAllProduct = () => {
    const element = document.getElementById("inner-container-product");
    fetch("http://localhost:80/index.php/product/list",
        {
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            method: "GET"
        }
    ).then(res => {
        return res.json();
    })
    .then(dataSet => {

        dataSet.forEach(data => {
            let sub = `<div class="col-md-4 product-card">
            <div class="card mb-4">
                <img class="card-img-top" src="../assets/img/product2.jpg" alt="Product 2">
                <div class="card-body" id="${data.product_id}">
                    <h5 class="card-title">${data.product_name} </h5>
                    <p class="card-text">${data.price} </p>
                    <p class="card-text">Quantity : ${data.quantity} </p>
                    <p class="card-text">Description: ${data.description} </p>
                    
                </div>
            </div>  
        </div>`;
            element.insertAdjacentHTML("beforeend",sub);

            var inputElement = document.createElement('input');
            inputElement.type = "button";
            inputElement.value = "Add to Cart";
            inputElement.className = "btn btn-primary add-product";
            inputElement.addEventListener('click', function(){
                addToCart(data);
            });
            
            document.getElementById(`${data.product_id}`).appendChild(inputElement);
        })
    })
    .catch(e => {
        console.log(e);
    })
}


// const getProductById = (productId) => {
//     fetch("http://localhost:80/product/findById",
//         {
//             headers: {
//                 "Accept": "application/json",
//                 "Content-Type": "form-data"
//             },
//             method: "POST",
//             body: productId
//         }
//     ).then(res => {
//         console.log(res);
//         return res;
//     }).catch(e => {
//         console.log(e);
//     });
// }