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
