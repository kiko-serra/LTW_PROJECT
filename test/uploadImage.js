
// Create form data send it in post via fetch

const uploadImageButton = document.querySelector("#upload-image")
const imageInput = document.querySelector("input.form-control")
uploadImageButton.addEventListener("click",async()=>{
    const form = new FormData()
    const file = imageInput.files[0]
    form.append("image",file)
    const url = "../api/upload_image.php"

    const response =  await fetch(url,{
        method: "POST",
        body:form
    })
    console.log(await response.json())

})