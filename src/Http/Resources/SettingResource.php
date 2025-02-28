<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TrainingSetting::mapResource($request, $this);
    }
}
