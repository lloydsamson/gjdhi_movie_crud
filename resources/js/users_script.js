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
    const eachMovie = `<div class='movie-content' id='${movies[key]["movie_id"]}' onclick="viewMovie('${movies[key]["movie_id"]}')">
                                    <img src='${movies[key]["movie_img"]}' alt='${movies[key]["movie_name"]} image poster' loading='lazy'>
                                    <h4>${movies[key]["movie_name"]}</h4>
                                    <p>${movies[key]["release_date"]}</p>
                                </div>`
    htmlData += eachMovie
  })

  movie_list_container.innerHTML += htmlData
}

fetchMovies()

const viewMovie = (movie_id) => {
  window.location.href = `view_movie.php?movie_id=${movie_id}`
}
