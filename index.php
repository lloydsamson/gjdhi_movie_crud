<?php
include_once('./resources/views/layout/header.php');
?>
<main>
    <div class="form-content">
        <div class="form__content__inner">
            <h1 id="header-login-signup">Login</h1>
            <div class="message" id="message_container">
                <p id="message_content"></p>
                <div id="message_close">
                    <?php
                    include_once("resources/assets/icons/close-line.svg");
                    ?>
                </div>
            </div>

            <form onsubmit="onSubmit(event)">
                <div class="form-input">
                    <?php
                    include_once('resources/assets/icons/mail-line.svg');
                    ?>
                    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $_COOKIE['email'] ?? '' ?>">
                </div>
                <div class="form-input">
                    <?php
                    include_once('resources/assets/icons/lock-2-line.svg');
                    ?>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <input type="submit" value="Login" name="login" id="submit-btn">
            </form>
            <hr>
            <div class="form-footer">
                <p id="form-footer">Doesn't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </div>
    </div>
</main>



<script src="resources/js/script.js"></script>

<script type="text/javascript">
    const onSubmit = (event) => {
        event.preventDefault()
        const user_email = document.getElementById("email").value;
        const user_password = document.getElementById("password").value;
        const authType = "login";

        submitForm(user_email, user_password, authType)
    }
</script>
<?php
include_once('./resources/views/layout/footer.php')
?>