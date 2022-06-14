

const addCommentClick = () => {
    const addCommentButton = document.querySelector("button.add-comment")
    addCommentButton.addEventListener("click", async () => {
        const commentCard = document.querySelector("section.add-comment-section")
        const restaurantId = commentCard.getAttribute("id_restaurant")
        const title = commentCard.querySelector("input[name=title]").value
        const comment = commentCard.querySelector("input[name=comment]").value

        const data = { "id_restaurant": restaurantId, "title": title, "comment": comment }
        const response = await fetch("../api/add_comment.php", {
            method: "POST",
            body: JSON.stringify(data)
        })
        console.log(await response.json())
    })

}

addCommentClick()