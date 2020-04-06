<?php

namespace App\Services\impl;

use App\Services\CategoryService;
use App\Category;
use App\Http\Resources\Category as CategoryResource;
use phpDocumentor\Reflection\Types\Boolean;

class CategoryServiceImpl implements CategoryService
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function show($id)
    {
        return new CategoryResource(Category::findOrFail($id));
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
        $category = Category::findOrFail($id);
        return $category->delete();
    }

    private function store(Array $data)
    {
        return Category::create($data);
    }

    private function update(Array $data)
    {
        $category = Category::findOrFail($data['id']);
        $category->update($data);
        return $category;
    }
}
