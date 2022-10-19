<?php
require_once('./MovieController.php');
require('throw_403.php');

class MovieValidator{

    private $data;
    private $errors = [];
    private static $fields = ['movie_name', 'movie_img', 'movie_date', 'movie_overview'];

    public function __construct($post_data)
    {
        $this->data = $post_data;
    }

    public function addMovie()
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field is not present in the data");
                return;
            }
        }

        $this->validateFields();
        $this->checkIfValidUser();

        if (empty($this->errors)) {
            $movie = new MovieController($this->data);
            $movie->addMovie();
            return array('success' => "true");
        }

        return $this->errors;
    }

    public function updateMovie(){
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field is not present in the data");
                return;
            }
        }

        $this->validateFields();
        $this->checkIfValidUser();

        if (empty($this->errors)) {
            $movie = new MovieController($this->data);
            $movie->updateMovie();
            return array('success' => "true");
        }

        return $this->errors;
    }

    public function deleteMovie(){
        $this->checkIfValidUser();

        if (empty($this->errors)) {
            $movie = new MovieController($this->data);
            $movie->deleteMovie();
            return array('success' => "true");
        }

        return $this->errors;
    }


    private function validateFields()
    {
        $movie_name = trim($this->data['movie_name']);
        $movie_img = trim($this->data['movie_img']);
        $movie_date = trim($this->data['movie_date']);
        $movie_overview = trim($this->data['movie_overview']);

        if (empty($movie_name)) {
            $this->addError('movie_name_error', 'Movie Name cannot be empty.');
            return;
        }

        if (empty($movie_img)) {
            $this->addError('movie_img_error', 'Movie Image URL cannot be empty.');
            return;
        } else {
            if (!filter_var($movie_img, FILTER_VALIDATE_URL)) {
                $this->addError('movie_img_error', 'Invalid URL');
                return;
            }
            //if the link content type is not an image
            $headers = @get_headers($movie_img, 1);
            if (strpos($headers['Content-Type'], 'image/') === false) {
                $this->addError('movie_img_error', "The content type of the URL is not image");
                return;
            }
        }

        if (empty($movie_date)) {
            $this->addError('movie_date_error', 'Movie release date cannot be empty.');
            return;
        } else {
            if (!strtotime($movie_date)) {
                $this->addError('movie_date_error', 'Invalid movie release date');
                return;
            }
        }

        if (empty($movie_overview)) {
            $this->addError('movie_overview_error', 'Movie overview cannot be empty.');
            return;
        }
    }

    private function checkIfValidUser(){
        if($_SESSION['user_role'] !== "admin"){
            $this->addError('role_error', 'You cannot add/edit/update the movie!');
        }
    }

    private function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }
}