
const buildComment = (comment) => {
    return `
    <section class="restaurant-comment" id=${comment.id}>
           <h2 class="comment-title">${comment.title}</h2>
        <p class="comment-text">
            <span class="comment-username">${comment.username}</span>
            ${comment.comment}
        </p>
    </section>`
}

const addComment = (htmlComment) => {
    const commentsList = document.querySelector("section.restaurant-comments")
    commentsList.innerHTML += htmlComment
}

const addCommentClick = () => {
    const addCommentButton = document.querySelector("button.add-comment")
    addCommentButton.addEventListener("click", async () => {
        const commentCard = document.querySelector("section.add-comment-section")
        const restaurantId = commentCard.getAttribute("id_restaurant")
        const title = commentCard.querySelector("input[name=title]").value
        const comment = commentCard.querySelector("input[name=comment]").value
        commentCard.querySelector("input[name=title]").value = ""
        commentCard.querySelector("input[name=comment]").value = ""
        const data = { "id_restaurant": restaurantId, "title": title, "comment": comment }
        const response = await fetch("../api/add_comment.php", {
            method: "POST",
            body: JSON.stringify(data)
        })
        const commentResult = await response.json()
        addComment(buildComment(commentResult))
    })

}

addCommentClick()