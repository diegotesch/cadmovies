<?php
namespace App\Services;

use App\Movie;

interface MovieService
{
    public function __construct(Movie $movie);
    public function index();
    public function show($id);
    public function save(Array $data);
    public function exclude($id);
}
