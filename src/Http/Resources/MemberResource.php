<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingMember;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TrainingMember::mapResource($request, $this);
    }
}
