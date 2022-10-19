const message_container = document.getElementById("message_container")
const message_content = document.getElementById("message_content")
const message_close = document.getElementById("message_close")

message_close.addEventListener("click", () => {
  message_container.classList.remove("error")
  message_container.classList.remove("success")
})

const submitForm = (user_email, user_password, authType) => {
  message_close.click()
  const url = "includes/functions.php"
  let xhr = new XMLHttpRequest()

  const params =
    authType + "=true&email=" + user_email + "&password=" + user_password

  xhr.onreadystatechange = function () {
    if (this.readyState != 4) return

    if (this.status == 200) {
      try {
        const response = JSON.parse(this.responseText)
        const values = Object.entries(response)

        if (response["redirect"] === undefined) {
          addMessage("error", authType, values[0][1], "")
          return
        }
        addMessage("success", authType, "", values[0][1])
        return
      } catch (error) {
        console.log("Error: ", error.message)
      }
    }
  }
  xhr.open("POST", url, true)
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  xhr.send(params)
}

const addMessage = (response, authType, message, redirectUrl) => {
  if (response === "error") {
    message_container.classList.add("error")
    message_content.innerHTML = message
  } else if (response === "success" && authType === "login") {
    message_container.classList.add("success")
    message_content.innerHTML = "Success!"
    redirectUser(redirectUrl)
  } else if (response === "success" && authType === "register") {
    message_container.classList.add("success")
    message_content.innerHTML = "Success! Account has been registered."
    redirectUser(redirectUrl)
  }
}

const redirectUser = async (redirectUrl) => {
  await new Promise((resolve) => setTimeout(resolve, 1000))
  window.location.href = redirectUrl
}

const userLogout = () => {
  message_close.click()
  const url = "includes/functions.php"
  let xhr = new XMLHttpRequest()
  const post_name = "logout"

  xhr.open("POST", url, true)
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  xhr.send(post_name)
  window.location.href = "./index.php"
  return
}
