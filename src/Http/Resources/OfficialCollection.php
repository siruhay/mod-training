<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingOfficial;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OfficialCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return OfficialResource::collection($this->collection);
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
                'combos' => TrainingOfficial::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingOfficial::mapFilters(),

                /** the table header */
                'headers' => TrainingOfficial::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingOfficial::getPageIcon('training-official'),

                /** the record key */
                'key' => TrainingOfficial::getDataKey(),

                /** the page default */
                'recordBase' => TrainingOfficial::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingOfficial::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingOfficial::getPageTitle($request, 'training-official'),

                /** the usetrash flag */
                'usetrash' => TrainingOfficial::hasSoftDeleted(),
            ]
        ];
    }
}
