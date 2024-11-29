<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingQuestion;
use Module\System\Http\Resources\UserLogActivity;

class QuestionShowResource extends JsonResource
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
            'record' => TrainingQuestion::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingQuestion::mapCombos($request, $this),

                'icon' => TrainingQuestion::getPageIcon('training-question'),

                'key' => TrainingQuestion::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingQuestion::mapStatuses($request, $this),

                'title' => TrainingQuestion::getPageTitle($request, 'training-question'),
            ],
        ];
    }
}
