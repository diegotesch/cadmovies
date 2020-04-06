<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cast extends JsonResource
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
            'movie_id' => $this->movie->id,
            'athors' => $this->athors->pluck('id'),
            'athors_names' => $this->athors->pluck('name')
        ];
    }
}
