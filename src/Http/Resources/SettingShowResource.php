<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingSetting;
use Module\System\Http\Resources\UserLogActivity;

class SettingShowResource extends JsonResource
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
            'record' => TrainingSetting::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingSetting::mapCombos($request, $this),

                'icon' => TrainingSetting::getPageIcon('training-setting'),

                'key' => TrainingSetting::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingSetting::mapStatuses($request, $this),

                'title' => TrainingSetting::getPageTitle($request, 'training-setting'),
            ],
        ];
    }
}
