<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingEvent;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TrainingEvent::mapResource($request, $this);
    }
}
