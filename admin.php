<?php

include_once('./resources/views/layout/header.php');

if ($_SESSION['user_role'] != "admin") {
    header("Location: index.php");
    session_destroy();
    exit();
}
include_once('./resources/views/components/modal-add.php');
include_once('./resources/views/components/modal-edit-remove.php');
include_once('./resources/views/components/modal-remove-confirmation.php');
include_once('./resources/views/components/navbar.php');
include_once('./resources/views/layout/admin_content.php');
?>

<script src="resources/js/script.js"></script>
<script src="resources/js/admin_script.js"></script>
<?php
include_once('./resources/views/layout/footer.php');

?>