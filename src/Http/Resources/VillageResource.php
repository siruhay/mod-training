<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingVillage;
use Illuminate\Http\Resources\Json\JsonResource;

class VillageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TrainingVillage::mapResource($request, $this);
    }
}
