<?php
require('throw_403.php');

class MovieController{

    private $data;
    private $link_data_file;
    private $get_data_file;
    private $decoded_data_file;
   

    public function __construct($post_data)
    {
        $this->data = $post_data;
        $this->link_data_file = '../data/movies.json';
        $this->get_data_file = file_get_contents($this->link_data_file);
        $this->decoded_data_file = json_decode($this->get_data_file, true);
    }

    public function getAllMovies(){
        return $this->decoded_data_file;
    }

    public function addMovie(){

        $this->decoded_data_file[] = array(
            'movie_id' => uniqid(),
            'movie_name' => $this->data['movie_name'],
            'movie_img' => $this->data['movie_img'],
            'overview' => $this->data['movie_overview'],
            'release_date' => $this->data['movie_date']
        );
        file_put_contents($this->link_data_file, json_encode($this->decoded_data_file));
    }
   
    public function getMovieData () {
        $movie_id = $this->data['movie_id'];

        foreach ($this->decoded_data_file as $movie) {
            if ($movie['movie_id'] == $movie_id) return $movie;
        }
       return array("error"=>"movie not found");
    }

    public function updateMovie(){
        $movie_id = $this->data['movie_id'];

        foreach ($this->decoded_data_file as $key => $movie) {
            if ($movie['movie_id'] == $movie_id) {
                $this->decoded_data_file[$key]['movie_name'] = $this->data['movie_name'];
                $this->decoded_data_file[$key]['movie_img'] = $this->data['movie_img'];
                $this->decoded_data_file[$key]['overview'] = $this->data['movie_overview'];
                $this->decoded_data_file[$key]['release_date'] = $this->data['movie_date'];
            }
        }


        file_put_contents($this->link_data_file, json_encode($this->decoded_data_file));
        return;
    }

    public function deleteMovie(){
        $movie_id = $this->data['movie_id'];

        // get array index to delete
        $arr_index = array();
        foreach ($this->decoded_data_file as $key => $movie) {
            if ($movie['movie_id'] === $movie_id) {
                $arr_index[] = $key;
            }
        }

        foreach ($arr_index as $i) {
            unset($this->decoded_data_file[$i]);
        }

        // rebase array
        $this->decoded_data_file = array_values($this->decoded_data_file);
        file_put_contents($this->link_data_file, json_encode($this->decoded_data_file));
        return;
    }
}
