const addToCartClick = () => {
    const menuCards = document.querySelectorAll("section.menu-container")
    for (const card of menuCards) {
        const addButton = card.querySelector("span#addButton")
        if (!addButton) break;
        addButton.addEventListener("click", async () => {
            const id_menu = card.getAttribute("id_menu")
            const data = { "id_menu": id_menu }
            const response = await fetch("../api/add_to_cart.php", {
                method: "POST",
                body: JSON.stringify(data)
            })
            console.log(await response.json())
        })

    }
    for (const card of menuCards) {
        const removeButton = card.querySelector("span#removeButton")
        if (!removeButton) break;
        removeButton.addEventListener("click", async () => {
            const id_menu = card.getAttribute("id_menu")
            const data = { "id_menu": id_menu ,"remove" :"please"}
            const response = await fetch("../api/add_to_cart.php", {
                method: "POST",
                body: JSON.stringify(data)
            })
            console.log(await response.json())
        })
    }
}
addToCartClick()


const checkoutCart  = () =>{
    const checkoutCartButton = document.querySelector("button.place-order");
    if(!checkoutCartButton) return;
    checkoutCartButton.addEventListener("click", async () => {
        const checkoutForm = document.querySelector("section.checkout-form")
        checkoutForm.innerHTML = "<p>Nothing In you Cart</p>"
        const response = await fetch("../api/checkout_cart.php");
        console.log(await response.json())

    })
}
checkoutCart()