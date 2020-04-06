<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return $this->categoryService->index();
    }

    public function store(Request $request)
    {
        $category = $this->categoryService->save($request->all());
        return response()->json([
            'status' => (bool) $category,
            'message' => $category ? 'Category Created' : 'Error Creating Category']);
    }

    public function show($id)
    {
        return $this->categoryService->show($id);
    }


    public function update(Request $request)
    {
        $category = $this->categoryService->save($request->all());
        return response()->json([
            'status' => (bool) $category,
            'message' => $category ? 'Category Updated' : 'Error Updating Category']);
    }

    public function destroy($id)
    {
        $this->categoryService->exclude($id);
        return response()->json(null, 204);
    }
}
