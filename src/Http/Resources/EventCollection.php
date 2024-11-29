<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingEvent;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EventCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return EventResource::collection($this->collection);
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
                'combos' => TrainingEvent::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingEvent::mapFilters(),

                /** the table header */
                'headers' => TrainingEvent::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingEvent::getPageIcon('training-event'),

                /** the record key */
                'key' => TrainingEvent::getDataKey(),

                /** the page default */
                'recordBase' => TrainingEvent::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingEvent::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingEvent::getPageTitle($request, 'training-event'),

                /** the usetrash flag */
                'usetrash' => TrainingEvent::hasSoftDeleted(),
            ]
        ];
    }
}
