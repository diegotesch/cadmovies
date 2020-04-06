<?php

namespace App\Http\Controllers;

use App\Services\CastService;
use Illuminate\Http\Request;

class CastController extends Controller
{
    protected $castService;

    public function __construct(CastService $castService)
    {
      $this->castService = $castService;
    }

    public function index()
    {
        return $this->castService->index();
    }

    public function store(Request $request)
    {
      $cast = $this->castService->save($request->all());
      return response()->json([
          'status' => (bool) $cast,
          'message' => $cast ? 'Cast Created' : 'Error Creating Cast',
          'created' => $cast
          ]);
    }

    public function show($id)
    {
      return $this->castService->show($id);
    }

    public function update(Request $request)
    {
      $cast = $this->castService->save($request->all());
        return response()->json([
            'status' => (bool) $cast,
            'message' => $cast ? 'Cast Updated' : 'Error Updating Cast']);
    }

    public function destroy($id)
    {
      $this->castService->exclude($id);
      return response()->json(null, 204);
    }
}
