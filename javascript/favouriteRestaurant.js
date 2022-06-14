const favouriteRestaurant = document.querySelector("section#restaurant.favourite-button-container ")
if (favouriteRestaurant) {
    const id_restaurant = favouriteRestaurant.getAttribute("id_restaurant")
    const favouriteButton = favouriteRestaurant.querySelector("span.favourite-menu")
    favouriteButton.addEventListener("click", async () => {
        console.log(id_restaurant)
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