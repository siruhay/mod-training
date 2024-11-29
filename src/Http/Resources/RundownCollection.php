<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingRundown;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RundownCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return RundownResource::collection($this->collection);
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
                'combos' => TrainingRundown::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingRundown::mapFilters(),

                /** the table header */
                'headers' => TrainingRundown::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingRundown::getPageIcon('training-rundown'),

                /** the record key */
                'key' => TrainingRundown::getDataKey(),

                /** the page default */
                'recordBase' => TrainingRundown::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingRundown::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingRundown::getPageTitle($request, 'training-rundown'),

                /** the usetrash flag */
                'usetrash' => TrainingRundown::hasSoftDeleted(),
            ]
        ];
    }
}
