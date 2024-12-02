<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingMember;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MemberCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MemberResource::collection($this->collection);
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
                'combos' => TrainingMember::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingMember::mapFilters(),

                /** the table header */
                'headers' => TrainingMember::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingMember::getPageIcon('training-member'),

                /** the record key */
                'key' => TrainingMember::getDataKey(),

                /** the page default */
                'recordBase' => TrainingMember::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingMember::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingMember::getPageTitle($request, 'training-member'),

                /** the usetrash flag */
                'usetrash' => TrainingMember::hasSoftDeleted(),
            ]
        ];
    }
}
