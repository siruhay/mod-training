<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingEvent;
use Module\System\Http\Resources\UserLogActivity;

class EventShowResource extends JsonResource
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
            'record' => TrainingEvent::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingEvent::mapCombos($request, $this),

                'icon' => TrainingEvent::getPageIcon('training-event'),

                'key' => TrainingEvent::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingEvent::mapStatuses($request, $this),

                'title' => TrainingEvent::getPageTitle($request, 'training-event'),
            ],
        ];
    }
}
