<?php

include_once('./resources/views/layout/header.php');

if ($_SESSION['user_role'] != "user") {
    header("Location: index.php");
    session_destroy();
    exit();
}
include_once('./resources/views/components/navbar.php');
include_once('./resources/views/layout/view_movie_content.php');
?>

<?php
include_once('./resources/views/layout/footer.php');
?>