const favouriteButton = document.querySelector("span.favourite-restaurant")
if (favouriteButton) {
    const id_restaurant = card.getAttribute("id_restaurant")
    favouriteButton.addEventListener("click", async () => {
        const data = { "id_restaurant": id_restaurant }
        const response = await fetch("../api/toggle_favourite_restaurant.php",
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