<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingMember;
use Module\System\Http\Resources\UserLogActivity;

class MemberShowResource extends JsonResource
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
            'record' => TrainingMember::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingMember::mapCombos($request, $this),

                'icon' => TrainingMember::getPageIcon('training-member'),

                'key' => TrainingMember::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingMember::mapStatuses($request, $this),

                'title' => TrainingMember::getPageTitle($request, 'training-member'),
            ],
        ];
    }
}
