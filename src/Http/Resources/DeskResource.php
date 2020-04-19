<?php

namespace Laurel\Kanban\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Laurel\Kanban\Kanban;
use Laurel\Kanban\Http\Resources\CollumnResource;

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
            'name' => $this->name,
            'description' => $this->description,
            'is_favorite' => $this->is_favorite,
            'is_private' => $this->is_private,
            'collumns' => CollumnResource::collection($this->whenLoaded('collumns'))
        ];
    }
}
