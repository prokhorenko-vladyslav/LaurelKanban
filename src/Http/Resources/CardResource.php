<?php

namespace Laurel\Kanban\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Laurel\Kanban\Kanban;

class CardResource extends JsonResource
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
            'order' => $this->order,
        ];
    }
}
