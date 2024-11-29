<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingParticipant;
use Module\System\Http\Resources\UserLogActivity;

class ParticipantShowResource extends JsonResource
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
            'record' => TrainingParticipant::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingParticipant::mapCombos($request, $this),

                'icon' => TrainingParticipant::getPageIcon('training-participant'),

                'key' => TrainingParticipant::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingParticipant::mapStatuses($request, $this),

                'title' => TrainingParticipant::getPageTitle($request, 'training-participant'),
            ],
        ];
    }
}
