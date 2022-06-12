
const addMenuPage = document.querySelector("section.add-menu-page")
const menuNameInput = addMenuPage.querySelector("input[name=name]")
const menuDescription = addMenuPage.querySelector("input[name=description]")
const menuPrice = addMenuPage.querySelector("input[name=price]")
const photoInput = addMenuPage.querySelector("input[type=file]")
const addMenuButton = addMenuPage.querySelector("button.add-menu")

addMenuButton.addEventListener("click", async () => {
    // Needs to be parsed and checked
    const name = menuNameInput.value
    const r_id = addMenuPage.getAttribute("restaurant-id")
    const type = addMenuPage.getAttribute("menu-type")
    const price = menuPrice.value
    const description = menuDescription.value
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
        "r_id": r_id,
        "type": type,
        "description": description,
        "p_id": p_id,
        "price":price
    }
    const menuResponse = await fetch("../api/add_menu.php",{method:"POST",body:JSON.stringify(post)})
    const menuStatus = await menuResponse.json()
    if(menuStatus.success){
        history.back()
    }
})
