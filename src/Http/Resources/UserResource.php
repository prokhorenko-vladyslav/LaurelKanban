<?php

namespace Laurel\Kanban\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Laurel\Kanban\Kanban;

class UserResource extends JsonResource
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
            'name' => $this->name
        ];
    }
}
