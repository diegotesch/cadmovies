<?php
namespace App\Services;

use App\Athor;

interface AthorService
{
    public function __construct(Athor $athor);
    public function index();
    public function show($id);
    public function save(Array $data);
    public function exclude($id);
}
