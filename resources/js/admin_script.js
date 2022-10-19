//add movie modal
const add_movie_btn = document.getElementById("add-movie")
const modal_add_container = document.getElementById("modal-add")
const modal_add_movie_close = document.getElementById("modal-add-close")

const message_modal_container = document.getElementById("message_modal")
const message_modal_content = document.getElementById("message_modal_content")
const message_modal_close = document.getElementById("message_modal_close")

const message_modal_container_edit_remove = document.getElementById(
  "message_modal_edit_remove"
)
const message_modal_content_edit_remove = document.getElementById(
  "message_modal_content_edit_remove"
)
const message_modal_close_edit_remove = document.getElementById(
  "message_modal_close_edit_remove"
)

message_modal_container.addEventListener("click", () => {
  alert()
})

const fetchMovies = () => {
  const url = "includes/functions.php"
  let xhr = new XMLHttpRequest()

  const params = "fetchData"
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        const response = JSON.parse(this.responseText)
        populateMovies(response)
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

const populateMovies = (movies) => {
  const movie_list_container = document.getElementById("movie-list")
  movie_list_container.innerHTML = ""
  let htmlData = ""
  Object.keys(movies).forEach((key) => {
    const eachMovie = `<div class='movie-content' id='${movies[key]["movie_id"]}' onclick="showMovieModal('${movies[key]["movie_id"]}')">
                                    <img src='${movies[key]["movie_img"]}' alt='${movies[key]["movie_name"]} image poster' loading='lazy'>
                                    <h4>${movies[key]["movie_name"]}</h4>
                                    <p>${movies[key]["release_date"]}</p>
                                </div>`
    htmlData += eachMovie
  })

  movie_list_container.innerHTML += htmlData
}

fetchMovies()

add_movie_btn.addEventListener("click", () => {
  modal_add_container.classList.add("show")
  document.getElementById("body").style.overflow = "hidden"
})

modal_add_movie_close.addEventListener("click", () => {
  modal_add_container.classList.remove("show")
  document.getElementById("body").style.overflow = "auto"
  clearModalContent()
})

const addMovie = (event) => {
  event.preventDefault()
  const movie_name = document.getElementById("movie_name").value
  const movie_img = document.getElementById("movie_img").value
  const movie_release_date = document.getElementById("movie_date").value
  const movie_overview = document.getElementById("movie_overview").value
  const post_name = "add_movie"

  const url = "includes/functions.php"
  let xhr = new XMLHttpRequest()

  const params =
    post_name +
    "=true&movie_name=" +
    movie_name +
    "&movie_img=" +
    movie_img +
    "&movie_date=" +
    movie_release_date +
    "&movie_overview=" +
    movie_overview

  xhr.onreadystatechange = function () {
    if (this.readyState != 4) return

    if (this.status == 200) {
      try {
        const response = JSON.parse(this.responseText)
        const values = Object.entries(response)
        if (response["success"] === undefined) {
          modalMessage("error", values[0][1])
          return
        }
        modalMessage("success", "Movie added!")
        return
      } catch (error) {
        console.log("Error: ", error.message)
      }
    }
  }
  console.log(xhr)
  xhr.open("POST", url, true)
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  xhr.send(params)
}

const modalMessage = async (response, message) => {
  if (response === "error") {
    message_modal_container.classList.add("error")
    message_modal_container_edit_remove.classList.add("error")
    message_modal_content.innerHTML = message
    message_modal_content_edit_remove.innerHTML = message
  } else if (response === "success") {
    message_modal_container.classList.add("success")
    message_modal_container_edit_remove.classList.add("success")
    message_modal_content.innerHTML = message
    message_modal_content_edit_remove.innerHTML = message
    fetchMovies()
    await new Promise((resolve) => setTimeout(resolve, 1000))
    clearModalContent()
  }
}

const clearModalContent = () => {
  modal_add_movie_close.click()
  modal_view_movie_close.click()
  document.getElementById("movie_name").value = ""
  document.getElementById("movie_img").value = ""
  document.getElementById("movie_date").value = ""
  document.getElementById("movie_overview").value = ""
  message_modal_container.classList.remove("error")
  message_modal_container.classList.remove("success")
  message_modal_container_edit_remove.classList.remove("error")
  message_modal_container_edit_remove.classList.remove("success")
}
const showMovieModal = (id) => {
  window.scrollTo(0, 0)

  const movie_id = id

  const post_name = "getMovieData"

  const url = "includes/functions.php"
  let xhr = new XMLHttpRequest()

  const params = post_name + "=true&movie_id=" + movie_id

  xhr.onreadystatechange = function () {
    if (this.readyState != 4) return

    if (this.status == 200) {
      try {
        const response = JSON.parse(this.responseText)

        bindToMovieModal(response)
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

const modal_view_container = document.getElementById("modal-view")
const modal_view_movie_close = document.getElementById("modal-view-close")
const modal_movie_name = document.getElementById("movie_edit_name")
const modal_movie_img = document.getElementById("movie_edit_img")
const modal_movie_date = document.getElementById("movie_edit_date")
const modal_movie_overview = document.getElementById("movie_edit_overview")
let movie_id = ""

const bindToMovieModal = (movie_data) => {
  modal_movie_name.value = movie_data["movie_name"]
  modal_movie_img.value = movie_data["movie_img"]
  let release_date = new Date(movie_data["release_date"])
    .toISOString()
    .split("T")[0]
  modal_movie_date.value = release_date
  modal_movie_overview.value = movie_data["overview"]
  movie_id = movie_data["movie_id"]
  modal_view_container.classList.add("show")
  document.getElementById("body").style.overflow = "hidden"
}

modal_view_movie_close.addEventListener("click", () => {
  modal_view_container.classList.remove("show")
  document.getElementById("body").style.overflow = "auto"
  clearModalContent()
})

const editMovie = (event) => {
  event.preventDefault()

  const post_name = "update_movie"

  const url = "includes/functions.php"
  let xhr = new XMLHttpRequest()

  const params =
    post_name +
    "=true&movie_name=" +
    modal_movie_name.value +
    "&movie_img=" +
    modal_movie_img.value +
    "&movie_date=" +
    modal_movie_date.value +
    "&movie_overview=" +
    modal_movie_overview.value +
    "&movie_id=" +
    movie_id

  xhr.onreadystatechange = function () {
    if (this.readyState != 4) return

    if (this.status == 200) {
      try {
        const response = JSON.parse(this.responseText)
        const values = Object.entries(response)
        if (response["success"] === undefined) {
          modalMessage("error", values[0][1])
          return
        }
        modalMessage("success", "Movie updated!")
        return
      } catch (error) {
        console.log("Error: ", error.message)
      }
    }
  }
  console.log(xhr)
  xhr.open("POST", url, true)
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  xhr.send(params)
}

const modal_view_confirm_container = document.getElementById(
  "modal-remove-confirm"
)
const modal_view_confirm_close = document.getElementById(
  "modal-remove-confirm-close"
)
const modal_view_confirmation_cancel_delete =
  document.getElementById("cancel_delete")

const deleteMovieModal = () => {
  const confirmation_message = document.getElementById(
    "confirmation_delete_message"
  )
  const confirmation_message_final = `Do you want to delete ${modal_movie_name.value}?`
  confirmation_message.innerHTML = confirmation_message_final
  modal_view_confirm_container.classList.add("show")
}

modal_view_confirmation_cancel_delete.addEventListener("click", () => {
  modal_view_confirm_container.classList.remove("show")
})
modal_view_confirm_close.addEventListener("click", () => {
  modal_view_confirm_container.classList.remove("show")
  clearModalContent()
})

const deleteThisMovie = () => {
  const post_name = "delete_movie"

  const url = "includes/functions.php"
  let xhr = new XMLHttpRequest()

  const params = post_name + "=true&movie_id=" + movie_id

  xhr.onreadystatechange = function () {
    if (this.readyState != 4) return

    if (this.status == 200) {
      try {
        const response = JSON.parse(this.responseText)
        if (response["success"] === undefined) {
          // error
        }
        modal_view_confirm_close.click()
        fetchMovies()
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
