<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingOfficial;
use Module\System\Http\Resources\UserLogActivity;

class OfficialShowResource extends JsonResource
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
            'record' => TrainingOfficial::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingOfficial::mapCombos($request, $this),

                'icon' => TrainingOfficial::getPageIcon('training-official'),

                'key' => TrainingOfficial::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingOfficial::mapStatuses($request, $this),

                'title' => TrainingOfficial::getPageTitle($request, 'training-official'),
            ],
        ];
    }
}
