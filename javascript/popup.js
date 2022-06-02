
const popUp = document.querySelector("#popup")
const closeButton = popUp.querySelector("button.popup-close")

const closePopUp = () => {
    popUp.removeAttribute("opening")
    popUp.setAttribute("closing", "")

    popUp.addEventListener(
        "animationend",
        () => {
            popUp.removeAttribute("closing");
            popUp.classList.add("closed");
        },
        { once: true })
}

closeButton.addEventListener("click", closePopUp)

setTimeout(closePopUp, 3 * 1000)
