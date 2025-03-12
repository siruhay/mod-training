<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingBiodata;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BiodataCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return BiodataResource::collection($this->collection);
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
                'combos' => TrainingBiodata::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingBiodata::mapFilters(),

                /** the table header */
                'headers' => TrainingBiodata::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingBiodata::getPageIcon('training-biodata'),

                /** the record key */
                'key' => TrainingBiodata::getDataKey(),

                /** the page default */
                'recordBase' => TrainingBiodata::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingBiodata::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingBiodata::getPageTitle($request, 'training-biodata'),

                /** the usetrash flag */
                'usetrash' => TrainingBiodata::hasSoftDeleted(),
            ]
        ];
    }
}
