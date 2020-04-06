<?php

namespace App\Http\Controllers;

use App\Services\AthorService;
use Illuminate\Http\Request;

class AthorController extends Controller
{
    protected $athorService;

    public function __construct(AthorService $athorService)
    {
        $this->athorService = $athorService;
    }

    public function index()
    {
      return $this->athorService->index();
    }


    public function store(Request $request)
    {
        $athor = $this->athorService->save($request->all());
        return response()->json([
          'status' => (bool) $athor,
          'message' => $athor ? 'Athor created' : 'Error creating athor'
        ]);
    }

    public function show($id)
    {
        return $this->athorService->show($id);
    }


    public function update(Request $request)
    {
      $athor = $this->athorService->save($request->all());
      return response()->json([
          'status' => (bool) $athor,
          'message' => $athor ? 'Athor Updated' : 'Error Updating Athor']);
    }

    public function destroy($id)
    {
        $this->athorService->exclude($id);
        return response()->json(null, 204);
    }
}
