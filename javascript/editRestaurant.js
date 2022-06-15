

const addRestaurantPage = document.querySelector("section.edit-restaurant-page")
const restaurantNameInput = addRestaurantPage.querySelector("input[name=name]")
const restaurantAddress = addRestaurantPage.querySelector("input[name=address]")
const restaurantReview = addRestaurantPage.querySelector("input[name=reviewScore]")
const restaurantTitle = addRestaurantPage.querySelector("input[name=title]")
const photoInput = addRestaurantPage.querySelector("input[type=file]")
const addrestaurantButton = addRestaurantPage.querySelector("button.alterRestaurant")

addrestaurantButton.addEventListener("click", async () => {
    // Needs to be parsed and checked
    const name = restaurantNameInput.value
    const address = restaurantAddress.value
    const reviewScore = restaurantReview.value
    const title = restaurantTitle.value
    const id_restaurant = document.querySelector("input[name=id]").getAttribute("value")

    const formData = new FormData()
    if (!photoInput.files[0]) {
        return console.log("No photo")
    }
    formData.append("image", photoInput.files[0])
    const imgResponse = await fetch("../api/upload_image.php", {
        method: "POST",
        body: formData
    })
    const status = await imgResponse.json()
    const p_id = status.id
    console.log(status)
    if (!p_id)
        return console.log(status)

    const categories =[]
    const allCategories = document.querySelectorAll("section.categories article")
    for(const category of allCategories){
        if(category.hasAttribute("selected"))
            categories.push(category.getAttribute("category-id"))

    }
    const post = {
        "id": id_restaurant,
        "name": name,
        "address": address,
        "categories": categories,
        "title": title,
        "reviewScore": reviewScore,
        "p_id": p_id,
    }
    console.log(post)

    const restaurantResponse = await fetch("../api/edit_restaurant.php", { method: "POST", body: JSON.stringify(post) })
    const restaurantStatus = await restaurantResponse.json()
    console.log(restaurantStatus)

})