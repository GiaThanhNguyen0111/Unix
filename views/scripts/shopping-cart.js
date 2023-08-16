const calcTotal = () => {
    const orderList = localStorage.getItem("orderList") ? JSON.parse(localStorage.getItem("orderList")) : [];

    total = 0;
    orderList.forEach(order => {
        total += Number(document.getElementById(`subtotal-${order.product_id}`).innerHTML);
    })

    document.getElementById("total").innerHTML = "Total: VND " + total;
    return total;
};

const calcSubTotal = () => {
    orderList = localStorage.getItem("orderList") ? JSON.parse(localStorage.getItem("orderList")) : [];

    
    orderList.forEach(order => {
        total = 0;
        total += (Number(document.getElementById(`subtotal-${order.product_id}`)) * Number(document.getElementById(`qty-${order.product_id}`).value));
        document.getElementById(`subtotal-${order.product_id}`).innerHTML = total;
    })
}

const getCart = () => {
    const element = document.getElementById("table-body");
    const orderList = localStorage.getItem("orderList") ? JSON.parse(localStorage.getItem("orderList")) : [];

    orderList.forEach(order => {
        let el = ` <tr>
                        <td>${order.product_name}</td>
                        <td>${order.price}</td>
                        <td id="value-txt">
                        <input type="number" id="qty-${order.product_id}" value="1" class="form-control">
                        </td>
                        <td id="subtotal-${order.product_id}">${order.price}</td>
                    </tr>`
        element.insertAdjacentHTML("beforeend",el);

        // var inputElement = document.createElement('input');
        //     inputElement.type = "button";
        //     inputElement.value = "Add to Cart";
        //     inputElement.className = "btn btn-primary add-product";
        //     inputElement.addEventListener('click', function(){
        //         addToCart(data);
        //     });
            
        //     document.getElementById(`${data.product_id}`).appendChild(inputElement);
    });

    calcTotal();
};

const checkOut = () => {
    const orderList = localStorage.getItem("orderList") ? JSON.parse(localStorage.getItem("orderList")) : [];
    const formData = new FormData();
    const customerId = localStorage.getItem("customerId");
    
    const listOfProduct = "[" + orderList.forEach(order=> {
        jsonStr = `
            {
                "${order.product_id}": ${document.getElementById(`qty-${order.product_id}`)}
            }
        ` 
    }) + "]";


    formData.append("customer_id", customerId);
    formData.append("list_of_product", listOfProduct);
    formData.append("total_amount", calcTotal());

    fetch("http://localhost:80/index.php/order/createOrder",
        {
            method: "POST",
            body: formData        
        }
    ).then(res => {
        return res.json();
    }).then(result => {
        console.log(result);
        alert("Your order is on the way now!");
    }).catch(e => {
        console.log(e);
    })
}