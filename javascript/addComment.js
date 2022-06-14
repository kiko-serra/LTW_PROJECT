
const buildComment = (comment) => {
    return `
    <section class="restaurant-comment" id=${comment.id}>
           <h2 class="comment-title">${comment.title}</h2>
        <p class="comment-text">
            <span class="comment-username">${comment.username}</span>
            ${comment.comment}
        </p>
        <button class="respond-to-comment" id_comment=${comment.id}>Respond</button>  
    </section>`
}

const buildAddComment = () => {
    return ` <h2> Add Comment </h2>
        <section class="add-comment-form">
            <input type="text" name="title" placeholder="Title">
            <input type= "text" name="comment" placeholder="Your Comment">
            <button class="clear-comment">Clear Comment</button>
            <button class="add-comment">Add Comment</button>
        </section>`

}

const addComment = (htmlComment) => {
    const commentsList = document.querySelector("section.restaurant-comments")
    commentsList.innerHTML += htmlComment
}

const postComment = async (data, respondingTo) => {
    if (respondingTo)
        data.id_response = respondingTo
    const response = await fetch("../api/add_comment.php", {
        method: "POST",
        body: JSON.stringify(data)
    })
    return await response.json()
}
const getCommentData = () => {
    const commentCard = document.querySelector("section.add-comment-section")
    const restaurantId = commentCard.getAttribute("id_restaurant")
    const title = commentCard.querySelector("input[name=title]").value
    const comment = commentCard.querySelector("input[name=comment]").value
    const data = { "id_restaurant": restaurantId, "title": title, "comment": comment }
    return data

}
const clearCommentData = () => {
    const commentCard = document.querySelector("section.add-comment-section")
    commentCard.querySelector("input[name=title]").value = ""
    commentCard.querySelector("input[name=comment]").value = ""

}
const addCommentClick = () => {
    const addCommentButton = document.querySelector("button.add-comment")
    addCommentButton.addEventListener("click", async () => {
        const data = getCommentData()
        const response = await postComment(data)
        addComment(buildComment(response))
    })

}
const discardComment = () => {
    const comment = document.querySelector("section.add-comment-section")
    comment.innerHTML = ""
    comment.innerHTML = buildAddComment()
    const clearcomment = document.querySelector("button.clear-comment")
    clearcomment.addEventListener("click", () => discardComment())
}

const addRespondButtonClick = () => {
    const commentsList = document.querySelector("section.restaurant-comments")
    const respondButtons = commentsList.querySelectorAll("button.respond-to-comment")
    for (const button of respondButtons)
        button.addEventListener("click", () =>
            respondButtonClick(button.getAttribute("id_comment")))
}
const postRespondToComment = async (commentId) => {
    const data = getCommentData()
    const response = await postComment(data, commentId)
    discardComment()
    addComment(buildComment(response))
    addRespondButtonClick()


}


const scrollElementIntoView = (element) => {
    element.scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" })
}

const scrollIntoComment = (commentID) => {
    const commentsList = document.querySelector("section.restaurant-comments")
    scrollElementIntoView(commentsList.querySelector("[id='" + commentID + "']"))
}

const addRespondToCommentButton = (commentCard, commentID) => {
    const oldAddcomment = commentCard.querySelector("button.add-comment")
    if (oldAddcomment) oldAddcomment.remove()
    const respondComment = commentCard.querySelector("button.respond-button")
    if (respondComment) respondComment.remove()

    const respondingTo = commentCard.querySelector("span.comment-responding-to")
    if (respondingTo)
        respondingTo.remove()

    const commentForm = commentCard.querySelector("section.add-comment-form")
    const respondButton = document.createElement("button")
    respondButton.className = "respond-button"
    respondButton.setAttribute("id_response", commentID)
    respondButton.innerText = "Respond To Comment"
    respondButton.addEventListener("click", () => postRespondToComment(commentID))

    const respondingToSpan = document.createElement("span")
    respondingToSpan.className = "comment-responding-to"
    respondingToSpan.innerText = "See Comment"
    respondingToSpan.addEventListener("click", () =>
        scrollIntoComment(commentID))

    commentForm.appendChild(respondButton)
    commentForm.appendChild(respondingToSpan)
}

const respondButtonClick = (commentId) => {
    const commentCard = document.querySelector("section.add-comment-section")
    addRespondToCommentButton(commentCard, commentId)
    scrollElementIntoView(commentCard)

}

const clearcomment = document.querySelector("button.clear-comment")
if (clearcomment)
    clearcomment.addEventListener("click", () => discardComment())



addCommentClick()
addRespondButtonClick()