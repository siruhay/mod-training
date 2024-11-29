<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingSubdistrict;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SubdistrictCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return SubdistrictResource::collection($this->collection);
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
                'combos' => TrainingSubdistrict::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingSubdistrict::mapFilters(),

                /** the table header */
                'headers' => TrainingSubdistrict::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingSubdistrict::getPageIcon('training-subdistrict'),

                /** the record key */
                'key' => TrainingSubdistrict::getDataKey(),

                /** the page default */
                'recordBase' => TrainingSubdistrict::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingSubdistrict::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingSubdistrict::getPageTitle($request, 'training-subdistrict'),

                /** the usetrash flag */
                'usetrash' => TrainingSubdistrict::hasSoftDeleted(),
            ]
        ];
    }
}
