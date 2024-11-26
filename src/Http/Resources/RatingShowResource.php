<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingRating;
use Module\System\Http\Resources\UserLogActivity;

class RatingShowResource extends JsonResource
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
            'record' => TrainingRating::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingRating::mapCombos($request, $this),

                'icon' => TrainingRating::getPageIcon('training-rating'),

                'key' => TrainingRating::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingRating::mapStatuses($request, $this),

                'title' => TrainingRating::getPageTitle($request, 'training-rating'),
            ],
        ];
    }
}
