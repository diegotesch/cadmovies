<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        return $this->movieService->index();
    }

    public function store(Request $request)
    {
        $movie = $this->movieService->save($request->all());
        return response()->json([
            'status' => (bool) $movie,
            'message' => $movie ? 'Movie Created' : 'Error Creating Movie']);
    }

    public function show($id)
    {
        return $this->movieService->show($id);
    }


    public function update(Request $request)
    {
        $movie = $this->movieService->save($request->all());
        return response()->json([
            'status' => (bool) $movie,
            'message' => $movie ? 'Movie Updated' : 'Error Updating Movie']);
    }

    public function destroy($id)
    {
        $this->movieService->exclude($id);
        return response()->json(null, 204);
    }
}
