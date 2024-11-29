<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingRundown;
use Module\System\Http\Resources\UserLogActivity;

class RundownShowResource extends JsonResource
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
            'record' => TrainingRundown::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingRundown::mapCombos($request, $this),

                'icon' => TrainingRundown::getPageIcon('training-rundown'),

                'key' => TrainingRundown::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingRundown::mapStatuses($request, $this),

                'title' => TrainingRundown::getPageTitle($request, 'training-rundown'),
            ],
        ];
    }
}
