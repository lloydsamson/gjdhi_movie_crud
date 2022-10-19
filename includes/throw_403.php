<?php


if (!isset($_SERVER['HTTP_REFERER'])) {
    // redirect them to your desired location
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location: ../resources/views/layout/error_403.php'));
}