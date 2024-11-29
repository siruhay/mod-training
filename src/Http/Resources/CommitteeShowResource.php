<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingCommittee;
use Module\System\Http\Resources\UserLogActivity;

class CommitteeShowResource extends JsonResource
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
            'record' => TrainingCommittee::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingCommittee::mapCombos($request, $this),

                'icon' => TrainingCommittee::getPageIcon('training-committee'),

                'key' => TrainingCommittee::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingCommittee::mapStatuses($request, $this),

                'title' => TrainingCommittee::getPageTitle($request, 'training-committee'),
            ],
        ];
    }
}
