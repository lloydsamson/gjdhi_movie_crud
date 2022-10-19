<?php

include_once('./resources/views/layout/header.php');

if ($_SESSION['user_role'] != "user") {
    header("Location: index.php");
    session_destroy();
    exit();
}
include_once('./resources/views/components/navbar.php');
include_once('./resources/views/layout/user_content.php');
?>

<script src="resources/js/script.js"></script>
<script src="resources/js/users_script.js"></script>
<?php
include_once('./resources/views/layout/footer.php');

?>