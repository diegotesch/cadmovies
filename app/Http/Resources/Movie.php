<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Movie extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
          'id' => $this->id,
          'name' => $this->name,
          'starring' => $this->starring,
          'profit' => $this->profit,
          'category_id' => $this->category->id,
          'category_name' => $this->category->name,
          'cast' => $this->cast
      ];
    }
}
