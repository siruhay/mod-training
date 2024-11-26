<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingAnswer;
use Module\System\Http\Resources\UserLogActivity;

class AnswerShowResource extends JsonResource
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
            'record' => TrainingAnswer::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingAnswer::mapCombos($request, $this),

                'icon' => TrainingAnswer::getPageIcon('training-answer'),

                'key' => TrainingAnswer::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingAnswer::mapStatuses($request, $this),

                'title' => TrainingAnswer::getPageTitle($request, 'training-answer'),
            ],
        ];
    }
}
