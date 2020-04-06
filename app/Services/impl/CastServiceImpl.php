<?php

namespace App\Services\impl;

use App\Services\CastService;
use App\Cast;
use App\Athor;
use App\Http\Resources\Cast as CastResource;
use phpDocumentor\Reflection\Types\Boolean;

class CastServiceImpl implements CastService
{
    protected $cast;

    public function __construct(Cast $cast)
    {
      $this->cast = $cast;
    }

    public function index()
    {
      return CastResource::collection(Cast::all());
    }

    public function show($id)
    {
      return new CastResource(Cast::findOrFail($id));
    }

    public function save(Array $data)
    {
      $castData = isset($data[0]) ? $data[0] : $data;
      if (!isset($castData['id'])) {
          return $this->store($data);
      }
      return $this->update($data);
    }

    public function exclude($id)
    {
      $cast = Cast::findOrFail($id);
      return $cast->delete();
    }

    private function store(Array $data)
    {
      $castData = isset($data[0]) ? $data[0] : $data;
      $cast = Cast::create($castData);
      if (isset($data[1])) {
        $cast->athors()->sync($data[1]);
      }

      return $cast;
    }

    private function update(Array $data)
    {
      $castData = isset($data[0]) ? $data[0] : $data;
      $cast = Cast::findOrFail($castData['id']);
      $cast->update($data);

      if (isset($data[1])) {
        $cast->athors()->sync($data[1]);
      }
      return $cast;
    }
}
