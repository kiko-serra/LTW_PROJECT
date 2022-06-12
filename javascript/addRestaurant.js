
const addRestaurantPage = document.querySelector("section.add-restaurant-page")
const restaurantNameInput = addRestaurantPage.querySelector("input[name=name]")
const restaurantAddress = addRestaurantPage.querySelector("input[name=address]")
const restaurantCategory = addRestaurantPage.querySelector("input[name=category]")
const restaurantReview = addRestaurantPage.querySelector("input[name=reviewScore]")
const restaurantTitle = addRestaurantPage.querySelector("input[name=title]")
const photoInput = addRestaurantPage.querySelector("input[type=file]")
const addrestaurantButton = addRestaurantPage.querySelector("button.add-restaurant")

addrestaurantButton.addEventListener("click", async () => {
    // Needs to be parsed and checked
    const name = restaurantNameInput.value
    const address = restaurantAddress.value
    const category = restaurantCategory.value
    const reviewScore = restaurantReview.value
    const title = restaurantTitle.value

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

    const post = {
        "name": name,
        "address": address,
        "category": category,
        "title": title,
        "reviewScore": reviewScore,
        "p_id": p_id,
    }
    console.log(post)
    const restaurantResponse = await fetch("../api/add_restaurant.php", { method: "POST", body: JSON.stringify(post) })
    const restaurantStatus = await restaurantResponse.json()
    if (restaurantStatus.restaurant) {
        window.location.href = restaurantStatus.restaurant
    }
    else {
        console.log("SO needs my shield")
    }
    console.log(restaurantStatus)

})