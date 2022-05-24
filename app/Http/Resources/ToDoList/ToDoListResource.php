<?php

namespace App\Http\Resources\ToDoList;

use Illuminate\Http\Resources\Json\JsonResource;

class ToDoListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /* @var \App\Models\ToDoList\ToDoList|self $this */

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'priority'    => $this->priority,
            'create_at'   => $this->created_at?->timestamp,
            'complete_at' => $this->complete_at?->timestamp,

        ];
    }
}
