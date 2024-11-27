<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingPresence;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PresenceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return PresenceResource::collection($this->collection);
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
                'combos' => TrainingPresence::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingPresence::mapFilters(),

                /** the table header */
                'headers' => TrainingPresence::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingPresence::getPageIcon('training-presence'),

                /** the record key */
                'key' => TrainingPresence::getDataKey(),

                /** the page default */
                'recordBase' => TrainingPresence::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingPresence::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingPresence::getPageTitle($request, 'training-presence'),

                /** the usetrash flag */
                'usetrash' => TrainingPresence::hasSoftDeleted(),
            ]
        ];
    }
}
