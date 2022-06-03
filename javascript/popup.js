
const popUp = document.querySelector("#popup")
const closeButton = popUp.querySelector("button.popup-close")

closeButton.addEventListener("click",()=>{
    popUp.style.display = "none"
})
// Fade Pop up
setTimeout(() =>{
    popUp.style.display = "none"
},3* 1000)