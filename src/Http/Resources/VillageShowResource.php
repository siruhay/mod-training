<?php

namespace Module\Training\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Training\Models\TrainingVillage;
use Module\System\Http\Resources\UserLogActivity;

class VillageShowResource extends JsonResource
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
            'record' => TrainingVillage::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => TrainingVillage::mapCombos($request, $this),

                'icon' => TrainingVillage::getPageIcon('training-village'),

                'key' => TrainingVillage::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => TrainingVillage::mapStatuses($request, $this),

                'title' => TrainingVillage::getPageTitle($request, 'training-village'),
            ],
        ];
    }
}
