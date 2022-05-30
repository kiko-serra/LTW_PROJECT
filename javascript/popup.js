
const popUp = document.querySelector("#popup")
const closeButton = popUp.querySelector("button.popup-close")

closeButton.addEventListener("click",()=>{
    popUp.style.display = "none"
})