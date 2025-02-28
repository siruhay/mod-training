<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingSetting;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return SettingResource::collection($this->collection);
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
                'combos' => TrainingSetting::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingSetting::mapFilters(),

                /** the table header */
                'headers' => TrainingSetting::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingSetting::getPageIcon('training-setting'),

                /** the record key */
                'key' => TrainingSetting::getDataKey(),

                /** the page default */
                'recordBase' => TrainingSetting::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingSetting::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingSetting::getPageTitle($request, 'training-setting'),

                /** the usetrash flag */
                'usetrash' => TrainingSetting::hasSoftDeleted(),
            ]
        ];
    }
}
