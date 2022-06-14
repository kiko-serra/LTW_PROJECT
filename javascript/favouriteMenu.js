const menuCards = document.querySelectorAll("section.menu-container")
const id_user = document.querySelector("#user-icon").getAttribute("userId")
for (const card of menuCards) {
    const favouriteButton = card.querySelector("span.favourite-menu")
    if (!favouriteButton) break; /* User not logged in */
    const id_menu = favouriteButton.getAttribute("id_menu")
    favouriteButton.addEventListener("click", async () => {
        const data = { "id_user": id_user, "id_menu": id_menu }
        const response = await fetch("../api/toggle_favourite_menu.php",
            {
                method: "POST",
                body: JSON.stringify(data)
            }
        )
        const result = await response.json()
        if (result.removed || result.added) {
            //Pop animation
            favouriteButton.toggleAttribute("favourite")
        }
        else
            console.log(result)
    })
}