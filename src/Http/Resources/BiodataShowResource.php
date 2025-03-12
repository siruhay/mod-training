<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingBiodata;
use Module\System\Http\Resources\UserLogActivity;

class BiodataShowResource extends JsonResource
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
            'record' => TrainingBiodata::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingBiodata::mapCombos($request, $this),

                'icon' => TrainingBiodata::getPageIcon('training-biodata'),

                'key' => TrainingBiodata::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingBiodata::mapStatuses($request, $this),

                'title' => TrainingBiodata::getPageTitle($request, 'training-biodata'),
            ],
        ];
    }
}
