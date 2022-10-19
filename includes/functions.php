<?php 
session_start();
require('UserValidator.php');
require('MovieController.php');
require('MovieValidator.php');
require('throw_403.php');

if (array_key_exists('login', $_POST) ) {
    $validation = new UserValidator($_POST);
    $errors = $validation->validateLogin();

    setcookie("email", $_POST['email'], time() + (86400 * 30), "/"); // 86400 = 1 day
    echo json_encode($errors);
}


if (array_key_exists('register', $_POST)) {
    $validation = new UserValidator($_POST);
    $errors = $validation->validateRegister();

    setcookie("email", $_POST['email'], time() + (86400 * 30), "/"); // 86400 = 1 day
    echo json_encode($errors);
} 

if(array_key_exists('fetchData', $_POST)){

    $movies = new MovieController($_POST);
    $movie = $movies->getAllMovies();

    echo json_encode($movie);
}


if (array_key_exists('add_movie', $_POST)) {
    $movies = new MovieValidator($_POST);
    $errors = $movies->addMovie();

    echo json_encode($errors);
}

if (array_key_exists('getMovieData', $_POST)) {
    $movies = new MovieController($_POST);
    $movie = $movies->getMovieData();

    echo json_encode($movie);
}

if (array_key_exists('update_movie', $_POST)) {
    $movies = new MovieValidator($_POST);
    $errors = $movies->updateMovie();

    echo json_encode($errors);
}

if (array_key_exists('delete_movie', $_POST)) {
    $movies = new MovieValidator($_POST);
    $errors = $movies->deleteMovie();

    echo json_encode($errors);
}


if (array_key_exists('logout', $_POST)) {
    session_destroy();
    return array('success' => "true");

}
