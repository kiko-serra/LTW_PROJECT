const addToCartClick =  () =>{
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
}
addToCartClick()