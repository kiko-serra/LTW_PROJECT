

const menuCards = document.querySelectorAll("section.menu-container")
const id_user = document.querySelector("#user-icon").getAttribute("id")
for (const card of menuCards) {
    const favouriteButton = card.querySelector("button.favourite-menu")
    const id_menu = card.getAttribute("id_menu")
    favouriteButton.addEventListener("click", async () => {
        const data = { "id_user": id_user, "id_menu": id_menu }
        const response = await fetch("../api/toggle_favourite_menu.php",
            {
                method: "POST",
                body: JSON.stringify(data)
            }
        )
        const result = await response.json()
        if(result.removed){
            //Pop animation
            favouriteButton.style.backgroundColor ="black"
        }
        else if(result.added){
            // Fill animation
            favouriteButton.style.backgroundColor ="black"
        }
        else
            console.log(response)

    })
}