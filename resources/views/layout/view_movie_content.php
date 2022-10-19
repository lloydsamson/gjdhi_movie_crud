<main class="view-movie-container">
    <div class="view-movie-content">
        <div class="view-movie-image">
            <img src="" alt="" id="movie-poster" class="movie-poster">
        </div>
        <div class="view-movie-details">
            <h1 class="movie-title" id="movie-title">Movie Title</h1>
            <p class="movie-date" id="movie-release-date">Release Date: 01/02/2000</p>
            <div class="movie-overview">
                <h4 class="movie-overview-label">Overview</h4>
                <p class="movie-overview-p" id="movie-overview">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae officiis maxime, voluptas fugit autem reiciendis! A laudantium quae ut harum quidem architecto voluptate minus reprehenderit laborum molestias, maiores ab rem?
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempora debitis dicta veritatis animi, possimus quaerat expedita. Dicta vero quae facere modi, provident ipsum minus aliquam laudantium, sequi repudiandae, odit vitae.
                </p>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString)
    const movie_id = urlParams.get("movie_id")

    const fetchMovieDetail = () => {
        const post_name = "getMovieData"

        const url = "includes/functions.php"
        let xhr = new XMLHttpRequest()

        const params = post_name + "=true&movie_id=" + movie_id

        xhr.onreadystatechange = function() {
            if (this.readyState != 4) return

            if (this.status == 200) {
                try {
                    const response = JSON.parse(this.responseText)
                    if (response["error"]) {
                        bindError();
                        return
                    }
                    bindToMovieData(response)
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

    fetchMovieDetail()
    const movie_name = document.getElementById("movie-title")
    const movie_img = document.getElementById("movie-poster")
    const movie_date = document.getElementById("movie-release-date")
    const movie_overview = document.getElementById("movie-overview")

    const bindToMovieData = (movie_data) => {
        movie_name.innerText = movie_data["movie_name"]
        movie_img.setAttribute("src", movie_data['movie_img'])
        movie_date.innerText = `Release Date: ${movie_data['release_date']}`
        movie_overview.innerText = movie_data["overview"]
    }

    const bindError = () => {
        movie_name.innerText = "Error 404 content not found";
        movie_date.innerText = "Content not found"
        movie_overview.innerText = "Error 404 cause by unknown movie id"
    }
</script>