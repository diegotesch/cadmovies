<?php

namespace App\Services\impl;

use App\Services\AthorService;
use App\Athor;
use App\Http\Resources\Athor as AthorResource;
use phpDocumentor\Reflection\Types\Boolean;

class AthorServiceImpl implements AthorService
{
    protected $athor;

    public function __construct(Athor $athor)
    {
        $this->athor = $athor;
    }

    public function index()
    {
        return AthorResource::collection(Athor::all());
    }

    public function show($id)
    {
        return new AthorResource(Athor::findOrFail($id));
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
        $athor = Athor::findOrFail($id);
        return $athor->delete();
    }

    private function store(Array $data)
    {
        return Athor::create($data);
    }

    private function update(Array $data)
    {
        $athor = Athor::findOrFail($data['id']);
        $athor->update($data);
        return $athor;
    }
}
