<?php

namespace App\Services\impl;

use App\Services\MovieService;
use App\Movie;
use App\Http\Resources\Movie as MovieResource;
use phpDocumentor\Reflection\Types\Boolean;

class MovieServiceImpl implements MovieService
{
    protected $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function index()
    {
        return MovieResource::collection(Movie::all());
    }

    public function show($id)
    {
        return new MovieResource(Movie::findOrFail($id));
    }

    public function save(Array $data)
    {
        if (!isset($data['id'])) {
            return $this->store($data);
        }
        return $this->update($data);
    }

    public function exclude($id)
    {
        $movie = Movie::findOrFail($id);
        return $movie->delete();
    }

    private function store(Array $data)
    {
        return Movie::create($data);
    }

    private function update(Array $data)
    {
        $movie = Movie::findOrFail($data['id']);
        $movie->update($data);
        return $movie;
    }
}
