<?php
namespace App\Services;

use App\Category;

interface CategoryService
{
    public function __construct(Category $category);
    public function index();
    public function show($id);
    public function save(Array $data);
    public function exclude($id);
}
