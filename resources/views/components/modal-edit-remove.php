<div class="modal " id="modal-view">
    <div class="inner-modal">
        <div class="modal-close" id="modal-view-close">
            <?php
            include("resources/assets/icons/close-line.svg");
            ?>
        </div>
        <div class="message  message-modal" id="message_modal_edit_remove">
            <p id="message_modal_content_edit_remove"></p>
            <div id="message_modal_close_edit_remove">
                <?php
                include_once("resources/assets/icons/close-line.svg");
                ?>
            </div>
        </div>
        <form onsubmit="editMovie(event)">
            <div class="form-input-modal">
                <label for="movie_edit_name">Movie Name*</label>
                <input type="text" id="movie_edit_name" name="movie_edit_name" placeholder="Name" />
            </div>
            <div class="form-input-modal">
                <label for="movie_edit_img">Movie Image Link*</label>
                <input type="url" id="movie_edit_img" name="movie_edit_img" placeholder="https://www.getimages.com" />
            </div>
            <div class="form-input-modal">
                <label for="movie_edit_date">Movie Release Date*</label>
                <input type="date" id="movie_edit_date" name="movie_edit_date" />
            </div>
            <div class="form-input-modal">
                <label for="movie_edit_overview">Overview*</label>
                <textarea name="movie_edit_overview" id="movie_edit_overview" rows="5" placeholder="Movie overview"></textarea>
            </div>
            <div class="form-input-modal">
                <input type="submit" class="btn btn-primary" value="Update Movie" />
            </div>
            <div class="form-input-modal">
                <input type="button" class="btn btn-remove" value="Delete Movie" onclick="deleteMovieModal()"/>
            </div>
        </form>
    </div>
</div>