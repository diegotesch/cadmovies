<?php
namespace App\Services;

use App\Cast;

interface CastService
{
    public function __construct(Cast $cast);
    public function index();
    public function show($id);
    public function save(Array $data);
    public function exclude($id);
}
