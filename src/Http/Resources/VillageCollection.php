<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingVillage;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VillageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return VillageResource::collection($this->collection);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        if ($request->has('initialized')) {
            return [];
        }

        return [
            'setups' => [
                /** the page combo */
                'combos' => TrainingVillage::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingVillage::mapFilters(),

                /** the table header */
                'headers' => TrainingVillage::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingVillage::getPageIcon('training-village'),

                /** the record key */
                'key' => TrainingVillage::getDataKey(),

                /** the page default */
                'recordBase' => TrainingVillage::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingVillage::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingVillage::getPageTitle($request, 'training-village'),

                /** the usetrash flag */
                'usetrash' => TrainingVillage::hasSoftDeleted(),
            ]
        ];
    }
}
