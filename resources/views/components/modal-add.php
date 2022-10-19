<div class="modal " id="modal-add">
    <div class="inner-modal">
        <div class="modal-close" id="modal-add-close">
            <?php
            include_once("resources/assets/icons/close-line.svg");
            ?>
        </div>
        <div class="message  message-modal" id="message_modal">
            <p id="message_modal_content"></p>
            <div id="message_modal_close">
                <?php
                include_once("resources/assets/icons/close-line.svg");
                ?>
            </div>
        </div>
        <form onsubmit="addMovie(event)">
            <div class="form-input-modal">
                <label for="movie_name">Movie Name*</label>
                <input type="text" id="movie_name" name="movie_name" placeholder="Name" />
            </div>
            <div class="form-input-modal">
                <label for="movie_img">Movie Image Link*</label>
                <input type="url" id="movie_img" name="movie_img" placeholder="https://www.getimages.com" />
            </div>
            <div class="form-input-modal">
                <label for="movie_date">Movie Release Date*</label>
                <input type="date" id="movie_date" name="movie_date" />
            </div>
            <div class="form-input-modal">
                <label for="movie_overview">Overview*</label>
                <!-- <input type="text" id="movie_overview" name="movie_overview" placeholder="Overview" /> -->
                <textarea name="movie_overview" id="movie_overview" rows="5" placeholder="Movie overview"></textarea>
            </div>
            <div class="form-input-modal">
                <input type="submit" class="btn btn-primary" value="Add Movie" />
            </div>
        </form>
    </div>
</div>