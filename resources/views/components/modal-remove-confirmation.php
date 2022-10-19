<div class="modal " id="modal-remove-confirm">
    <div class="inner-modal">
        <div class="modal-close" id="modal-remove-confirm-close">
            <?php
            include("resources/assets/icons/close-line.svg");
            ?>
        </div>
        <form onsubmit="addMovie(event)">
            <h1 id="confirmation_delete_message"></h1>
            <div class="form-button-modal">
                <input type="button" class="btn btn-remove" id="cancel_delete" name="cancel_delete" value="Cancel" />
                <input type="button" class="btn btn-primary" id="confirm_delete" name="confirm_delete" value="Delete" onclick="deleteThisMovie()" />
            </div>
        </form>
    </div>
</div>