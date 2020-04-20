<?php

namespace Laurel\Kanban\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Laurel\Kanban\App\Kanban;

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
