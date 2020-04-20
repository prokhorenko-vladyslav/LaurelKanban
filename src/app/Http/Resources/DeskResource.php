<?php

namespace Laurel\Kanban\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeskResource extends JsonResource
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
            'description' => $this->description,
            'is_favorite' => $this->is_favorite,
            'is_private' => $this->is_private,
            'collumns' => CollumnResource::collection($this->whenLoaded('collumns'))
        ];
    }
}
