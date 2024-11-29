<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingPresence;
use Module\System\Http\Resources\UserLogActivity;

class PresenceShowResource extends JsonResource
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
            'record' => TrainingPresence::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingPresence::mapCombos($request, $this),

                'icon' => TrainingPresence::getPageIcon('training-presence'),

                'key' => TrainingPresence::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingPresence::mapStatuses($request, $this),

                'title' => TrainingPresence::getPageTitle($request, 'training-presence'),
            ],
        ];
    }
}
