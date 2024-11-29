<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingCommittee;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommitteeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return CommitteeResource::collection($this->collection);
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
                'combos' => TrainingCommittee::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingCommittee::mapFilters(),

                /** the table header */
                'headers' => TrainingCommittee::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingCommittee::getPageIcon('training-committee'),

                /** the record key */
                'key' => TrainingCommittee::getDataKey(),

                /** the page default */
                'recordBase' => TrainingCommittee::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingCommittee::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingCommittee::getPageTitle($request, 'training-committee'),

                /** the usetrash flag */
                'usetrash' => TrainingCommittee::hasSoftDeleted(),
            ]
        ];
    }
}
