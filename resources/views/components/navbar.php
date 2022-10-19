
<nav>
    <div>
        <h3><?php echo $_SESSION['email'] ?></h3>
        <div id="logout" onclick="userLogout()">
            <?php include_once('./resources/assets/icons/logout-box-line.svg') ?>
        </div>
    </div>
</nav>