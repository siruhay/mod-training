<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingSubdistrict;
use Module\System\Http\Resources\UserLogActivity;

class SubdistrictShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            /**
             * the record data
             */
            'record' => TrainingSubdistrict::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingSubdistrict::mapCombos($request, $this),

                'icon' => TrainingSubdistrict::getPageIcon('training-subdistrict'),

                'key' => TrainingSubdistrict::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingSubdistrict::mapStatuses($request, $this),

                'title' => TrainingSubdistrict::getPageTitle($request, 'training-subdistrict'),
            ],
        ];
    }
}
